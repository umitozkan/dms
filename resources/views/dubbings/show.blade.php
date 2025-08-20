@extends('layouts.app')

@section('title', 'Dublaj Detayları')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Dublaj Detayları</h2>
                    <a href="{{ route('dubbings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Dublajlara Dön
                    </a>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold mb-4">Dublaj Bilgileri</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dizi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $dubbing->show->name }} ({{ $dubbing->show->company->name }})</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dil</label>
                            <p class="mt-1 text-sm text-gray-900">{{ optional($dubbing->language)->name ?? strtoupper($dubbing->language_code) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Süre</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $dubbing->duration }} dk</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fiyat</label>
                            <p class="mt-1 text-sm text-gray-900">${{ number_format($dubbing->price, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Merzigo Maliyeti</label>
                            <p class="mt-1 text-sm text-gray-900">${{ number_format($dubbing->merzigo_cost, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Toplam Gelir</label>
                            <p class="mt-1 text-sm text-gray-900">${{ number_format($dubbing->incomes->sum('revenue'), 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fark</label>
                            <p class="mt-1 text-sm font-medium {{ $dubbing->difference >= 0 ? 'text-green-600' : 'text-red-600' }}">${{ number_format($dubbing->difference, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Oluşturulma</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $dubbing->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Materials Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4 mt-md-5">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold">Materyaller ({{ $dubbing->materials->count() }})</h3>
                            @if(Auth::user()->canEdit())
                                <a href="{{ route('materials.create', ['dubbing_id' => $dubbing->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Materyal Ekle') }}
                                </a>
                            @endif
                        </div>

                        @if($dubbing->materials->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($dubbing->materials as $material)
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
                                        <div class="p-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                                    <span class="text-white font-bold text-xs">{{ substr($material->file_type, 0, 1) }}</span>
                                                </div>
                                                <div class="flex space-x-1">
                                                    <a href="{{ route('materials.show', $material) }}" class="p-1 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    @if(Auth::user()->canEdit())
                                                        <a href="{{ route('materials.edit', $material) }}" class="p-1 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>

                                            <h4 class="text-sm font-bold text-gray-900 mb-2">{{ $material->file_type }}</h4>

                                            <div class="space-y-1 mb-3">
                                                @if($material->studio_name)
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-gray-500">Stüdyo</span>
                                                        <span class="text-xs font-semibold text-gray-900">{{ $material->studio_name }}</span>
                                                    </div>
                                                @endif
                                                @if($material->episode_number)
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-gray-500">Bölüm</span>
                                                        <span class="text-xs font-semibold text-gray-900">
                                                            @if($material->season_number)
                                                                S{{ $material->season_number }}E{{ $material->episode_number }}
                                                            @else
                                                                E{{ $material->episode_number }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="flex items-center justify-between">
                                                     <span class="text-xs text-gray-500">Durum</span>
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                        @if($material->status === 'completed') bg-green-100 text-green-800
                                                        @elseif($material->status === 'dubbing') bg-blue-100 text-blue-800
                                                        @elseif($material->status === 'recived') bg-yellow-100 text-yellow-800
                                                        @elseif($material->status === 'sended') bg-purple-100 text-purple-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ ucfirst($material->status) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex space-x-2 mb-3">
                                                @if($material->script_exists)
                                                     <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                         ✓ Senaryo
                                                    </span>
                                                @endif
                                                @if($material->ae_file_exists)
                                                     <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                         ✓ AE Dosyası
                                                    </span>
                                                @endif
                                            </div>

                                            <a href="{{ route('materials.show', $material) }}" class="w-full bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 text-blue-700 font-medium py-2 px-3 rounded-lg text-center transition-all duration-200 flex items-center justify-center text-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Detayları Görüntüle
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Materyal bulunamadı</h3>
                                <p class="text-gray-500 mb-4">Bu dublajın henüz materyali yok.</p>
                                @if(Auth::user()->canEdit())
                                    <a href="{{ route('materials.create', ['dubbing_id' => $dubbing->id]) }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        İlk Materyali Ekle
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>
</div>
@endsection
