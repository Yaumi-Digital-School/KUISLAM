<x-main-layout titlePage="Waiting Room" >
    {{-- button icon --}}
    <div class="flex justify-between mt-10 mx-8">
        <div class="flex justify-start">
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
    <div class="font-poppins mt-6 mb-12">
        <div class="flex flex-col mx-auto justify-center items-center  pt-3 max-w-md ">
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
                        <div class="border border-green-nav text-center py-2 flex justify-evenly items-center px-1 overflow-hidden">
                            <h1 class="text-3xl ">Room {{ $room->code }}</h1>
                            <button id="copy-btn" class=""><img src="{{asset('images/copy_vector.svg')}}" alt=""></button>
                        </div>
                        {{-- button --}}
                        <div class="flex justify-around mt-10 mb-2">
                            <a href="{{ route('room.start', $room->code) }}" class="bg-green-nav hover:bg-green-darkBg transition text-white text-2xl px-7 py-1 rounded-sm font-semibold">MULAI</a>
                            <a href="{{ route('room.exit', $room->code) }}" class="border hover:bg-gray-100 transition border-green-nav text-green-nav px-7 py-1 text-2xl rounded-sm font-semibold">BATAL</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    {{-- user card container--}}
    <div id="card-user-container" class="w-11/12 mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-x-4 gap-y-3 mb-8 relative z-10">
        {{-- user card --}}
        @foreach($roomUser as $data)
            <div id="user-{{ $data->user_id }}"
                class="bg-white shadow-profile mx-auto w-56 h-20 flex justify-between items-center space-x-2 px-2 py-1 rounded-lg">
                <div class="flex justify-center items-center h-full w-1/5">
                    <img src="{{asset('images/default_profpic.png')}}" class="rounded-full h-10">
                </div>
                <h1 class="text-green-nav text-xl font-bold w-4/5">{{ $data->user->name }}</h1>
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
                    $newUserDiv = $("<div></div>").addClass("bg-white shadow-profile mx-auto w-56 h-20 flex justify-between items-center space-x-2 px-2 py-1 rounded-lg");                    
                    $newUserDiv.attr("id", `user-${data.user_data.id}`);
                    $newUserImageDiv = $("<div></div>").addClass("flex justify-center items-center h-full w-1/5");
                    $newUserImage = $("<img src={{asset('images/default_profpic.png')}}></img>").addClass("rounded-full h-10");
                    $newUserName = $("<h1></h1>").addClass("text-green-nav text-xl font-bold w-4/5").html(data.user_data.name);

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
        {{-- fullscreen  --}}
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
        </script>
        {{-- copy to cliboard  --}}
        <script>
            $("#copy-btn").click(function(){
                var dummy = document.createElement('input'),text;
                const roomCode = "{{$room->code}}";
                text = `http://kuislam.yaumi.id/rooms/${roomCode}/join/link`;
                document.body.appendChild(dummy);
                dummy.value = text;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                })
                Toast.fire({
                    title: "Copied to cliboard!",
                })
            })
        </script>
    @endsection
</x-main>