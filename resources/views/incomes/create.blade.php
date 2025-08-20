@extends('layouts.app')

@section('title', 'Gelir Ekle')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('Gelir Ekle') }}</h2>
                    <a href="{{ route('incomes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Gelirlere Dön') }}
                    </a>
                </div>

                <form method="POST" action="{{ route('incomes.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sol Kolon -->
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="dubbing_id" :value="__('Dublaj')" />
                                <select id="dubbing_id" name="dubbing_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">{{ __('Dublaj Seçin') }}</option>
                                    @foreach($dubbings as $dubbing)
                                        <option value="{{ $dubbing->id }}" {{ old('dubbing_id') == $dubbing->id ? 'selected' : '' }}>
                                            {{ $dubbing->show->name }} - {{ $dubbing->language->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('dubbing_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="merzigo_cost" :value="__('Merzigo Maliyeti ($)')" />
                                <x-text-input id="merzigo_cost" class="block mt-1 w-full" type="number" step="0.01" name="merzigo_cost" :value="old('merzigo_cost')" required />
                                <x-input-error :messages="$errors->get('merzigo_cost')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="price" :value="__('Fiyat ($)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="revenue" :value="__('Gelir ($)')" />
                                <x-text-input id="revenue" class="block mt-1 w-full" type="number" step="0.01" name="revenue" :value="old('revenue')" required />
                                <x-input-error :messages="$errors->get('revenue')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Sağ Kolon -->
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="unit_price" :value="__('Birim Fiyat ($)')" />
                                <x-text-input id="unit_price" class="block mt-1 w-full" type="number" step="0.01" name="unit_price" :value="old('unit_price')" />
                                <x-input-error :messages="$errors->get('unit_price')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="income_date" :value="__('Gelir Tarihi')" />
                            <x-text-input id="income_date" class="block mt-1 w-full" type="date" name="income_date" :value="old('income_date')" required />
                            <x-input-error :messages="$errors->get('income_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="end_date" :value="__('Bitiş Tarihi')" />
                            <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-input-label for="notes" :value="__('Notlar')" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Gelir Ekle') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
