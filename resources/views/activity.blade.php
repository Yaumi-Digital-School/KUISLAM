<x-main-layout titlePage="Laravel" themePage="white">
    {{-- additional style  --}}
    @section('style')
    @endsection
    
    {{-- navbar  --}}
    @include('layouts.navigation', ['themePage' => 'white'])
    
    {{-- main content --}}
    <div class="font-poppins mt-20 md:mt-28">
       {{-- main container  --}}
       <div class="max-w-screen-xl 3xl:max-w-screen-2xl mx-auto h-screen ">
           <div class="px-4 xl:px-0 pb-20 relative z-10">
            {{-- nav selesai and dibuat  --}}
            <div class="flex items-center space-x-5 text-md lg:text-lg font-medium text-gray-link mb-4 lg:mb-8">
                <a href="{{ route('activity') }}" class="@if (request()->routeIs("activity")) text-green-nav border-b-4 border-green-nav @endif" >Selesai</a>
                <a href="{{ route('activity.made') }}" class="@if (request()->routeIs("activity.made")) text-green-nav border-b-4 border-green-nav @endif">Dibuat</a>
            </div>
            {{-- grid content  --}}
            @if (request()->routeIs("activity"))
                <div class="grid grid-cols-12 xl:grid-cols-15 relative z-10 gap-x-2 gap-y-4 md:gap-6">
                    @foreach ($roomUser as $data)
                        @php
                            $description = $data->room->quiz->description;
                            if(strlen($description) > 60)
                                $description = substr($description, 0, 60);
                            $description .= " ...";
                        @endphp    
                        {{-- card --}}
                        <div class="col-span-6 md:col-span-4 lg:col-span-3 flex flex-col rounded-lg bg-gray-card p-2 h-64 md:h-80">
                            <div class="h-3/5 w-full relative bg-indigo-300 rounded-lg">
                                <span class="absolute bottom-2 left-2 bg-gray-nav text-white text-sm px-2 rounded-xl">10 pertanyaan</span>
                            </div>
                            <div class="flex flex-col justify-between h-2/5">
                                <div class="flex flex-col space-y-1 p-1">
                                    <a href="" class="font-bold">
                                        <h3 class="text-sm text-black-cardText">{{ $data->room->quiz->title }}</h3>
                                        <span class="text-sm text-gray-cardText">{{ $description }}</span>
                                    </a>
                                </div>
                                @auth
                                    <div class="bg-red-redMain text-white rounded-lg mb-1">
                                        <span class="ml-4">0% akurasi</span> 
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif (request()->routeIs("activity.made"))
                <div class="">
                    <img class="block mx-auto w-120 mt-14 md:mt-8" src="{{ asset('./images/activity_coming_soon.png') }}" alt="">
                </div>
            @endif
        </div>
    </div>

    @section('script')

    @endsection
</x-main-layout>