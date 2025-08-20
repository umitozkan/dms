@extends('layouts.app')

@section('title', 'Edit Income')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('Edit Income') }}</h2>
                    <a href="{{ route('incomes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Incomes') }}
                    </a>
                </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('incomes.update', $income) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="dubbing_id" :value="__('Dubbing')" />
                            <select id="dubbing_id" name="dubbing_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">{{ __('Select Dubbing') }}</option>
                                @foreach($dubbings as $dubbing)
                                    <option value="{{ $dubbing->id }}" {{ old('dubbing_id', $income->dubbing_id) == $dubbing->id ? 'selected' : '' }}>
                                        {{ $dubbing->show->name }} - {{ $dubbing->language->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('dubbing_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="merzigo_cost" :value="__('Merzigo Cost')" />
                            <x-text-input id="merzigo_cost" class="block mt-1 w-full" type="number" step="0.01" name="merzigo_cost" :value="old('merzigo_cost', $income->merzigo_cost)" required autofocus />
                            <x-input-error :messages="$errors->get('merzigo_cost')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', $income->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="revenue" :value="__('Revenue')" />
                            <x-text-input id="revenue" class="block mt-1 w-full" type="number" step="0.01" name="revenue" :value="old('revenue', $income->revenue)" required />
                            <x-input-error :messages="$errors->get('revenue')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="unit_price" :value="__('Unit Price')" />
                            <x-text-input id="unit_price" class="block mt-1 w-full" type="number" step="0.01" name="unit_price" :value="old('unit_price', $income->unit_price)" />
                            <x-input-error :messages="$errors->get('unit_price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="income_date" :value="__('Income Date')" />
                            <x-text-input id="income_date" class="block mt-1 w-full" type="date" name="income_date" :value="old('income_date', $income->income_date->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('income_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="end_date" :value="__('End Date')" />
                            <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date', $income->end_date ? $income->end_date->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $income->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Income') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>
</div>
@endsection
