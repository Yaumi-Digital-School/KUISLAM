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
                00:<span class="timer">{{ $timeLeftForQuestion }}</span> 
            </p>
        </div>
        {{-- points and rank  --}}
        <div class="flex relative z-10 justify-between items-center space-x-4 md:space-x-6">
            <div class="bg-green-nav p-1 md:p-2 rounded">
                <div class="text-white font-bold text-2xl">
                    <span>{{ $roomUser->points }}</span>  
                    <span class="hidden md:inline">Points</span>
                    <span class="md:hidden">Pts</span>
                </div>
            </div>
        </div>
    </div>
    {{-- timer mobile  --}}
    <div class="mt-10 mb-6 flex items-center justify-center md:hidden">
        <p class=" relative z-10 text-green-nav font-bold text-2xl md:text-3xl">
            00:<span class="timer">{{ (int) $timeLeftForQuestion ? $timeLeftForQuestion : '00'}}</span> 
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
    @endif
    {{-- question options  --}}
    <form id="form-answer" action="{{ route('question.handle', ['room' => $code, 'order' => $order]) }}" method="POST" class="grid grid-cols-12 gap-6 md:gap-10 max-w-6xl mx-5 xl:mx-auto relative z-10 text-white my-10">
        @csrf
        @php
            $colorBackground = ["bg-red-redMain", "bg-green-greenMain", "bg-blue-blueMain", "bg-yellow-yellowMain"];
            $colorRing = ["ring-red-200", "ring-green-200", "ring-blue-200", "ring-yellow-200"];
            $options = ["A", "B", "C", "D"];
            $colorBackgroundHover = ["bg-red-redMainHover", "bg-green-greenMainHover", "bg-blue-blueMainHover", "bg-yellow-yellowMainHover"];
            $hasRing = null;
        @endphp
        @for ($i = 1; $i <= 4; $i++)
            @php
                $hasRing = isset($user_answer) && ($user_answer == "option_{$i}") ? "ring-8" : null;
            @endphp
            <div data-option="option_{{$i}}" id="option_{{$i}}" class="options {{$hasRing}} {{$colorRing[$i-1]}} 
                {{isset($user_answer) ? null : "cursor-pointer"}} rounded-md flex space-x-2 {{$colorBackground[$i-1]}} 
                {{isset($user_answer) ? null : "hover:{$colorBackgroundHover[$i-1]}"}}
                transition col-span-12 md:col-span-6 py-6 px-3 font-bold text-lg md:text-2xl">
                <span>{{$options[$i-1]}}.</span> <span>{{ $roomQuestion->question->{'option_'.$i} }}</span> 
            </div>
        @endfor
        <input class="col-span-3 " id="answer" type="hidden" name="answer_option" value="">
        <input type="hidden" name="timer" value="60">
        <input type="hidden" name="code" value="{{$code}}">
        {{-- <button type="submit" class="col-span-6 relative z-20 text-white bg-black">HEHEHE</button> --}}
    </form>
    @section('script')
    <script>
        const room_code = "{{$code}}";    
        const order = "{{$order}}";

        let url = "{{ route('question.handle', ['room' => ':room', 'order' => ':order']) }}"
        url = url.replace(':room', room_code);
        url = url.replace(':order', order);

        let submittedAnswer = "{{ isset($user_answer) ? $user_answer : null }}";
        console.log(submittedAnswer);
        let answer = "option_5";
        
        function submitAnswer(answer, timer){
            // let responseSubmitted;
            if(!submittedAnswer){
                $.ajax({
                    type: "POST",
                    url: url,
                    async: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        answer_option: answer,
                        code: room_code,
                        order: order,
                        timer: timer
                    },
                    success: function(response){
                        console.log(response);
                        // responseSubmitted = response;
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            }
            // return responseSubmitted;
        }
        // timer countdown answer 
        $( document ).ready(function(){
            let intervalId = null;
            intervalId = setInterval(() => {
                const allTimer = $(".timer");
                const timerNow = parseInt(allTimer[0].innerText);
                if(timerNow >= 1){
                    allTimer[0].innerText = timerNow-1;
                    allTimer[1].innerText = timerNow-1;
                }
                if(timerNow <= 1){
                    clearInterval(intervalId);
                    console.log(order);  
                    submitAnswer("option_5", 0);
                    let urlRedirect = "{{ route('question.leaderboard', ['room' => ':room', 'order' => ':order']) }}";
                    urlRedirect = urlRedirect.replace(':room', room_code);
                    urlRedirect = urlRedirect.replace(':order', order);
                    window.location.href = urlRedirect;
                }
            }, 1000);

            // if a user already click the answer, submit them 
            $('#form-answer .options').click(function(){
                // dont let people submit twice 
                if(submittedAnswer) return;
                
                // add focus on selected answer 
                $(this).parent().find('.ring-8').removeClass('ring-8');
                $(this).addClass('ring-8');

                // submit answer
                const allTimer = $(".timer");
                const timer = parseInt(allTimer[0].innerText);
                answer = $(this).attr('data-option');
                submitAnswer(answer, timer);
                submittedAnswer = answer;

                // remove class indicating user still can submit
                $('#form-answer .options').removeClass('cursor-pointer');
                $('#form-answer .options').removeClass('cursor-pointer');
                $('#form-answer .options').removeClass('options');
            });
        });
    </script>
    {{-- fullscreen --}}
    <script>
        const body = document.documentElement;
        const btn_fullscreen = document.getElementById('fullscreen');
        
        function getFullscreenElement() {
            return document.fullscreenElement
                || document.msFullscreenElement
                || document.mozFullscreenElement
                || document.webkitFullscreenElement;
        }

        btn_fullscreen.addEventListener("click", ()=>{
            toggleFullscreen();
        });

        function toggleFullscreen() {
            if(getFullscreenElement()) {
                document.exitFullscreen();
            } else {
                body.requestFullscreen().catch(console.log);
            }
        }

        //icon copied to clipboard
        const btnCopy = document.getElementById('btn-copy');

        btnCopy.onclick = function() {
            //select the link
            document.getElementById('link').select();

            //copying the link
            document.execCommmand("copy")
        };
    </script>
    @endsection
</x-main-layout>