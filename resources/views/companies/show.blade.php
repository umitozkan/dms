@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('companies.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h2 class="font-bold text-2xl text-gray-900">{{ $company->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ __('Şirket detayları ve yapımlar') }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    @if(Auth::user()->canEdit())
                    <a href="{{ route('companies.edit', $company) }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('Düzenle') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Company Details -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-4 mb-md-5">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-6">
                        <span class="text-white font-bold text-2xl">{{ substr($company->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $company->name }}</h3>
                        <p class="text-gray-600">{{ __('Ortak Şirket') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-blue-600">{{ $company->shows->count() }}</div>
                        <div class="text-sm text-gray-500">{{ __('Toplam Yapım') }}</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-green-600">{{ $company->shows->sum('total_episode') }}</div>
                        <div class="text-sm text-gray-500">{{ __('Toplam Bölüm') }}</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-purple-600">{{ $company->shows->sum(function($show) { return $show->dubbings->count(); }) }}</div>
                        <div class="text-sm text-gray-500">{{ __('Toplam Dublaj') }}</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-indigo-600">{{ $company->created_at->format('M Y') }}</div>
                        <div class="text-sm text-gray-500">{{ __('Katılım') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shows Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Yapımlar') }}</h3>
                        <p class="text-gray-600 mt-1">{{ __('Bu şirketten tüm Yapımlar') }}</p>
                    </div>
                    @if(Auth::user()->canEdit())
                    <a href="{{ route('shows.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Dizi Ekle') }}
                    </a>
                    @endif
                </div>

                @if($company->shows->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($company->shows as $show)
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($show->name, 0, 1) }}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('shows.show', $show) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @if(Auth::user()->canEdit())
                                    <a href="{{ route('shows.edit', $show) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </div>

                            <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $show->name }}</h4>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">{{ __('Bölümler') }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $show->total_episode }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">{{ __('Dublajlar') }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $show->dubbings->count() }}</span>
                                </div>
                            </div>

                            <a href="{{ route('shows.show', $show) }}" class="w-full bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 text-green-700 font-medium py-2 px-4 rounded-xl text-center transition-all duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ __('Detayları Görüntüle') }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Yapım bulunamadı') }}</h3>
                    <p class="text-gray-500 mb-6">{{ __('Bu şirketin henüz yapımı yok.') }}</p>
                    @if(Auth::user()->canEdit())
                    <a href="{{ route('shows.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('İlk Yapımı Ekle') }}
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
