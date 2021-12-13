<x-main-layout titlePage="Laravel" themePage="white">
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
            .swiper-button-next{
                position: absolute;
                right: -4%;
            }
            .swiper-button-prev{
                position: absolute;
                left: -4%;
            }
        </style>
    @endsection
    
    {{-- navbar  --}}
    @include('layouts.navigation')

    {{-- main content --}}
    <div class="font-poppins mt-20 md:mt-28">
        {{-- main container  --}}
        <div class="max-w-screen-xl 3xl:max-w-screen-2xl mx-auto h-screen ">
            <div class="px-4 xl:px-0 pb-20">
                {{-- code enter and profile --}}
                <div class="flex flex-col md:grid md:grid-cols-12 justify-between gap-x-20">
                    {{-- text mau bermain game?  --}}
                    <div class="flex md:hidden">
                        <p class="z-10">Mau bermain game?</p>
                    </div>
                    {{-- kode game  --}}
                    <div class="md:shadow-profile rounded-lg mt-3 md:m-0 z-10 md:py-3 flex justify-center items-center bg-gray-lightBg col-span-7">
                        <div class="bg-gray-input w-full md:w-5/6 p-4 rounded-sm">
                            <form action="{{ route('room.join-code') }}" method="POST" class="flex flex-col space-y-5 md:space-y-0 md:flex-row md:space-x-6">
                                @csrf
                                <input type="text" name="code"
                                    class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Masukan kode game...">
                                <button type="submit" 
                                    class="bg-green-lightBg mx-auto w-full md:w-min font-semibold text-white rounded-md py-1 px-6 hover:bg-green-darkBg transition">
                                    Gabung
                                </button>
                            </form>
                            @error('code')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                    </div>
                    {{-- desktop  profile --}}
                    <div class="shadow-profile rounded-lg mt-3 md:m-0 z-10 py-3 hidden md:flex justify-center items-center bg-gray-lightBg col-span-5">
                        <div class="flex flex-col items-center space-y-1">
                            @auth
                                <div class="flex items-center h-10 w-10 ">
                                    <img class="rounded-full" src="{{ Auth::user()->avatar }}" alt="burger icon">
                                </div>
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
                                        <a href="{{  route('profile.detail-account') }}">Edit Profil</a>
                                        <span>&#8226</span>
                                        <a href="{{  route('roomuser.getallplayedquiz') }}">Lihat Aktivitas</a>
                                    </div>
                                @endauth
                                @guest
                                    <p class="font-semibold text-lg">Kamu belum login!</p>
                                    <div class="flex text-sm space-x-2 text-green-lightBg font-semibold">
                                        <a href="{{ route('login') }}">Masuk</a>
                                        <span>&#8226</span>
                                        <a href="{{ route('register') }}">Daftar</a>
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
                                        <a href="">Edit Profil</a>
                                        <span>&#8226</span>
                                        <a href="">Lihat Aktivitas</a>
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
                {{-- swiper --}}
                <div class="mt-3 md:mt-10 flex flex-col space-y-3 md:space-y-6">
                    @for ($i = 0; $i < 2; $i++)
                        <div class="z-10 text-xl md:text-2xl font-bold relative">
                            <h1>Sejarah Nabi</h1>
                        </div>
                        <div class="md:mx-4 relative swiper-container">
                            <div class="swiper w-full h-64 md:h-72">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @for ($j = 0; $j < 8; $j++)
                                        <div class="swiper-slide flex flex-col rounded-lg bg-gray-card p-2">
                                            <div class="h-3/5 w-full relative bg-indigo-300 rounded-lg">
                                                <span class="absolute bottom-2 left-2 bg-gray-nav text-white text-sm px-2 rounded-xl">10 pertanyaan</span>
                                            </div>
                                            <div class="h-2/5 flex flex-col space-y-1 p-1">
                                                <h1>Nama Quiz</h1>
                                                <span class="text-sm text-gray-cardText">Deskripsi Quiz</span>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <!-- If we need navigation buttons -->
                                <div class="xnext"></div>
                                <div class="xprev"></div>
                            </div>
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
                    @endfor
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $('.swiper-button-next').click(
                function(e){
                        $(this).parents('.swiper-container').find('.xnext').trigger('click');
            });
            $('.swiper-button-prev').click(
                function(e){$(this).parents('.swiper-container').find('.xprev').trigger('click');
            });
            
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
                        nextEl: '.xnext',
                        prevEl: '.xprev',
                    },
                });
            });
        </script>
    @endsection
</x-main-layout>