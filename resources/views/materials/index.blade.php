@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-[15px] sm:text-base">
        @isset($stats)
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="row g-4">
                        <div class="col-12 col-sm-6 col-md-2">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600">{{ $stats['total_materials'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Toplam Materyal') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-2">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600">{{ $stats['materials_with_script'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Senaryolu') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-2">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-indigo-600">{{ $stats['materials_with_ae'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('AE Dosyalı') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600">{{ $stats['completed_materials'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Tamamlanan') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-600">{{ $stats['sent_to_studio'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Stüdyoya Gönderilen') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('Materyaller') }}</h2>
                    @if(Auth::check() && Auth::user()->canEdit())
                    <a href="{{ route('materials.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('Materyal Ekle') }}
                    </a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table id="materials-table" class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Dizi') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Dil') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Video') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Durum') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Senaryo') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('AE Dosyası') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('İşlemler') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($materials as $material)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $material->dubbing->show->name }}
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ optional($material->dubbing->language)->name ?? strtoupper($material->dubbing->language_code) }}
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm text-gray-500">{{ $material->video_path ?: '—' }}</td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($material->status === 'completed') bg-green-100 text-green-800
                                            @elseif($material->status === 'dubbing') bg-blue-100 text-blue-800
                                            @elseif($material->status === 'sent_to_studio') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($material->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm text-gray-500">
                                        @if($material->script_exists)
                                            <span class="text-green-600">✓</span>
                                        @else
                                            <span class="text-red-600">✗</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm text-gray-500">
                                        @if($material->ae_file_exists)
                                            <span class="text-green-600">✓</span>
                                        @else
                                            <span class="text-red-600">✗</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('materials.show', $material) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @if(Auth::check() && Auth::user()->canEdit())
                                            <a href="{{ route('materials.edit', $material) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            @endif
                                            <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium flex items-center" onclick="return confirm('{{ __('Bu materyali silmek istediğinizden emin misiniz?') }}')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($materials->count() === 0)
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Materyal bulunamadı') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('İlk materyalinizi ekleyerek başlayın.') }}</p>
            @if(Auth::check() && Auth::user()->canEdit())
            <a href="{{ route('materials.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                {{ __('İlk Materyali Ekle') }}
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#materials-table').DataTable({
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
