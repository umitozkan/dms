@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-[15px] sm:text-base">
        @isset($stats)
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="row g-4">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Toplam Kullanıcı') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-red-600">{{ $stats['admins'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Admin') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-indigo-600">{{ $stats['editors'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Editör') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600">{{ $stats['viewers'] }}</div>
                                <div class="text-sm text-gray-500">{{ __('Görüntüleyici') }}</div>
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
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('Kullanıcılar') }}</h2>
                    @if(Auth::check() && Auth::user()->canEdit())
                    <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('Yeni Kullanıcı') }}
                    </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table id="users-table" class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Ad') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('E-posta') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Rol') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Kaynak') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('İşlemler') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">{{ ucfirst($user->role) }}</td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap">{{ $user->source }}</td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center" title="{{ __('Düzenle') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span class="sr-only">{{ __('Düzenle') }}</span>
                                            </a>
                                            @if (auth()->id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Bu kullanıcıyı silmek istediğinizden emin misiniz?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium flex items-center" title="{{ __('Sil') }}">
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

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
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


