<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin page') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <x-success-status class="mb-4" :status="session('message')" />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4 px-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table">
                    <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Username</th>
                          <th scope="col">First</th>
                          <th scope="col">Last</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <form enctype="multipart/form-data" action="{{ url('test')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <th scope="row">
                                <x-text-input type="hidden" id="userID" name="userID" :value="$user->userID"/>
                                {{$user->userID}}
                            </th>
                            <td>
                                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="$user->username"/>
                            </td>

                            <td>
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="$user->first_name"/>
                            </td>

                            <td>
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="$user->last_name"/>
                            </td>

                            <td>
                                <x-primary-button class="ml-3">
                                    {{ __('Save') }}
                                </x-primary-button>
                            </td>
                        </form>
                        </tr>
                        @endforeach
            </tbody>
                </table>

            </div>
        </div>
    </div>


</x-app-layout>

