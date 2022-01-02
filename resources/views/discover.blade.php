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
            .swiper-pagination-bullet-active {
                background: #6DAF2B;
            }
        </style>
    @endsection
    
    {{-- navbar  --}}
    @include('layouts.navigation', ['themePage' => 'white'])

    
    {{-- main content --}}
    <div class="font-poppins mt-20 md:mt-28">
        {{-- main container  --}}
        <div class="max-w-screen-xl 3xl:max-w-screen-2xl mx-auto h-screen">
            <div class="px-4 xl:px-0 pb-20">
                {{-- search and topic list --}}
                <div class="z-10 relative flex flex-col md:flex-row justify-between space-y-4 md:space-y-0 mb-8 rounded-lg">
                    {{-- search quiz based on topic  --}}
                    <form action="{{ route('discover') }}" method="GET" class="z-10 md:w-2/5 flex flex-col md:flex-row space-y-4">
                        {{-- input title quiz --}}
                        <div class="relative w-full">
                            <span class="absolute top-1.5 left-0  flex items-center pl-2">
                                <button type="submit" class="p-1 focus:outline-none focus:shadow-outline text-gray-400">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5 "><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </span>
                            <input type="text" name="search"
                                class="rounded-md h-10 lg:h-12 w-full pl-10 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Masukan Judul Quiz...">
                            @error('title')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                    </form>
                    {{-- topic list  --}}
                    <h1 class="font-semibold md:hidden z-10 ">Populer Topic</h1>
                    <div class="md:w-3/5 mt-3 md:mt-0 flex flex-col item overflow-hidden">
                        <div class="md:mx-4 relative swiper-container">
                            <div class="swiper-topic w-full h-10 lg:h-12 p-1">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    @foreach($topics as $topic)
                                        <a href="{{ route('discover') }}?topic={{ $topic->slug }}" class="text-sm p-1 hover:bg-green-nav hover:text-white transition swiper-slide flex flex-col shadow-profile bg-gray-topicList text-gray-topicListTxt font-semibold justify-center items-center rounded">
                                            {{$topic->title}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- swiper hero slide  --}}
                <div class="swiper-container mb-8 overflow-hidden">
                    <div class="relative z-10 swiper-hero w-full h-64 md:h-80 p-2">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <div class="swiper-slide flex flex-col rounded-lg bg-gray-card shadow-custom1 overflow-hidden1" data-swiper-autoplay="2000">
                                <div class="h-full w-full relative rounded-lg bg-cover bg-center" style="background-image: url({{ asset('./img/hero_1.png') }})">
                                </div>
                            </div>
                            <div class="swiper-slide flex flex-col rounded-lg bg-gray-card shadow-custom1 overflow-hidden1" data-swiper-autoplay="2000">
                                <div class="h-full w-full relative rounded-lg bg-cover bg-center" style="background-image: url({{ asset('./img/hero_1.png') }})">
                                </div>
                            </div>
                            <div class="swiper-slide flex flex-col rounded-lg bg-gray-card shadow-custom1 overflow-hidden1" data-swiper-autoplay="2000">
                                <div class="h-full w-full relative rounded-lg bg-cover bg-center" style="background-image: url({{ asset('./img/hero_1.png') }})">
                                </div>
                            </div>
                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                {{-- swiper quiz list--}}
                <div class="flex flex-col space-y-8">
                    @foreach($quizzes as $topic_name => $quiz)
                    <div class="z-10 text-xl md:text-2xl font-bold relative">
                        <h1>{{ $topic_name }}</h1>
                    </div>
                    <div class="relative swiper-container">
                        <div class="swiper w-full h-56 md:h-64 p-2">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @foreach($quiz as $data) 
                                    <div class="swiper-slide flex flex-col rounded-lg bg-gray-card shadow-custom1">
                                        <div class="h-4/6 w-full relative bg-indigo-300 rounded-lg bg-cover bg-center" style="background-image: url({{ asset('./img/card.jpg') }})">
                                            <span class="absolute bottom-2 left-2 bg-gray-card text-sm px-2 rounded-md">10 pertanyaan</span>
                                        </div>
                                        <div class="flex flex-col justify-between h-2/6 px-1">
                                            <div class="flex flex-col space-y-1 p-1">
                                                <a @auth
                                                        href="{{ route('room.pre-waiting-host', $data->slug) }}" 
                                                    @endauth
                                                    @guest
                                                        onclick="triggerAuthPopup()"
                                                    @endguest class="font-semibold text-lg cursor-pointer">
                                                    {{ $data->title }}
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            $( window ).on( "load", function() {
                const swiperTopic = new Swiper('.swiper-topic', {
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
                            spaceBetween: 20,
                        },
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
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
                const swiperHero = new Swiper('.swiper-hero', {
                    // Optional parameters
                    slidesPerView: 1,
                    spaceBetween: 15,
                    // If we need pagination
                    pagination: {
                        el: '.swiper-pagination',
                    },
                    autoplay: {
                        delay: 4000,
                    },
                    speed: 1000,
                    loop: true,
                });
            });
        </script>
    @endsection
</x-main-layout>