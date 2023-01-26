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
                <form enctype="multipart/form-data" action="{{ url('edit-profile')}}" method="POST">
                    @csrf
                    @foreach ($users as $user)
                    @method('PUT')
                    <div>
                        <img src="/uploads/profile_pictures/{{$user->profile_picture}}" style="width: 150px; height: 150px; border-radius:50%;"/>
                        <label>Update profile picture </label>
                        <br>
                        <input type="file" name="profile_picture" id="profile_picture">
                        <input type="hidden" name="_token" value="{{ csrf_token() }} ">
                    </div>
                    <div>
                        <x-input-label for="username" :value="__('Username')" />

                        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="$user->username"  autofocus />
                    </div>

                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />

                        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="$user->first_name"/>
                    </div>
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />

                        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="$user->last_name"/>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('E-mail')" />

                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email"/>
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

