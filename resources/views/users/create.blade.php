@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-xl text-gray-800">{{ __('Yeni Kullanıcı') }}</h2>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Ad')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('E-posta')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email') }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Parola')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Parola (Tekrar)')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Rol')" />
                        <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded">
                            @foreach($roles as $key => $label)
                                <option value="{{ $key }}" @selected(old('role')===$key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>



                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">İptal</a>
                        <x-primary-button>{{ __('Oluştur') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
 
 
