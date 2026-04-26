<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Short URL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('companies.index') }}" class="">
                       Back
                    </a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('shorturls.store') }}" class="p-6 text-gray-900">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="original_url" :value="__('Original URL')" />
                        <x-text-input id="original_url" class="block mt-1 w-full" type="url" name="original_url" :value="old('original_url')" required autofocus />
                        <x-input-error :messages="$errors->get('original_url')" class="mt-2" />
                    </div>

                   

                    <x-primary-button>
                        {{ __('Generate Short URL') }}
                    </x-primary-button>
                </form>
            </div>
    </div>
</x-app-layout>