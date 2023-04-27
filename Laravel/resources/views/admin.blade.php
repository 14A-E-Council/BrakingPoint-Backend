<x-app-layout>

    <x-slot name="header">
        <div class="w-55 grid grid-cols-3 gap-4 content-start">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin page') }}
        </h2>
        <form enctype="multipart/form-data" action="{{ url('admin')}}" method="GET">
            @csrf
            <x-search-input id="searchedTerm" class="block mt-1 w-full" type="text" name="searchedTerm" />
            <x-primary-button class="ml-3">
            {{ __('Search') }}
            </x-primary-button>
        </form>
        </div>
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
                            <form enctype="multipart/form-data" action="{{ url('admin')}}" method="POST">
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
                                <button type="submit" action="action" name="action" value="save">Save</button>
                            </td>
                            @if ($user->banned_at == null)
                            <td>
                                <button type="submit" action="action" name="action" value="ban">Ban</button>
                            </td>
                            @else
                            <td>
                                <button type="submit" action="action" name="action" value="unban">Unban</button>
                            </td>
                            @endif
                            <td>
                                <button type="submit" action="action" name="action" value="delete">Delete</button>
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

