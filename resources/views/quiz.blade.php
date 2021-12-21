<x-main-layout titlePage="Laravel" themePage="white">
    {{-- header stats --}}
    <div class="flex justify-between mt-6 md:mt-10 mx-4 md:mx-8 items-center ">
        {{-- button icon  --}}
        <div class="z-10 flex justify-between items-center space-x-3 md:space-x-4">
            
            <div class="bg-green-nav w-9 h-9 p-2 rounded">
                <button id="fullscreen"><img src="{{asset('images/fullscreen_icon.svg')}}"></button>
            </div>
            
            <span class="text-green-nav font-bold text-2xl md:text-3xl">{{ $roomQuestion->order }}/10</span> 
        </div>
        {{-- timer  --}}
        <div class="hidden md:block">
            <p class=" relative z-10 text-green-nav font-bold text-3xl">
                00:<span class="timer">{{ $roomQuestion->question->timer }}</span> 
            </p>
        </div>
        {{-- points and rank  --}}
        <div class="flex relative z-10 justify-between items-center space-x-4 md:space-x-6">
            <div class="flex items-center md:space-x-1">
                
                <div>
                    <img class="w-10 md:w-12" src="{{ asset('images/medal.png') }}" alt="">
                </div>
                
                <span class="text-green-nav font-bold text-xl md:text-2xl">3rd</span>
            </div>
            <div class="bg-green-nav p-1 md:p-2 rounded">
                <div class="text-white font-bold text-2xl">
                    <span>100</span>  
                    <span class="hidden md:inline">Points</span>
                    <span class="md:hidden">Pts</span>
                </div>
            </div>
        </div>
    </div>
    {{-- timer mobile  --}}
    <div class="mt-10 mb-6 flex items-center justify-center md:hidden">
        <p class=" relative z-10 text-green-nav font-bold text-2xl md:text-3xl">
            00:<span class="timer">{{ $roomQuestion->question->timer }}</span> 
        </p>
    </div> 
    {{-- question text --}}
    <div class="flex items-center justify-center md:py-16 z-10 relative max-w-6xl mx-5 xl:mx-auto ">
        <p class="text-green-nav text-xl lg:text-3xl font-bold text-center leading-relaxed">{{ $roomQuestion->question->question }}.</p>
    </div>
    {{-- question image --}}
    @if($roomQuestion->question->image)
    <div class="max-w-6xl mx-5 md:mx-auto relative z-10 mb-8">
        <img class="mx-auto" src="{{ asset('images/question_img.png') }}" alt="">
    </div>
    @else

    @endif
    {{-- question options  --}}
    <form id="form-answer" action="" method="POST" class="grid grid-cols-12 gap-6 md:gap-10 max-w-6xl mx-5 xl:mx-auto relative z-10 text-white my-10">
        <div data-option="option_1" id="option_1" class="options ring-red-200 cursor-pointer rounded-md flex space-x-2 bg-red-redMain col-span-12 md:col-span-6 py-6 px-3 font-bold text-lg md:text-2xl">
            <span>A.</span> <span>{{ $roomQuestion->question->option_1 }}.</span> 
        </div>
        <div data-option="option_2" id="option_2" class="options ring-green-200 cursor-pointer rounded-md flex space-x-2 bg-green-greenMain col-span-12 md:col-span-6 py-6 px-3 font-bold text-lg md:text-2xl">
            <span>B.</span> <span>{{ $roomQuestion->question->option_2 }}.</span> 
        </div>
        <div data-option="option_3" id="option_3" class="options ring-blue-200 cursor-pointer rounded-md flex space-x-2 bg-blue-blueMain col-span-12 md:col-span-6 py-6 px-3 font-bold text-lg md:text-2xl">
            <span>C.</span> <span>{{ $roomQuestion->question->option_3 }}.</span> 
        </div>
        <div data-option="option_4" id="option_4" class="options ring-yellow-200 cursor-pointer rounded-md flex space-x-2 bg-yellow-yellowMain col-span-12 md:col-span-6 py-6 px-3 font-bold text-lg md:text-2xl">
            <span>D.</span> <span>{{ $roomQuestion->question->option_4 }}.</span> 
        </div>
        {{-- <input class="col-span-12" id="answer" type="text" name="answer" value=""> --}}
    </form>
    @section('script')
    <script>    
        $( document ).ready(function(){
            // const allTimer = $(".timer");
            setInterval(() => {
                const allTimer = $(".timer");
                const timerNow = parseInt(allTimer[0].innerText);
                allTimer[0].innerText = timerNow-1;
                allTimer[1].innerText = timerNow-1;
            }, 1000);
            $('#form-answer .options').click(function(){
                $(this).parent().find('.ring-8').removeClass('ring-8');
                $(this).addClass('ring-8');
                var val = $(this).attr('data-option');
                $(this).parent().find('input').val(val);
            });
        });
    </script>
    @endsection
</x-main-layout>