<x-main-layout titlePage="Laravel" themePage="white">
    {{-- @if (session('message'))
        {{dd(session('message'))}}
    @endif --}}
    {{-- additional style  --}}
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
                        <div class="bg-gray-input w-full md:w-5/6 px-4 pb-4 pt-4 @error("code") pt-6 @enderror rounded-sm">
                            <form action="{{ route('room.join-code') }}" method="POST" class="flex flex-col">
                                @csrf
                                <div class="flex flex-col space-y-5 md:space-y-0 md:flex-row md:space-x-6">
                                    <input type="text" name="code"
                                        class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Masukan kode game...">
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
                            @auth
                                @if(!Auth::user()->avatar)
                                    <div class="flex items-center h-10 w-10 ">
                                        <img class="rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="burger icon">
                                    </div>
                                @else
                                    <div class="flex items-center h-10 w-10 ">
                                        <img class="rounded-full" src="{{ asset('storage/user/avatar/'. Auth::user()->avatar) }}" alt="burger icon">
                                    </div>
                                @endif
                            @endauth
                            @guest
                                <div class="flex items-center h-10 w-10 ">
                                    <img class="rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="burger icon">
                                </div>
                            @endguest
                            <div class="flex flex-col items-center">
                                @auth
                                    <p class="font-semibold text-lg">{{ Auth::user()->name }}</p>
                                    <div class="flex text-sm space-x-2 text-green-lightBg font-semibold">
                                        <a href="{{  route('profile.detail-account') }}" class="hover:underline">Edit Profil</a>
                                        <span>&#8226</span>
                                        <a href="{{ route("activity") }}" class="hover:underline">Lihat Aktivitas</a>
                                    </div>
                                @endauth
                                @guest
                                    <p class="font-semibold text-lg">Kamu belum login!</p>
                                    <div class="flex text-sm space-x-2 text-green-lightBg font-semibold">
                                        <a href="{{ route('login') }}" class="hover:underline">Masuk</a>
                                        <span>&#8226</span>
                                        <a href="{{ route('register') }}" class="hover:underline">Daftar</a>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                    {{-- mobile  profile --}}
                    <div style="border: 1px solid #F8F8F8;" class="drop-shadow-profile mt-3 rounded-lg md:rounded-none md:m-0 z-10 py-3 flex md:hidden justify-center items-center bg-gray-lightBg col-span-5">
                        <div class="flex flex-col items-center space-y-3 md:space-y-1 ">
                            @auth
                                <div class="flex items-center h-10 w-10 ">
                                    <img class="rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="burger icon">
                                </div>
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
                        <div class="md:mx-4 relative swiper-container">
                            @auth
                                <div class="swiper w-full h-64 md:h-80">
                            @endauth
                            @guest
                                <div class="swiper w-full h-64 md:h-72">
                            @endguest
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach($roomUser as $data)
                                        @php
                                            $description = $data->room->quiz->description;
                                            if(strlen($description) > 60)
                                                $description = substr($description, 0, 60);
                                            $description .= " ...";
                                        @endphp    
                                        {{-- red 0% akurasi --}}
                                        <div class="swiper-slide flex flex-col rounded-lg bg-gray-card p-2">
                                            <div class="h-3/5 w-full relative bg-indigo-300 rounded-lg">
                                                <span class="absolute bottom-2 left-2 bg-gray-nav text-white text-sm px-2 rounded-xl">10 pertanyaan</span>
                                            </div>
                                            <div class="flex flex-col justify-between h-2/5">
                                                <div class="flex flex-col space-y-1 p-1">
                                                    <a href="#" class="font-bold">
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
                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev">
                                    <div class="hidden xl:flex text-3xl text-white bg-green-lightBg p-1">
                                        <i class='bx bx-chevron-left'></i>
                                    </div>
                                </div>
                                <div class="swiper-button-next">
                                    <div class="hidden xl:flex text-3xl text-white bg-green-lightBg p-1">
                                        <i class='bx bx-chevron-right'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- swiper --}}
                <div class="mt-3 md:mt-10 flex flex-col space-y-3 md:space-y-6">
                    <div class="z-10 text-xl md:text-2xl font-bold relative">
                        <h1>Popular Quiz</h1>
                    </div>
                    <div class="md:mx-4 relative swiper-container">
                        @auth
                            <div class="swiper w-full h-64 md:h-80">
                        @endauth
                        @guest
                            <div class="swiper w-full h-64 md:h-72">
                        @endguest
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @foreach($quizzes as $data)
                                    @php
                                        $description = $data->description;
                                        if(strlen($description) > 100)
                                            $description = substr($description, 0, 100);
                                        $description .= " ...";
                                    @endphp    
                                    {{-- red 0% akurasi --}}
                                    <div class="swiper-slide flex flex-col rounded-lg bg-gray-card p-2">
                                        <div class="h-3/5 w-full relative bg-indigo-300 rounded-lg">
                                            <span class="absolute bottom-2 left-2 bg-gray-nav text-white text-sm px-2 rounded-xl">10 pertanyaan</span>
                                        </div>
                                        <div class="flex flex-col justify-between h-2/5">
                                            <div class="flex flex-col space-y-1 p-1">
                                                <a href="{{ route('room.pre-waiting-host', $data->slug) }}" class="font-bold">
                                                    <h3 class="text-sm text-black-cardText">{{ $data->title }}</h3>
                                                    <span class="text-sm text-gray-cardText">{{ $description }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev">
                                <div class="hidden xl:flex text-3xl text-white bg-green-lightBg p-1">
                                    <i class='bx bx-chevron-left'></i>
                                </div>
                            </div>
                            <div class="swiper-button-next">
                                <div class="hidden xl:flex text-3xl text-white bg-green-lightBg p-1">
                                    <i class='bx bx-chevron-right'></i>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    // Navigation arrows
                    breakpoints: {
                        768:{
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1024:{
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                        1280:{
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                        1600:{
                            slidesPerView: 5,
                            spaceBetween: 45,
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
            if("{{ session('message') }}"){
                Swal.fire({
                    title: 'Host telah membatalkan permainan!',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
            }
        </script>
    @endsection
</x-main-layout>