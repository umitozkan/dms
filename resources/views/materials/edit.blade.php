@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-10 mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('materials.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">
                        {{ __('Materyal Düzenle') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Materyal bilgilerini güncelleyin</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('materials.update', $material) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Sol Kolon -->
                        <div class="space-y-6">
                            <div>
                                <label for="dubbing_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Dublaj Projesi') }}</label>
                                <select id="dubbing_id" name="dubbing_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                                    <option value="">{{ __('Dublaj projesi seçin') }}</option>
                                    @foreach($dubbings as $dubbing)
                                        <option value="{{ $dubbing->id }}" {{ old('dubbing_id', $material->dubbing_id) == $dubbing->id ? 'selected' : '' }}>
                                            {{ $dubbing->show->name }} - {{ $dubbing->language->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dubbing_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="file_type" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Dosya Türü') }}</label>
                                <input type="text" id="file_type" name="file_type" value="{{ old('file_type', $material->file_type) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                    placeholder="{{ __('Dosya türünü girin (örn: MP4, AVI)') }}">
                                @error('file_type')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>



                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="season_number" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Sezon') }}</label>
                                    <input type="number" id="season_number" name="season_number" value="{{ old('season_number', $material->season_number) }}" min="1"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                        placeholder="{{ __('Sezon') }}">
                                    @error('season_number')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="episode_number" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Bölüm') }}</label>
                                    <input type="number" id="episode_number" name="episode_number" value="{{ old('episode_number', $material->episode_number) }}" min="1"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                        placeholder="{{ __('Bölüm') }}">
                                    @error('episode_number')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Durum') }}</label>
                                <select id="status" name="status" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                                    <option value="sent_to_studio" {{ old('status', $material->status) == 'sent_to_studio' ? 'selected' : '' }}>{{ __('Stüdyoya Gönderildi') }}</option>
                                    <option value="completed" {{ old('status', $material->status) == 'completed' ? 'selected' : '' }}>{{ __('Tamamlandı') }}</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="script_exists" value="1" {{ old('script_exists', $material->script_exists) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <span class="ml-3 text-gray-700 font-medium">{{ __('Senaryo Mevcut') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="ae_file_exists" value="1" {{ old('ae_file_exists', $material->ae_file_exists) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <span class="ml-3 text-gray-700 font-medium">{{ __('AE Dosyası Mevcut') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Sağ Kolon -->
                        <div class="space-y-6">
                            <div>
                                <label for="file_duration" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Dosya Süresi (Dakika)') }}</label>
                                <input type="number" id="file_duration" name="file_duration" value="{{ old('file_duration', $material->file_duration) }}" min="1"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                    placeholder="{{ __('Dosya süresini dakika cinsinden girin') }}">
                                @error('file_duration')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Süre (Dakika)') }}</label>
                                <input type="number" id="duration" name="duration" value="{{ old('duration', $material->duration) }}" min="1"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                    placeholder="{{ __('Süreyi dakika cinsinden girin') }}">
                                @error('duration')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="unit_price" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Birim Fiyat ($)') }}</label>
                                <input type="number" step="0.01" id="unit_price" name="unit_price" value="{{ old('unit_price', $material->unit_price) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400"
                                    placeholder="{{ __('Birim fiyatı girin') }}">
                                @error('unit_price')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="studio_start_date" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Stüdyo Başlangıç Tarihi') }}</label>
                                <input type="datetime-local" id="studio_start_date" name="studio_start_date" value="{{ old('studio_start_date', $material->studio_start_date ? $material->studio_start_date->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                                @error('studio_start_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="studio_end_date" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Stüdyo Bitiş Tarihi') }}</label>
                                <input type="datetime-local" id="studio_end_date" name="studio_end_date" value="{{ old('studio_end_date', $material->studio_end_date ? $material->studio_end_date->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                                @error('studio_end_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="received_from_producer" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Prodüktörden Alınma Tarihi') }}</label>
                                <input type="datetime-local" id="received_from_producer" name="received_from_producer" value="{{ old('received_from_producer', $material->received_from_producer ? $material->received_from_producer->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                                @error('received_from_producer')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Notlar') }}</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400 resize-none"
                            placeholder="{{ __('Materyal hakkında notlar ekleyin (opsiyonel)') }}">{{ old('notes', $material->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100 mt-8">
                        <a href="{{ route('materials.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200">
                            {{ __('İptal') }}
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            {{ __('Materyal Güncelle') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
