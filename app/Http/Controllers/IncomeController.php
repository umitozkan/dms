<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Dubbing;
use App\Models\Company;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(403, 'Bu sayfaya erişim yetkiniz yok.');
            }
            return $next($request);
        });
    }

    /**
     * Server-side DataTables endpoint
     */
    public function datatable(Request $request)
    {
        $companyId = $request->query('company_id');
        $startDate = $request->query('start');
        $endDate   = $request->query('end');

        $baseQuery = Income::with(['dubbing.show.company', 'dubbing.language']);
        if ($companyId) {
            $baseQuery->whereHas('dubbing.show', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }
        if ($startDate) {
            $baseQuery->whereDate('income_date', '>=', $startDate);
        }
        if ($endDate) {
            $baseQuery->whereDate('income_date', '<=', $endDate);
        }

        // Global search
        if ($search = $request->input('search.value')) {
            $baseQuery->where(function ($q) use ($search) {
                $q->whereHas('dubbing.show', fn($qs) => $qs->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('dubbing.language', fn($ql) => $ql->where('name', 'like', "%{$search}%"))
                  ;
            });
        }

        $columns = [
            'show', // virtual
            'language', // virtual
            'merzigo_cost',
            'price',
            'revenue',
            'income_date',
        ];

        $orderColIndex = (int)($request->input('order.0.column', 6));
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderCol = $columns[$orderColIndex] ?? 'income_date';
        if (in_array($orderCol, ['merzigo_cost','price','revenue','income_date'], true)) {
            $baseQuery->orderBy($orderCol, $orderDir);
        } else {
            $baseQuery->orderBy('income_date', 'desc');
        }

        $recordsTotal = Income::count();
        $recordsFiltered = (clone $baseQuery)->count();

        $start = (int)$request->input('start', 0);
        $length = (int)$request->input('length', 15);
        $data = (clone $baseQuery)->skip($start)->take($length)->get();

        $rows = $data->map(function(Income $income){
            return [
                'show' => [
                    'title' => $income->dubbing->show->name,
                    'company' => $income->dubbing->show->company->name ?? 'N/A',
                ],
                'language' => $income->dubbing->language->name ?? strtoupper($income->dubbing->language_code),
                'merzigo_cost' => number_format($income->merzigo_cost, 2, '.', ''),
                'price' => number_format($income->price, 2, '.', ''),
                'revenue' => number_format($income->revenue, 2, '.', ''),
                'difference' => number_format(($income->revenue - $income->price), 2, '.', ''),
                'income_date' => $income->income_date->format('Y-m-d'),
                'actions' => [
                    'show' => route('incomes.show', $income),
                    'edit' => route('incomes.edit', $income),
                    'delete' => route('incomes.destroy', $income),
                ],
            ];
        });

        return response()->json([
            'draw' => (int)$request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $rows,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companyId = $request->query('company_id');
        $startDate = $request->query('start');
        $endDate   = $request->query('end');
        $period    = $request->query('period', 'day'); // day | week | month

        if (!in_array($period, ['day', 'week', 'month'], true)) {
            $period = 'day';
        }

        // Not: Tablo sunucu tarafı DataTables ile yüklendiği için burada satırları çekmeye gerek yok
        // Grafikleri ve istatistikleri hesaplamak için yalnızca toplulaştırma sorguları kullanacağız
        $query = Income::query();

        if ($companyId) {
            $query->whereHas('dubbing.show', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }

        if ($startDate) {
            $query->whereDate('income_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('income_date', '<=', $endDate);
        }

        // Kayıtları çekmiyoruz; tablo server-side endpoint'ten gelecek

        // Aggregates with same filters
        $aggregate = Income::query();
        if ($companyId) {
            $aggregate->whereHas('dubbing.show', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }
        if ($startDate) {
            $aggregate->whereDate('income_date', '>=', $startDate);
        }
        if ($endDate) {
            $aggregate->whereDate('income_date', '<=', $endDate);
        }

        $total_revenue = (clone $aggregate)->sum('revenue');
        $total_price = (clone $aggregate)->sum('price');
        $total_merzigo_cost = (clone $aggregate)->sum('merzigo_cost');
        // Net kâr (her yerde): gelir - fiyat. Merzigo maliyeti sadece gösterim içindir.
        $total_profit = $total_revenue - $total_price;
        // Tablo "Fark": gelir - fiyat
        $total_difference = $total_revenue - $total_price;

        $stats = [
            'total_incomes' => (clone $aggregate)->count(),
            'total_revenue' => $total_revenue,
            'total_merzigo_cost' => $total_merzigo_cost,
            'total_price' => $total_price,
            'total_difference' => $total_difference,
            'total_profit' => $total_profit,
        ];

        // Time-series for chart (grouped by selected period)
        $dailyQuery = Income::query();
        if ($companyId) {
            $dailyQuery->whereHas('dubbing.show', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }
        if ($startDate) {
            $dailyQuery->whereDate('income_date', '>=', $startDate);
        }
        if ($endDate) {
            $dailyQuery->whereDate('income_date', '<=', $endDate);
        }

        // Determine grouping expression and label formatter
        switch ($period) {
            case 'week':
                // ISO year-week as key (e.g., 2025-33)
                $groupExpr = "DATE_FORMAT(income_date, '%x-%v')"; // ISO week-year
                $labelFormatter = function ($key) {
                    return $key; // e.g., 2025-33
                };
                break;
            case 'month':
                $groupExpr = "DATE_FORMAT(income_date, '%Y-%m')";
                $labelFormatter = function ($key) {
                    return $key; // e.g., 2025-08
                };
                break;
            case 'day':
            default:
                $groupExpr = 'DATE(income_date)';
                $labelFormatter = function ($key) {
                    return date('Y-m-d', strtotime($key));
                };
                break;
        }

        $daily = $dailyQuery
            ->selectRaw("{$groupExpr} as d, SUM(revenue) as revenue, SUM(price) as price, SUM(merzigo_cost) as cost")
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        $labels = $daily->pluck('d')->map($labelFormatter)->values();
        $seriesRevenue = $daily->pluck('revenue')->map(fn($v) => (float)$v)->values();
        $seriesPrice = $daily->pluck('price')->map(fn($v) => (float)$v)->values();
        // Merzigo maliyeti grafik üzerinde gösterilir (hesaplamaya dahil edilmez)
        $seriesCost = $daily->pluck('cost')->map(fn($v) => (float)$v)->values();
        // Grafik kâr serisi: gelir - fiyat
        $seriesProfit = $daily->map(fn($row) => (float)$row->revenue - (float)$row->price)->values();

        $companies = Company::orderBy('name')->get(['id','name']);

        return view('incomes.index', [
            'stats' => $stats,
            'companies' => $companies,
            'selectedCompanyId' => $companyId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'period' => $period,
            'chartLabels' => $labels,
            'chartRevenue' => $seriesRevenue,
            'chartPrice' => $seriesPrice,
            'chartCost' => $seriesCost,
            'chartProfit' => $seriesProfit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dubbings = Dubbing::with(['show', 'language'])->get();
        return view('incomes.create', compact('dubbings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dubbing_id' => 'required|exists:dubbings,id',
            'merzigo_cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'revenue' => 'required|numeric|min:0',
            'income_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:income_date',
            'notes' => 'nullable|string',
        ]);

        Income::create($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Gelir başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        $income->load(['dubbing.show', 'dubbing.language']);
        return view('incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        $dubbings = Dubbing::with(['show', 'language'])->get();
        return view('incomes.edit', compact('income', 'dubbings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $validated = $request->validate([
            'dubbing_id' => 'required|exists:dubbings,id',
            'merzigo_cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'revenue' => 'required|numeric|min:0',
            'income_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:income_date',
            'notes' => 'nullable|string',
        ]);

        $income->update($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Gelir başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index')
            ->with('success', 'Gelir başarıyla silindi.');
    }
}
