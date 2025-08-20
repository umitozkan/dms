<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::withCount(['shows', 'dubbings'])
            ->orderBy('name')
            ->get();
            
        // Toplam istatistikler
        $stats = [
            'total_companies' => $companies->count(),
            'total_shows' => $companies->sum('shows_count'),
            'total_dubbings' => $companies->sum('dubbings_count'),
            'total_revenue' => Income::sum('revenue'),
            'total_cost' => Income::sum('merzigo_cost'),
        ];
        
        return view('companies.index', compact('companies', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('companies.index')->with('error', 'Access denied.');
        }
        
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('companies.index')->with('error', 'Access denied.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'source' => 'required|in:Merzigo,Solar',
        ]);

        Company::create($request->all());

        return redirect()->route('companies.index')->with('success', 'Şirket başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load([
            'shows.dubbings.language',
            'shows.dubbings.incomes',
            'shows.dubbings.materials',
        ]);
        
        // Şirket istatistikleri
        $stats = [
            'total_shows' => $company->shows->count(),
            'total_dubbings' => $company->dubbings->count(),
            'total_materials' => $company->dubbings->sum(function($dubbing) {
                return $dubbing->materials->count();
            }),
            'total_income' => Income::whereHas('dubbing.show', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->sum('revenue'),
            'total_cost' => Income::whereHas('dubbing.show', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->sum('merzigo_cost'),
        ];
        
        return view('companies.show', compact('company', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('companies.index')->with('error', 'Access denied.');
        }

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('companies.index')->with('error', 'Access denied.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'source' => 'required|in:Merzigo,Solar',
        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')->with('success', 'Şirket başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if (!Auth::user()->canDelete()) {
            return redirect()->route('companies.index')->with('error', 'Access denied.');
        }

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
