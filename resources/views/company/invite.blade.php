<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Invitation for Company-') }}{{ $company->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ url()->previous() }}" class="">
                Back
            </a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
            @if (session('success'))
                        <p>Invitation link generated successfully and sent on mail. Share this link with the invitee:</p>
                    <div>
                    <a href="{{ session('success') }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ session('success') }}</a>
                </div>
            @endif
            </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <form method="POST" action="{{ route('company.send-invitation', $company) }}" class="p-6 text-gray-900">
            @csrf
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            @role('Admin')
            <div class="mb-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="Admin">Admin</option>
                    <option value="Member">Member</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
            @endrole




            <x-primary-button>
                {{ __('Send Invitation') }}
            </x-primary-button>
        </form>
    </div>
    </div>
</x-app-layout>