@extends('layouts.app')

@section('title', 'Income Details')

@section('content')
<div class="container py-4"><div class="row"><div class="col-12">
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('Income Details') }}</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('incomes.edit', $income) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Edit') }}
                        </a>
                        <a href="{{ route('incomes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Back to List') }}
                        </a>
                    </div>
                </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Income Information') }}</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Show') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->dubbing->show->name }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Language') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->dubbing->language->name }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Merzigo Cost') }}</label>
                                <p class="mt-1 text-sm text-gray-900">${{ number_format($income->merzigo_cost, 2) }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                                <p class="mt-1 text-sm text-gray-900">${{ number_format($income->price, 2) }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Revenue') }}</label>
                                <p class="mt-1 text-sm text-gray-900">${{ number_format($income->revenue, 2) }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Income Date') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->income_date->format('d.m.Y') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('End Date') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->end_date ? $income->end_date->format('d.m.Y') : __('Not set') }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Additional Information') }}</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Notes') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->notes ?: __('No notes') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Created At') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->created_at->format('d.m.Y H:i') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Updated At') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Dubbing Information') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Duration') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->dubbing->duration }} {{ __('minutes') }}</p>
                            </div>

                            <div class="bg-green-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Received Episodes') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->dubbing->received_episodes }}</p>
                            </div>

                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $income->dubbing->status)) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Show Information') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Company') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->dubbing->show->company->name }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Total Episodes') }}</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $income->dubbing->show->total_episode }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div></div></div>
@endsection
