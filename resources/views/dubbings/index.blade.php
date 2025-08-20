@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @isset($stats)
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $stats['total_dubbings'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Toplam Dublaj') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $stats['total_duration'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Toplam Süre (dk)') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-indigo-600">{{ $stats['total_received'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Alınan Bölüm') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $stats['total_published'] }}</div>
                        <div class="text-sm text-gray-500">{{ __('Yayınlanan Bölüm') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('Dublajlar') }}</h2>
                    @if(Auth::check() && Auth::user()->canEdit())
                        <a href="{{ route('dubbings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="bi bi-plus-circle me-2"></i>{{ __('Yeni Dublaj Ekle') }}
                        </a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table id="dubbings-table" class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Dizi') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Şirket') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Dil') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Süre') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Alınan Bölüm') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('İndirilen Bölüm') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Yayınlanan Bölüm') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Durum') }}</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('İşlemler') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($dubbings as $dubbing)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">
                                        <div class="text-sm font-semibold text-gray-900">{{ $dubbing->show->name }}</div>
                                    </td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">{{ optional($dubbing->show->company)->name ?? '—' }}</td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">{{ optional($dubbing->language)->name ?? strtoupper($dubbing->language_code) }}</td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">{{ $dubbing->duration }} {{ __('dk') }}</td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">{{ $dubbing->received_episodes }}</td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">{{ $dubbing->downloaded_episodes }}</td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">{{ $dubbing->published_episodes }}</td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($dubbing->status === 'completed') bg-green-100 text-green-800
                                            @elseif($dubbing->status === 'published') bg-blue-100 text-blue-800
                                            @elseif($dubbing->status === 'dubbing') bg-purple-100 text-purple-800
                                            @elseif($dubbing->status === 'in_progress') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ str_replace('_', ' ', ucfirst($dubbing->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-1 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('dubbings.show', $dubbing) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center" title="{{ __('Görüntüle') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span class="sr-only">{{ __('Görüntüle') }}</span>
                                            </a>
                                            @if(Auth::check() && Auth::user()->canEdit())
                                            <a href="{{ route('dubbings.edit', $dubbing) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center" title="{{ __('Düzenle') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span class="sr-only">{{ __('Düzenle') }}</span>
                                            </a>
                                            @endif
                                            @if(Auth::check() && Auth::user()->canDelete())
                                            <form action="{{ route('dubbings.destroy', $dubbing) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium flex items-center" title="{{ __('Sil') }}" onclick="return confirm('{{ __('Bu dublajı silmek istediğinize emin misiniz?') }}')">
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

        @if($dubbings->count() === 0)
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Dublaj bulunamadı') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('İlk dublajınızı ekleyerek başlayın.') }}</p>
            @if(Auth::check() && Auth::user()->canEdit())
            <a href="{{ route('dubbings.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                {{ __('İlk Dublajı Ekle') }}
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#dubbings-table').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json'
        },
        pageLength: 25,
        order: [[0, 'asc']],
        columnDefs: [
            { targets: 0, responsivePriority: 1 },               // Dizi
            { targets: 2, responsivePriority: 2 },               // Dil
            { targets: 1, responsivePriority: 3 },               // Şirket
            { targets: -1, orderable: true, searchable: true, responsivePriority: 2 } // İşlemler
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
