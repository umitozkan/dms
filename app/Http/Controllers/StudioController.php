<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Dubbing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::orderBy('name')->paginate(10);

        $stats = [
            'total_studios' => Studio::count(),
            'total_dubbings' => Dubbing::count(),
            'countries' => Studio::whereNotNull('country')->where('country', '<>', '')->distinct('country')->count('country'),
        ];

        return view('studios.index', compact('studios', 'stats'));
    }

    public function create()
    {
        return view('studios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        Studio::create($validated);

        return redirect()->route('studios.index')
            ->with('success', 'Stüdyo başarıyla oluşturuldu.');
    }

    public function show(Studio $studio)
    {
        $studio->load(['dubbings.show', 'dubbings.language']);
        return view('studios.show', compact('studio'));
    }

    public function edit(Studio $studio)
    {
        return view('studios.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $studio->update($validated);

        return redirect()->route('studios.index')
            ->with('success', 'Stüdyo başarıyla güncellendi.');
    }

    public function destroy(Studio $studio)
    {
        $studio->delete();

        return redirect()->route('studios.index')
            ->with('success', 'Stüdyo başarıyla silindi.');
    }
}
