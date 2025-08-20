<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Company;
use Illuminate\Http\Request;

class ShowController extends Controller
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
        $shows = Show::with(['company'])
            ->withCount(['dubbings'])
            ->orderBy('name')
            ->get();
            
        // Toplam istatistikler
        $stats = [
            'total_shows' => $shows->count(),
            'total_dubbings' => $shows->sum('dubbings_count'),
            'total_revenue' => 0,
            'total_cost' => 0,
        ];
        
        return view('shows.index', compact('shows', 'stats'));
    }

    public function create()
    {
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized action.');
        }

        $companies = Company::orderBy('name')->get();
        return view('shows.create', compact('companies'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'channelId' => 'nullable|string|max:255',
            'type' => 'required|in:series,movie,documentary',
            'total_episode' => 'required_if:type,series|nullable|integer|min:1',
            'total_duration' => 'nullable|integer|min:1',
        ]);

        Show::create($request->all());

        return redirect()->route('shows.index')
            ->with('success', 'Yapım başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Show $show)
    {
        $show->load([
            'company', 
            'dubbings.language',
            'dubbings.incomes',
            'dubbings.materials'
        ]);
        
        // Show istatistikleri
        $stats = [
            'total_dubbings' => $show->dubbings->count(),
            'total_materials' => $show->dubbings->sum(function($dubbing) {
                return $dubbing->materials->count();
            }),
            'total_income' => $show->dubbings->sum(function($dubbing) {
                return $dubbing->incomes->sum('revenue');
            }),
            'total_cost' => $show->dubbings->sum('merzigo_cost'),
        ];
        
        return view('shows.show', compact('show', 'stats'));
    }

    public function edit(Show $show)
    {
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized action.');
        }

        $companies = Company::orderBy('name')->get();
        return view('shows.edit', compact('show', 'companies'));
    }

    public function update(Request $request, Show $show)
    {
        if (!auth()->user()->canEdit()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'channelId' => 'nullable|string|max:255',
            'type' => 'required|in:series,movie,documentary',
            'total_episode' => 'required_if:type,series|nullable|integer|min:1',
            'total_duration' => 'nullable|integer|min:1',
        ]);

        $show->update($request->all());

        return redirect()->route('shows.index')
            ->with('success', 'Yapım başarıyla güncellendi.');
    }

    public function destroy(Show $show)
    {
        if (!auth()->user()->canDelete()) {
            abort(403, 'Unauthorized action.');
        }

        $show->delete();

        return redirect()->route('shows.index')
            ->with('success', 'Show deleted successfully.');
    }
}
