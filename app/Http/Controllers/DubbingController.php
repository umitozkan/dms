<?php

namespace App\Http\Controllers;

use App\Models\Dubbing;
use App\Models\Show;
use App\Models\Language;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DubbingController extends Controller
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
        $dubbings = Dubbing::with(['show.company', 'language', 'incomes'])
            ->withSum('incomes', 'revenue')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Toplam istatistikler (gelir/gider olmadan)
        $stats = [
            'total_dubbings' => $dubbings->count(),
            'total_duration' => $dubbings->sum('duration'),
            'total_received' => $dubbings->sum('received_episodes'),
            'total_published' => $dubbings->sum('published_episodes'),
        ];
        
        return view('dubbings.index', compact('dubbings', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('dubbings.index')->with('error', 'Erişim reddedildi.');
        }

        $shows = Show::with('company')->get();
        $languages = Language::orderBy('name')->get(['code','name']);
        $studios = Studio::all();
        return view('dubbings.create', compact('shows', 'languages', 'studios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('dubbings.index')->with('error', 'Erişim reddedildi.');
        }

        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'language_code' => 'required|exists:languages,code',
            'studio_id' => 'required|exists:studios,id',
            'duration' => 'required|integer|min:1',
            'received_episodes' => 'nullable|integer|min:0',
            'downloaded_episodes' => 'nullable|integer|min:0',
            'published_episodes' => 'nullable|integer|min:0',
            'status' => 'required|in:material_waiting,dubbing,published,completed,in_progress',
            'notes' => 'nullable|string',
        ]);

        Dubbing::create($request->only([
            'show_id','language_code','studio_id','duration','received_episodes','downloaded_episodes','published_episodes','status','notes'
        ]));

        return redirect()->route('dubbings.index')->with('success', 'Dublaj başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dubbing $dubbing)
    {
        $dubbing->load(['show.company', 'language', 'incomes']);
        return view('dubbings.show', compact('dubbing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dubbing $dubbing)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('dubbings.index')->with('error', 'Erişim reddedildi.');
        }

        $shows = Show::with('company')->get();
        $languages = Language::orderBy('name')->get(['code','name']);
        $studios = Studio::all();
        return view('dubbings.edit', compact('dubbing', 'shows', 'languages', 'studios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dubbing $dubbing)
    {
        if (!Auth::user()->canEdit()) {
            return redirect()->route('dubbings.index')->with('error', 'Access denied.');
        }

        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'language_code' => 'required|exists:languages,code',
            'studio_id' => 'required|exists:studios,id',
            'duration' => 'required|integer|min:1',
            'received_episodes' => 'nullable|integer|min:0',
            'downloaded_episodes' => 'nullable|integer|min:0',
            'published_episodes' => 'nullable|integer|min:0',
            'status' => 'required|in:material_waiting,dubbing,published,completed,in_progress',
            'notes' => 'nullable|string',
        ]);

        $dubbing->update($request->only([
            'show_id','language_code','studio_id','duration','received_episodes','downloaded_episodes','published_episodes','status','notes'
        ]));

        return redirect()->route('dubbings.index')->with('success', 'Dublaj başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dubbing $dubbing)
    {
        if (!Auth::user()->canDelete()) {
            return redirect()->route('dubbings.index')->with('error', 'Erişim reddedildi.');
        }

        $dubbing->delete();

        return redirect()->route('dubbings.index')->with('success', 'Dublaj başarıyla silindi.');
    }
}
