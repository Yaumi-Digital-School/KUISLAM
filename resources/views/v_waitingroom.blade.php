<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Waiting Room') }}
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
                            <th>NAME</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($roomUser as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->user->name }}</td>
                                    @if ($data->is_host === 1)
                                        <td>Host</td>
                                    @else
                                        <td>Player</td>
                                    @endif
                                </tr>   
                            @endforeach
                        </tbody>
                      </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
