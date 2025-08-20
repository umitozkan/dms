@extends('layouts.app')

@section('title', 'Dublajı Düzenle')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dubbings.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">{{ __('Dublajı Düzenle') }}</h2>
                    <p class="text-gray-600 mt-1">{{ __('Dublaj bilgilerini güncelleyin') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('dubbings.update', $dubbing) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="show_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Yapım') }}</label>
                        <select name="show_id" id="show_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                            <option value="">{{ __('Yapım seçin') }}</option>
                            @foreach($shows as $show)
                                <option value="{{ $show->id }}" {{ old('show_id', $dubbing->show_id) == $show->id ? 'selected' : '' }}>
                                    {{ $show->name }} ({{ $show->company->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('show_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="language_code" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Dil') }}</label>
                        <select name="language_code" id="language_code" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                            <option value="">{{ __('Dil seçin') }}</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->code }}" {{ old('language_code', $dubbing->language_code) == $language->code ? 'selected' : '' }}>
                                    {{ $language->name }} ({{ $language->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('language_code')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="studio_id" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Stüdyo') }}</label>
                        <select name="studio_id" id="studio_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900">
                            <option value="">{{ __('Stüdyo seçin') }}</option>
                            @foreach($studios as $studio)
                                <option value="{{ $studio->id }}" {{ old('studio_id', $dubbing->studio_id) == $studio->id ? 'selected' : '' }}>
                                    {{ $studio->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('studio_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Süre (Dakika)') }}</label>
                        <input type="number" name="duration" id="duration" value="{{ old('duration', $dubbing->duration) }}" required min="1"
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

                    

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Durum') }}</label>
                        <div class="space-y-3">
                            @php($status = old('status', $dubbing->status))
                            <label class="flex items-center">
                                <input type="radio" name="status" value="material_waiting" {{ $status == 'material_waiting' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-gray-700 font-medium">{{ __('Materyal Bekliyor') }}</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status" value="dubbing" {{ $status == 'dubbing' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-gray-700 font-medium">{{ __('Dublaj Yapılıyor') }}</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status" value="published" {{ $status == 'published' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-gray-700 font-medium">{{ __('Yayınlandı') }}</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status" value="completed" {{ $status == 'completed' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-gray-700 font-medium">{{ __('Tamamlandı') }}</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status" value="in_progress" {{ $status == 'in_progress' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-gray-700 font-medium">{{ __('Devam Ediyor') }}</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Notlar') }}</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-900 placeholder-gray-400 resize-none"
                            placeholder="{{ __('Dublaj hakkında notlar ekleyin (opsiyonel)') }}">{{ old('notes', $dubbing->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('dubbings.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200">
                            {{ __('İptal') }}
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Dublajı Güncelle') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection