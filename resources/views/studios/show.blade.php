@extends('layouts.app')

@section('title', 'Stüdyo Detayı')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ __('Stüdyo Detayı') }}: {{ $studio->name }}</h2>
                    <div class="flex space-x-2">
                        @if(auth()->user()->canEdit())
                        <a href="{{ route('studios.edit', $studio) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Düzenle
                        </a>
                        @endif
                        <a href="{{ route('studios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Geri Dön
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Stüdyo Bilgileri</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stüdyo Adı</dt>
                                <dd class="text-sm text-gray-900">{{ $studio->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ülke</dt>
                                <dd class="text-sm text-gray-900">{{ $studio->country ?? 'Belirtilmemiş' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Adres</dt>
                                <dd class="text-sm text-gray-900">{{ $studio->address ?? 'Belirtilmemiş' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">İletişim Kişisi</dt>
                                <dd class="text-sm text-gray-900">{{ $studio->contact_person ?? 'Belirtilmemiş' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Telefon</dt>
                                <dd class="text-sm text-gray-900">{{ $studio->phone ?? 'Belirtilmemiş' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $studio->email ?? 'Belirtilmemiş' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">İstatistikler</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $studio->dubbings->count() }}</div>
                                <div class="text-sm text-blue-600">Toplam Dublaj</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">{{ $studio->materials->count() }}</div>
                                <div class="text-sm text-green-600">Toplam Materyal</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($studio->dubbings->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Bu Stüdyodaki Dublajlar</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Yapım
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dil
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Süre (dk)
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Durum
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        İşlemler
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($studio->dubbings as $dubbing)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('shows.show', $dubbing->show) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $dubbing->show->name }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dubbing->language->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $dubbing->duration }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($dubbing->status === 'completed') bg-green-100 text-green-800
                                                @elseif($dubbing->status === 'dubbing') bg-yellow-100 text-yellow-800
                                                @elseif($dubbing->status === 'published') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $dubbing->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('dubbings.show', $dubbing) }}" class="text-blue-600 hover:text-blue-900">Görüntüle</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
