<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leaderboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto">
                        <thead>
                          <tr>
                            <th>NO.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Avatar</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ Auth::user()->name }}</td>
                                <td>{{ Auth::user()->email }}</td>
                                <td>{{ Auth::user()->username }}</td>
                                <td>{{ Auth::user()->avatar }}</td>
                            </tr>
                        </tbody>
                      </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
