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