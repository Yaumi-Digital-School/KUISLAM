<x-main-layout titlePage="Laravel" >
    {{-- button icon --}}
    <div class="flex justify-between mt-10 mx-8">
        <div class="flex justify-start">
            <div class="bg-green-nav w-9 h-9 p-2 z-10 rounded mr-4">
                <a href="{{ route('room.exit', $room->code) }}"><img src="{{asset('images/cross_icon.svg')}}"></a>
            </div>
            <div class="bg-green-nav w-9 h-9 p-2 z-10 rounded">
                <button id="fullscreen"><img src="{{asset('images/fullscreen_icon.svg')}}"></button>
            </div>
        </div>
        <div class="bg-white w-20 rounded flex px-2 items-center justify-between z-10">
            {{-- Number of player --}}
            <h1 id="player-count" class="text-2xl font-bold text-green-nav">{{ $roomUser->count() }}</h1>
            <img src="{{asset('images/player_icon.svg')}}">
        </div>
    </div>
    {{-- quiz card --}}
    <div class="font-poppins my-6">
        <div class="flex flex-col mx-auto justify-center items-center pt-3 max-w-md ">
            <div class="sm:max-w-lg z-10 mx-8 shadow-profile">
                <div class="bg-green-nav px-8 py-8 rounded-t-lg">
                {{-- generate quiz title --}}
                    <h1 class="text-center text-2xl font-bold text-white">{{ $room->quiz->title }}</h1>
                </div>
                <div class="bg-white px-6 py-6 rounded-b-lg">
                    <h1 class="text-xl text-green-nav pb-1 font-bold ">Room Code</h1>
                    <div class="border border-green-nav text-center py-2">
                        <h1 class="text-3xl">{{ $room->code }}</h1>
                    </div>
                    <h1 class="text-xl text-green-nav pt-6 pb-1 font-bold">Share Link</h1>
                    <div class="border border-green-nav text-center py-2 flex justify-evenly items-center px-1">
                        <h1 id="link" class="text-3xl ">quiz.com/{{ $room->code }}</h1>
                        <button id="btn-copy" class="after:bg-green after:rounded after:h-10 after:w-10"><img src="{{asset('images/copy_vector.svg')}}" alt=""></button>
                    </div>
                    {{-- number of question --}}
                    <div class="pt-6">
                        <h1 class="text-xl text-green-nav text-center font-semibold">Jumlah Soal:</h1>
                        <h1 class="text-3xl text-green-nav text-center font-bold">10</h1>
                    </div>
                </div>
            </div>
        </div>       
    </div>

    <h1 class="text-center text-white text-3xl font-bold mb-3 z-10 relative">Menunggu permainan dimulai...</h1>
    
    {{-- user card container--}}
    <div class="w-11/12 mx-auto flex justify-between flex-wrap z-10">
    {{-- user card --}}
        @foreach($roomUser as $data)
            <div class="bg-white shadow-profile w-60 h-20 flex justify-center items-center px-2 py-1 rounded-lg z-10 my-4 mx-auto">
                <div id="user-{{ $data->user_id }}" class="flex items-center h-16 w-16 mr-2">
                    <img src="{{asset('images/default_profpic.png')}}" class="rounded-full">
                </div>
                    <h1 class="text-green-nav text-xl font-bold">{{ $data->user->name }}</h1>
            </div>      
        @endforeach
    </div>

    @section('script')
        <script src="/js/app.js"></script>
        {{-- listen join room  --}}
        <script>
            const room_id = "{{$room->id}}";
            window.Echo.channel(`joined-room-${room_id}`).listen("UserJoinedRoom", (data) => {
                $( document ).ready(function(){
                    $newUserDiv = $("<div></div>").addClass("bg-white shadow-profile w-60 h-20 flex justify-center items-center px-2 py-1 rounded-lg z-10 my-4 mx-auto");                    
                    $newUserDiv.attr("id", `user-${data.user_data.id}`);
                    $newUserImageDiv = $("<div></div>").addClass("flex items-center h-16 w-16 mr-2");
                    $newUserImage = $("<img src={{asset('images/default_profpic.png')}}></img>").addClass("rounded-full");
                    $newUserName = $("<div></div>").addClass("text-green-nav text-xl font-bold").html(data.user_data.name);

                    $newUserImageDiv.append($newUserImage);
                    $newUserDiv.append($newUserImageDiv);
                    $newUserDiv.append($newUserName);

                    $("#card-user-container").prepend($newUserDiv);
                    
                    let playerCount = $("#player-count").text();
                    playerCount = parseInt(playerCount) + 1;
                    $("#player-count").html(playerCount);
                });
            });
        </script>
        {{-- listen exit room  --}}
        <script>     
            window.Echo.channel(`exit-room-${room_id}`).listen("UserExitRoom", (data) => {
                $( document ).ready(function(){
                    let playerCount = $("#player-count").text();
                    playerCount = parseInt(playerCount) - 1;
                    $("#player-count").html(playerCount);

                    $(`#user-${data.user_data.id}`).remove();
                });
            });
        </script>
        {{-- listen host start quiz  --}}
        <script>
            const room_code = "{{$room->code}}";
            const order = "1";
            window.Echo.channel(`start-quiz-${room_code}`).listen("HostStartQuiz", (data) =>{
                let url = "{{ route('question.view', ['room' => ':room', 'order' => '1']) }}";
                url = url.replace(':room', room_code);
                window.location.href = url;
            });
        </script>
        {{-- list host cancel quiz  --}}
        <script>
            window.Echo.channel(`host-cancel-room-${room_id}`).listen("HostCancelRoom", (data) => {
                const message = "host_exit_room";

                let url = "{{ route('index.redirect', ['message' => ':message']) }}";
                url = url.replace(':message', message);
                
                window.location.href = url;
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
</x-main>