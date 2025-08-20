<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Show;
use App\Models\Language;
use App\Models\Dubbing;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $stats = [
            'total_companies' => Company::count(),
            'total_shows' => Show::count(),
            'total_languages' => Language::count(),
            'total_dubbings' => Dubbing::count(),
            'total_materials' => Material::count(),
            'materials_with_script' => Material::where('script_exists', true)->count(),
            'materials_with_ae' => Material::where('ae_file_exists', true)->count(),
        ];

        $recent_dubbings = Dubbing::with(['show.company', 'language'])
            ->latest()
            ->take(5)
            ->get();

        $recent_materials = Material::with(['dubbing.show.company', 'dubbing.language'])
            ->latest()
            ->take(5)
            ->get();

        $top_companies = Company::withCount('shows')
            ->orderBy('shows_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_dubbings', 'recent_materials', 'top_companies'));
    }
}
