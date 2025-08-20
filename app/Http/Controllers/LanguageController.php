<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
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
        $languages = Language::withCount(['dubbings'])->get();

        $stats = [
            'total_languages' => $languages->count(),
            'total_dubbings' => $languages->sum('dubbings_count'),
            'active_languages' => $languages->where('dubbings_count', '>', 0)->count(),
        ];

        return view('languages.index', compact('languages', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('languages.index')->with('error', 'Access denied.');
        }

        return view('languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('languages.index')->with('error', 'Access denied.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:languages',
        ]);

        Language::create($request->all());

        return redirect()->route('languages.index')->with('success', 'Language created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        $language->load('dubbings.show.company');
        return view('languages.show', compact('language'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('languages.index')->with('error', 'Access denied.');
        }

        return view('languages.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('languages.index')->with('error', 'Access denied.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:languages,name,' . $language->id,
        ]);

        $language->update($request->all());

        return redirect()->route('languages.index')->with('success', 'Language updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        if (!Auth::user()->canDelete()) {
            return redirect()->route('languages.index')->with('error', 'Access denied.');
        }

        $language->delete();

        return redirect()->route('languages.index')->with('success', 'Language deleted successfully.');
    }
}
