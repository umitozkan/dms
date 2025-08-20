@extends('layouts.app')

@section('title', 'Material Details')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('Materyal Detayları') }}</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('materials.edit', $material) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Düzenle') }}
                        </a>
                        <a href="{{ route('materials.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Listeye Dön') }}
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Temel Bilgiler') }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Dizi') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->dubbing->show->name }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Dil') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ optional($material->dubbing->language)->name ?? strtoupper($material->dubbing->language_code) }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Dosya Türü') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->file_type }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Stüdyo') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ optional($material->studio)->name ?: __('Ayarlanmamış') }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Bölüm Bilgisi') }}</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($material->episode_number)
                                    Bölüm {{ $material->episode_number }}
                                @else
                                    {{ __('Ayarlanmamış') }}
                                @endif
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Durum') }}</label>
                            <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($material->status === 'completed') bg-green-100 text-green-800
                                @elseif($material->status === 'dubbing') bg-blue-100 text-blue-800
                                @elseif($material->status === 'recived') bg-yellow-100 text-yellow-800
                                @elseif($material->status === 'sended') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @if($material->status === 'completed')
                                    {{ __('Tamamlandı') }}
                                @elseif($material->status === 'dubbing')
                                    {{ __('Dublajda') }}
                                @elseif($material->status === 'recived')
                                    {{ __('Alındı') }}
                                @elseif($material->status === 'sended')
                                    {{ __('Gönderildi') }}
                                @else
                                    {{ __('Beklemede') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Stüdyo Bilgileri') }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Stüdyo Notları') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->studio_notes ?: __('Not yok') }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Dosya Durumu') }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Senaryo Mevcut') }}</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($material->script_exists)
                                    <span class="text-green-600">✓ {{ __('Evet') }}</span>
                                @else
                                    <span class="text-red-600">✗ {{ __('Hayır') }}</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('AE Dosyası Mevcut') }}</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($material->ae_file_exists)
                                    <span class="text-green-600">✓ {{ __('Evet') }}</span>
                                @else
                                    <span class="text-red-600">✗ {{ __('Hayır') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Zaman Çizelgesi') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Alınma Tarihi') }}</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $material->received_at ? $material->received_at->format('d.m.Y H:i') : __('Ayarlanmamış') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Gönderilme Tarihi') }}</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $material->sent_at ? $material->sent_at->format('d.m.Y H:i') : __('Ayarlanmamış') }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Dublaj Alınma Tarihi') }}</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $material->dubbing_received_at ? $material->dubbing_received_at->format('d.m.Y H:i') : __('Ayarlanmamış') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Dublaj Bilgileri') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Süre') }}</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->dubbing->duration }} {{ __('dakika') }}</p>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Fiyat') }}</label>
                            <p class="mt-1 text-sm text-gray-900">${{ number_format($material->dubbing->price, 2) }}</p>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Merzigo Maliyeti') }}</label>
                            <p class="mt-1 text-sm text-gray-900">${{ number_format($material->dubbing->merzigo_cost, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
