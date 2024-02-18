@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-lg">
    <div class="md:flex">
        <div class="w-full p-5">
            <h2 class="text-center font-semibold text-3xl lg:text-4xl text-gray-800">
                Register
            </h2>
            <form method="POST" action="{{ route('register') }}" class="p-5" enctype="multipart/form-data">
                @csrf

                <!-- Adjusted classes for white background and better contrast -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-700" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="student_number" :value="__('Student Number')" />
                    <x-text-input id="student_number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-700" type="text" name="student_number" :value="old('student_number')" required pattern="\d{2}-\d{4}-\d{6}" title="Student Number must follow the XX-XXXX-XXXXXX format." />
                    <x-input-error :messages="$errors->get('student_number')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-700" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-700" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-700" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
