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
                @if(count($roomUser) == 0)
                    <div class="">
                        <img class="block mx-auto w-120 mt-14 md:mt-8" src="{{ asset('./images/activity_not_found.png') }}" alt="">
                    </div>
                @endempty
                <div class="grid grid-cols-12 xl:grid-cols-15 relative z-10 gap-x-2 gap-y-4 md:gap-6">
                    @foreach ($roomUser as $data)
                        {{-- card --}}
                        <div class="col-span-6 md:col-span-4 lg:col-span-3 flex flex-col rounded-lg bg-gray-card p-2 h-64 md:h-72">
                            <div class="h-3/5 w-full relative bg-indigo-300 rounded-lg bg-cover bg-center" style="background-image: url({{ asset('./img/card.jpg') }})">
                                <span class="absolute bottom-2 left-2 bg-gray-card text-sm px-2 rounded-md">10 pertanyaan</span>
                            </div>
                            <div class="flex flex-col justify-between h-2/5">
                                <div class="flex flex-col space-y-1 p-1">
                                    <a href="" class="font-bold">
                                        <h3 class="text-sm text-black-cardText">{{ $data->room->quiz->title }}</h3>
                                    </a>
                                </div>
                                @auth
                                    @php
                                        $totalCorrect = $data->total_correct * 10;
                                    @endphp
                                    @if($totalCorrect < 25)
                                        <div class="bg-red-redMain text-white rounded-lg mb-1">
                                            <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                        </div>
                                    @elseif($totalCorrect > 25 && $totalCorrect < 50)
                                        <div class="bg-yellow-yellowMain text-white rounded-lg mb-1">
                                            <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                        </div>
                                    @elseif($totalCorrect > 50 && $totalCorrect < 75)
                                        <div class="bg-blue-blueMain text-white rounded-lg mb-1">
                                            <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                        </div>
                                    @elseif($totalCorrect > 75)
                                        <div class="bg-green-greenMain text-white rounded-lg mb-1">
                                            <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                        </div>
                                    @endif
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