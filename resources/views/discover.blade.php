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
        </style>
    @endsection
    
    {{-- navbar  --}}
    @include('layouts.navigation', ['themePage' => 'white'])

    
    {{-- main content --}}
    <div class="font-poppins mt-20 md:mt-28">
       {{-- main container  --}}
       <div class="max-w-screen-xl 3xl:max-w-screen-2xl mx-auto h-screen ">
        <div class="px-4 xl:px-0 pb-20">
            {{-- search and topic list --}}
            <div class="z-10 relative flex flex-col md:flex-row justify-between space-y-4 mb-8 bg-gray-lightBg md:shadow-profile rounded-lg md:px-8 md:pt-4 lg:pt-2 md:h-24">
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
                        <div class="swiper-topic w-full h-10 lg:h-12">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @foreach($topics as $topic)
                                    <a href="{{ route('discover') }}?topic={{ $topic->slug }}" class="swiper-slide flex flex-col border-2 border-red-redMain text-red-redMain font-semibold justify-center items-center rounded">
                                        {{ $topic->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- swiper --}}
            <div class="flex flex-col space-y-8">
                @foreach($quizzes as $topic_name => $quiz)
                <div class="md:mx-4 relative swiper-container">
                    <div class="z-10 text-xl md:text-2xl font-bold relative">
                        <h1>{{ $topic_name }}</h1>
                    </div>
                    @auth
                        <div class="swiper w-full h-64 md:h-80">
                    @endauth
                    @guest
                        <div class="swiper w-full h-64 md:h-72">
                    @endguest
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @foreach($quiz as $data)
                                @php
                                    $description = $data->description;
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
                                            <a href="{{ route('room.pre-waiting-host', $data->slug) }}" class="font-bold">
                                                <h3 class="text-sm text-black-cardText">{{ $data->title }}</h3>
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
                @endforeach
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
            });
        </script>
    @endsection
</x-main-layout>