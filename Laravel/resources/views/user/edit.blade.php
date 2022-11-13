<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit profile') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <x-success-status class="mb-4" :status="session('message')" />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4 px-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ url('edit-profile')}}" method="POST">
                    @csrf
                    @foreach ($users as $user)
                    @method('PUT')
                    <div>
                        <x-input-label for="firstName" :value="__('First Name')" />

                        <x-text-input id="firstName" class="block mt-1 w-full" type="text" name="firstName" :value="$user->firstName"  autofocus />
                    </div>
                    <div>
                        <x-input-label for="lastName" :value="__('Last Name')" />

                        <x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="$user->lastName" autofocus />
                    </div>

                    <div>
                    <x-primary-button class="ml-3">
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
                    @endforeach




                </form>
            </div>
        </div>
    </div>


</x-app-layout>

