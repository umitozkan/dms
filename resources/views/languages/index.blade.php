@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('Diller') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('Tüm dilleri görüntüleyin ve yönetin') }}</p>
                </div>
                @if(Auth::check() && Auth::user()->canEdit())
                <a href="{{ route('languages.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Dil Ekle') }}
                </a>
                @endif
            </div>
        </div>
        @isset($stats)
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $stats['total_languages'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Toplam Dil') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $stats['total_dubbings'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Toplam Dublaj') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ number_format(($stats['total_dubbings'] / max($stats['total_languages'],1)), 1) }}</div>
                        <div class="text-sm text-gray-500">{{ __('Ort. Dublaj') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-indigo-600">{{ $stats['active_languages'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Aktif Dil') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        <!-- Languages Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="overflow-x-auto">
                    <table id="languages-table" class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Dil') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Dublajlar') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Oluşturulma') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('İşlemler') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($languages as $language)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $language->name }}</div>
                                            <div class="text-sm text-gray-500">Dubbing Language</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-900 font-medium">{{ $language->dubbings_count }}</span>
                                        <span class="text-sm text-gray-500 ml-1">{{ __('proje') }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $language->created_at->format('d.m.Y') }}</div>
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('languages.show', $language) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center" title="{{ __('Görüntüle') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span class="sr-only">{{ __('Görüntüle') }}</span>
                                        </a>
                                        @if(Auth::check() && Auth::user()->canEdit())
                                        <a href="{{ route('languages.edit', $language) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center" title="{{ __('Düzenle') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span class="sr-only">{{ __('Düzenle') }}</span>
                                        </a>
                                        @endif
                                        @if(Auth::check() && Auth::user()->canDelete())
                                        <form action="{{ route('languages.destroy', $language) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium flex items-center" title="{{ __('Sil') }}" onclick="return confirm('{{ __('Bu dili silmek istediğinizden emin misiniz?') }}')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span class="sr-only">{{ __('Sil') }}</span>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($languages->isEmpty())
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Dil bulunamadı') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('İlk dilinizi ekleyerek başlayın.') }}</p>
            @if(Auth::check() && Auth::user()->canEdit())
            <a href="{{ route('languages.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                {{ __('İlk Dili Ekle') }}
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#languages-table').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json'
            },
            pageLength: 25,
            order: [[0, 'asc']],
            columnDefs: [
                { targets: -1, orderable: true, searchable: true }
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tümü']],
            initComplete: function() {
                $('.dataTables_filter input').attr('placeholder', 'Ara...');
            }
        });
    });
</script>
@endpush
@endsection