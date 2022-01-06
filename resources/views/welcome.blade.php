<x-main-layout titlePage="Home" themePage="white">
    @section('style')
        <style>
            .swiper-button-prev:after,
            .swiper-rtl .swiper-button-next:after {
                content: '';
            }
            .swiper-button-next:after,
            .swiper-rtl .swiper-button-next:after {
                content: '';
            }
            .swal2-actions {
                flex-direction: column;
                width: 80% !important;
            }
            .swal2-confirm:focus {
                border: none !important;
            }
        </style>
    @endsection
    
    {{-- navbar  --}}
    @include('layouts.navigation', ['themePage' => 'white'])

    {{-- main content --}}
    <div class="font-poppins mt-20 md:mt-28">
        {{-- main container  --}}
        <div class="max-w-screen-xl 3xl:max-w-screen-2xl mx-auto h-screen ">
            <div class="px-4 xl:px-0 pb-20">
                {{-- text mau bermain game?  --}}
                <div class="flex md:hidden">
                    <p class="z-10">Mau bermain game?</p>
                </div>
                {{-- code enter and profile --}}
                <div class="flex flex-col md:flex-row justify-between md:space-x-8">
                    {{-- kode game  --}}
                    <div class="w-full mr-20 md:w-4/6 md:shadow-profile rounded-lg mt-3 md:m-0 z-10 md:py-3 flex justify-center items-center bg-gray-lightBg">
                        <div class="w-full md:w-4/6 px-4 pb-4 pt-4 @error("code") pt-6 @enderror rounded-sm">
                            <form action="{{ route('room.join-code') }}" method="POST" class="flex flex-col">
                                @csrf
                                <div class="flex flex-col space-y-5 md:space-y-0 md:flex-row md:space-x-6">
                                    <input type="text" name="code"
                                        class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Masukan kode permainan...">
                                    <button type="submit" 
                                        class="bg-green-lightBg mx-auto w-full md:w-min font-semibold text-white rounded-md py-1 px-6 hover:bg-green-darkBg transition">
                                        Gabung
                                    </button>
                                </div>
                                @error('code')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </form>
                        </div>
                    </div>
                    {{-- desktop  profile --}}
                    <div class="w-full md:w-2/6 shadow-profile rounded-lg mt-3 md:m-0 z-10 py-3 hidden md:flex justify-center items-center bg-gray-lightBg">
                        <div class="flex flex-col items-center space-y-1">
                            <div class="flex items-center justify-between space-x-3">
                                @auth
                                    @php
                                        $avatar = Auth::user()->avatar;
                                        $isFile = Str::contains($avatar, ['.jpg', '.jpeg', '.png']);
    
                                        if($isFile){
                                            $file = true; 
                                        }else{
                                            $file = false;
                                        }
                                    @endphp
                                    @if(Auth::user()->avatar)
                                        @if($file === true)
                                            <div class="flex items-center h-10 w-10 ">
                                                <img class="rounded-full" src="{{ asset('storage/user/avatar/'. Auth::user()->avatar) }}" alt="burger icon">
                                            </div>
                                        @else
                                            <div class="flex items-center h-10 w-10 ">
                                                <img class="rounded-full" src="{{ Auth::user()->avatar }}" alt="burger icon">
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex items-center h-10 w-10 ">
                                            <img class="rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="burger icon">
                                        </div>
                                    @endif
                                @endauth
                                @guest
                                    <div class="flex items-center h-10 w-10 ">
                                        <img class="rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="burger icon">
                                    </div>
                                @endguest
                                @auth
                                    <div>
                                        <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                                        <p class="font-semibold text-gray-link text-sm">{{ Auth::user()->username }}</p>
                                    </div>
                                @endauth    
                            </div>
                            <div class="flex flex-col items-center">
                                @auth
                                    <div class="flex text-sm space-x-2 text-green-lightBg font-semibold">
                                        <a href="{{  route('profile.detail-account') }}" class="hover:underline">Edit Profil</a>
                                        <span>&#8226</span>
                                        <a href="{{ route("activity") }}" class="hover:underline">Lihat Aktivitas</a>
                                    </div>
                                @endauth
                                @guest
                                    <p class="font-semibold text-lg">Kamu belum login!</p>
                                    <div class="flex text-sm space-x-2 text-green-lightBg font-semibold">
                                        <a href="{{ route('login') }}" class="hover:underline cursor-pointer">Masuk</a>
                                        <span>&#8226</span>
                                        <a href="{{ route('register') }}" class="hover:underline cursor-pointer">Daftar</a>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                    {{-- mobile  profile --}}
                    <div style="border: 1px solid #F8F8F8;" class="drop-shadow-profile mt-3 rounded-lg md:rounded-none md:m-0 z-10 py-3 flex md:hidden justify-center items-center bg-gray-lightBg col-span-5">
                        <div class="flex flex-col items-center space-y-3 md:space-y-1 ">
                            @auth
                                @php
                                    $avatar = Auth::user()->avatar;
                                    $isFile = Str::contains($avatar, ['.jpg', '.jpeg', '.png']);

                                    if($isFile){
                                        $file =  true; 
                                    }else{
                                        $file =  false;
                                    }
                                @endphp
                                @if(Auth::user()->avatar)
                                    @if($file === true)
                                        <div class="flex items-center h-10 w-10 ">
                                            <img class="rounded-full" src="{{ asset('storage/user/avatar/'. Auth::user()->avatar) }}" alt="burger icon">
                                        </div>
                                    @else
                                        <div class="flex items-center h-10 w-10 ">
                                            <img class="rounded-full" src="{{ Auth::user()->avatar }}" alt="burger icon">
                                        </div>
                                    @endif
                                @else
                                    <div class="flex items-center h-10 w-10 ">
                                        <img class="rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="burger icon">
                                    </div>
                                @endif
                                <div class="flex flex-col items-center">
                                    <p class="font-semibold text-lg">{{ Auth::user()->name }}</p>
                                    <div class="flex text-sm space-x-2 text-green-lightBg font-semibold">
                                        <a href="{{  route('profile.detail-account') }}">Edit Profil</a>
                                        <span>&#8226</span>
                                        <a href="{{ route('activity') }}">Lihat Aktivitas</a>
                                    </div>
                                </div>
                            @endauth
                            @guest
                                <p>Mari kita mulai</p>
                                <div class="flex space-x-3">
                                    <a href="{{ route('login') }}"
                                        class="bg-white font-semibold text-green-lightBg border-2 border-green-lightBg rounded-full py-1 px-6 hover:bg-gray-100 transition">
                                        Masuk
                                    </a>
                                    <a  href="{{ route('register') }}"
                                        class="bg-green-lightBg font-semibold text-white rounded-full py-1 px-6 hover:bg-green-darkBg transition flex items-center">
                                        Daftar
                                    </a>
                                </div>
                                <div class="text-center text-gray-nav">
                                    <p class="text-sm">Ayo mainkan kuis setiap hari!</p>
                                    <p class="text-sm">Tingkatkan pengetahuanmu mengenai Islam</p>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
                @if($hasActivity === true)
                    {{-- swiper --}}
                    <div class="mt-3 md:mt-10 flex flex-col space-y-3 md:space-y-6">
                        <div class="z-10 text-xl md:text-2xl font-bold relative">
                            <h1>Recent Activity</h1>
                        </div>
                        <x-swiper-container classBot="swiper w-full h-64 md:h-72 p-2">
                            <!-- Slides -->
                            @foreach($roomUser as $data) 
                                <div class="swiper-slide flex flex-col rounded-lg bg-gray-card shadow-custom1">
                                    <div class="h-3/5 w-full relative bg-indigo-300 rounded-lg bg-cover bg-center" style="background-image: url({{ asset('./img/card.png') }})">
                                        <span class="absolute bottom-2 left-2 bg-gray-card text-sm px-2 rounded-md">10 pertanyaan</span>
                                    </div>
                                    <div class="flex flex-col justify-between h-2/5 px-1">
                                        <div class="flex flex-col space-y-1 p-1">
                                            <span class="font-semibold text-lg">
                                                {{ $data->room->quiz->title }}
                                            </span>
                                        </div>
                                        @auth
                                        @php
                                            $totalCorrect = $data->total_correct * 10;
                                        @endphp
                                            {{-- {{dump($totalCorrect)}} --}}
                                        @if($totalCorrect <= 25)
                                            <div class="bg-red-redMain text-white rounded-lg mb-1.5">
                                                <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                            </div>
                                        @elseif($totalCorrect >= 25 && $totalCorrect <= 50)
                                            <div class="bg-yellow-yellowMain text-white rounded-lg mb-1.5">
                                                <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                            </div>
                                        @elseif($totalCorrect >= 50 && $totalCorrect <= 75)
                                            <div class="bg-blue-blueMain text-white rounded-lg mb-1.5">
                                                <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                            </div>
                                        @elseif($totalCorrect >= 75)
                                            <div class="bg-green-greenMain text-white rounded-lg mb-1.5">
                                                <span class="ml-4">{{ $totalCorrect }}% akurasi</span> 
                                            </div>
                                        @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                            <!-- If we need navigation buttons -->
                            <x-slot name="nav_btn">
                                <x-swiper-navigation />
                            </x-slot>
                        </x-swiper-container>
                    </div>
                @endif
                {{-- swiper --}}
                <div class="mt-3 md:mt-10 flex flex-col space-y-3 md:space-y-6">
                    <div class="z-10 text-xl md:text-2xl font-bold relative">
                        <h1>Popular Quiz</h1>
                    </div>
                    <x-swiper-container>
                        <!-- Slides -->
                        @foreach($quizzes as $data) 
                            <div class="transform transition duration-400 hover:scale-105 swiper-slide flex flex-col rounded-lg bg-gray-card shadow-custom1">
                                <div class="h-4/6 w-full relative bg-indigo-300 rounded-lg bg-cover bg-center" style="background-image: url({{ asset('./img/card.png') }})">
                                    <span class="absolute bottom-2 left-2 bg-gray-card text-sm px-2 rounded-md">10 pertanyaan</span>
                                </div>
                                <div class="flex flex-col justify-between h-2/6 px-1">
                                    <div class="flex flex-col space-y-1 p-1">
                                        <a 
                                            @auth
                                                href="{{ route('room.pre-waiting-host', $data->slug) }}" 
                                            @endauth
                                            @guest
                                                onclick="triggerAuthPopup()"
                                            @endguest
                                            class="font-semibold text-lg cursor-pointer">
                                            {{ $data->title }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- If we need navigation buttons -->
                        <x-slot name="nav_btn">
                            <x-swiper-navigation />
                        </x-slot>
                    </x-swiper-container>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        {{-- swiper  --}}
        <script>
            $( window ).on( "load", function() {
                const swiper = new Swiper('.swiper', {
                    // Optional parameters
                    slidesPerView: 2,
                    spaceBetween: 15,
                    slideShadows: true,
                    // Navigation arrows
                    breakpoints: {
                        768:{
                            slidesPerView: 3,
                            spaceBetween: 20,
                            slideShadows: true,
                        },
                        1024:{
                            slidesPerView: 4,
                            spaceBetween: 30,
                            slideShadows: true,
                        },
                        1280:{
                            slidesPerView: 4,
                            spaceBetween: 30,
                            slideShadows: true,
                        },
                        1600:{
                            slidesPerView: 5,
                            spaceBetween: 45,
                            slideShadows: true,
                        }
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            });
        </script>
        {{-- redirect with message  --}}
        <script>
            const message = "{{ session('message') }}";
            if(message){
                Swal.fire({
                    title: message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
            }
        </script>
    @endsection
</x-main-layout>