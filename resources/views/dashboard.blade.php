@extends('layouts.app')

@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Main Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="mCard">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Şirketler') }}</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_companies'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ __('Aktif ortaklar') }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mCard">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Yapımlar') }}</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_shows'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ __('Üretimde') }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-gradient-to-br from-green-500 to-green-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mCard">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Dublajlar') }}</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_dubbings'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ __('Tamamlanan projeler') }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mCard">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Materyaller') }}</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_materials'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ __('Toplam varlık') }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['total_languages'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Desteklenen Dil') }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">{{ $stats['materials_with_script'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Script Dosyası Olan') }}</div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['materials_with_ae'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('AE Dosyası Olan') }}</div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Recent Dubbings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ __('Son Dublajlar') }}</h3>
                            <a href="{{ route('dubbings.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                {{ __('Tümünü görüntüle') }} →
                            </a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recent_dubbings as $dubbing)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ substr($dubbing->show->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $dubbing->show->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $dubbing->language->name }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-500">{{ $dubbing->duration }}min</div>
                                    <div class="text-xs text-gray-400">{{ $dubbing->created_at->format('d.m.Y') }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Materials -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ __('Son Materyaller') }}</h3>
                            <a href="{{ route('materials.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                {{ __('Tümünü görüntüle') }} →
                            </a>
                        </div>
                        <div class="space-y-4">
                            @foreach($recent_materials as $material)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">{{ $material->file_type }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $material->dubbing->show->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $material->dubbing->language->name }}</div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    @if($material->script_exists)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ✓ {{ __('Senaryo') }}
                                        </span>
                                    @endif
                                    @if($material->ae_file_exists)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            ✓ {{ __('AE') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Companies -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">{{ __('En Aktif Şirketler') }}</h3>
                        <a href="{{ route('companies.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            {{ __('Tümünü görüntüle') }} →
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($top_companies as $company)
                        <div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr($company->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $company->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $company->shows_count }} {{ __('dizi') }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
