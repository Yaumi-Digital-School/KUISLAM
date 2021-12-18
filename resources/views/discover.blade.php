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
    @include('layouts.navigation', ['themePage' => 'white'])

    
    {{-- main content --}}
    <div class="font-poppins mt-20 md:mt-28">
        {{-- main container  --}}
        <div class="md:shadow-profile rounded-lg mt-3 md:m-0 z-10 md:py-3 flex justify-center items-center bg-gray-lightBg col-span-7">
            <div class="bg-gray-input w-full md:w-5/6 p-4 rounded-sm">
               <!-- This is an example component -->
                <div class="pt-2 relative mx-auto text-gray-600">
                    <form action="{{ route('discover') }}" method="GET" class="z-10">
                        <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                        type="search" name="search" placeholder="Search">
                        <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                        <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                            width="512px" height="512px">
                            <path
                            d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="max-w-screen-xl 3xl:max-w-screen-2xl mx-auto h-screen ">
            <!-- component -->
            <div class="px-4 xl:px-0 pb-20">
                {{-- swiper --}}
                @foreach($quizzes as $topic_name => $quiz)
                    <div class="z-10 text-xl md:text-2xl font-bold relative">
                        <h1>{{ $topic_name }}</h1>
                    </div>
                    <div class="mt-3 md:mt-10 flex flex-col space-y-3 md:space-y-6">
                        <div class="md:mx-4 relative swiper-container">
                            <div class="swiper w-full h-64 md:h-72">
                            <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                <!-- Slides -->
                                    @foreach($quiz as $data)
                                        <div class="swiper-slide flex flex-col rounded-lg bg-gray-card p-2">
                                            <div class="h-3/5 w-full relative bg-indigo-300 rounded-lg">
                                                <span class="absolute bottom-2 left-2 bg-gray-nav text-white text-sm px-2 rounded-xl">10 pertanyaan</span>
                                            </div>
                                            <div class="h-2/5 flex flex-col space-y-1 p-1">
                                                <h1>{{ $data->title }}</h1>
                                                <span class="text-sm text-gray-cardText">{{ $data->description }}</span>
                                            </div>
                                        </div>
                                    @endforeach
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
                    </div>
                @endforeach
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