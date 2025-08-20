<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Dubbing;
use App\Models\Studio;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::with(['dubbing.show.company', 'dubbing.language'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Toplam istatistikler
        $stats = [
            'total_materials' => Material::count(),
            'materials_with_script' => Material::where('script_exists', true)->count(),
            'materials_with_ae' => Material::where('ae_file_exists', true)->count(),
            'completed_materials' => Material::where('status', 'completed')->count(),
            'sent_to_studio' => Material::where('status', 'sent_to_studio')->count(),
        ];
        
        return view('materials.index', compact('materials', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $dubbings = Dubbing::with(['show', 'language'])->get();
        $selected_dubbing_id = $request->get('dubbing_id');
        return view('materials.create', compact('dubbings', 'selected_dubbing_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dubbing_id' => 'required|exists:dubbings,id',
            'file_type' => 'required|string|max:255',
            'season_number' => 'nullable|integer|min:1',
            'episode_number' => 'nullable|integer|min:1',
            'script_exists' => 'boolean',
            'ae_file_exists' => 'boolean',
            'file_duration' => 'nullable|integer|min:1',
            'video_path' => 'nullable|string|max:500',
            'script_file_path' => 'nullable|string|max:500',
            'ae_file_path' => 'nullable|string|max:500',
            'status' => 'required|in:sent_to_studio,completed',
            'duration' => 'nullable|integer|min:1',
            'studio_start_date' => 'nullable|date',
            'studio_end_date' => 'nullable|date|after_or_equal:studio_start_date',
            'received_from_producer' => 'nullable|date',
            'unit_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Material::create($validated);

        return redirect()->route('materials.index')
            ->with('success', 'Materyal başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        $material->load(['dubbing.show', 'dubbing.language']);
        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $dubbings = Dubbing::with(['show', 'language'])->get();
        return view('materials.edit', compact('material', 'dubbings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'dubbing_id' => 'required|exists:dubbings,id',
            'file_type' => 'required|string|max:255',
            'season_number' => 'nullable|integer|min:1',
            'episode_number' => 'nullable|integer|min:1',
            'script_exists' => 'boolean',
            'ae_file_exists' => 'boolean',
            'file_duration' => 'nullable|integer|min:1',
            'video_path' => 'nullable|string|max:500',
            'script_file_path' => 'nullable|string|max:500',
            'ae_file_path' => 'nullable|string|max:500',
            'status' => 'required|in:sent_to_studio,completed',
            'duration' => 'nullable|integer|min:1',
            'studio_start_date' => 'nullable|date',
            'studio_end_date' => 'nullable|date|after_or_equal:studio_start_date',
            'received_from_producer' => 'nullable|date',
            'unit_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $material->update($validated);

        return redirect()->route('materials.index')
            ->with('success', 'Materyal başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Materyal başarıyla silindi.');
    }
}
