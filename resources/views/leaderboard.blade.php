<x-main-layout titlePage="Laravel">
    @if($final === false)
    {{-- Breadcrumbs question --}}
    <h1 class="font-poppins text-white text-2xl sm:hidden z-10 relative text-center pt-8 pb-2">Soal</h1>
    <h1 class="text-3xl text-white font-bold sm:pt-12 pb-8 sm:px-20 z-10 relative font-poppins text-center sm:text-left">{{ $order }}/10</h1>
    <h1 class="text-5xl text-white font-poppins font-bold text-center sm:z-10 hidden sm:block sm:relative pb-8">LEADERBOARD</h1>
    @elseif($final === true)
        {{-- Button Close if it's Final Leaderboard --}}
        <div class="flex justify-start">
            <div class="bg-green-nav w-9 h-9 p-2 z-10 rounded mt-12 mb-8 ml-12 realtive">
                <a href="{{ route('game.exit', $code) }}"><img src="{{asset('images/cross_icon.svg')}}"></a>
            </div>
        </div>
        <h1 class="text-5xl text-white font-poppins font-bold text-center sm:z-10 hidden sm:block sm:relative pb-8">LEADERBOARD</h1>
        <h1 class="text-3xl text-white font-poppins font-semibold text-center z-10 sm:hidden relative pb-8">FINAL LEADERBOARD</h1>
    @endif
    
    {{-- Rank --}}
    @foreach($roomUser as $data)
        @php
            $file = App\Models\User::authUserImageIsFile($data->user->avatar);
        @endphp
        <div class="grid grid-cols-4 gap-x-2 grid-flow-row z-10 relative sm:px-12 px-4 rounded-full items-center">
            {{-- 1st --}}
            {{-- Medal --}}
            @if($loop->index === 0)
            <div class="flex justify-end row-start-1">
                <img class="z-20 relative w-10 sm:w-20 h-10 sm:h-20" src="{{asset('images/1st_medal.svg')}}"> 
            </div>
            <div class="col-start-2 col-end-4 bg-orange-podium flex justify-between sm:w-full w-60 sm:h-24 h-12 rounded-lg z-10 relative p-4 items-center mb-4">
                {{-- User Info --}}
                <div class="flex items-center">
                <h1 class="text-white font-bold sm:text-xl text-xs font-poppins mr-4">{{$loop->index+1}}</h1>
                    @if($data->user->avatar)
                        @if($file === true)
                            <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                <img src="{{ asset('storage/user/avatar/'. $data->user->avatar) }}" class="rounded-full border-green-nav border-4">
                            </div>
                        @else                        
                            <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                <img src="{{ $data->user->avatar }}" class="rounded-full border-green-nav border-4">
                            </div>
                        @endif
                    @else
                        <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                            <img src="{{asset('images/default_profpic.png')}}" class="rounded-full border-orange-avatar border-4">
                        </div>
                    @endif
                    <h1 class="text-white font-bold sm:text-xl text-xs font-poppins">{{ $data->user->name }}</h1>
                </div>
                {{-- score --}}
                <h1 class=" font-poppins font-bold sm:text-xl text-xs text-white">{{ $data->points }} pts</h1>
            </div>
            {{-- 2nd --}}
            {{-- Medal --}}
            @elseif($loop->index === 1)
            <div class="flex justify-end row-start-1">
                <img class="z-20 relative w-10 sm:w-20 h-10 sm:h-20" src="{{asset('images/2nd_medal.svg')}}"> 
            </div>
            <div class="col-start-2 col-end-4 bg-blue-600 flex justify-between sm:w-full w-60 sm:h-24 h-12 rounded-lg z-10 relative p-4 items-center mb-4">
                {{-- User Info --}}
                <div class="flex items-center">
                    <h1 class="text-white font-bold sm:text-xl text-xs font-poppins mr-4">{{$loop->index+1}}</h1>
                    @if($data->user->avatar)
                        @if($file === true)
                            <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                <img src="{{ asset('storage/user/avatar/'. $data->user->avatar) }}" class="rounded-full border-green-nav border-4">
                            </div>
                        @else                        
                            <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                <img src="{{ $data->user->avatar }}" class="rounded-full border-green-nav border-4">
                            </div>
                        @endif
                    @else
                        <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                            <img src="{{asset('images/default_profpic.png')}}" class="rounded-full border-green-avatar border-4">
                        </div>
                    @endif
                    <h1 class="text-white font-bold sm:text-xl text-xs font-poppins">{{ $data->user->name }}</h1>
                </div>
                {{-- score --}}
                <h1 class="text-white font-poppins font-bold sm:text-xl text-xs">{{ $data->points }} pts</h1>
            </div>
            {{-- 3rd --}}
            {{-- Medal --}}
            @elseif($loop->index === 2)
            <div class="flex justify-end row-start-1">
                <img class="z-20 relative w-10 sm:w-20 h-10 sm:h-20" src="{{asset('images/3rd_medal.svg')}}"> 
            </div>
            <div class="col-start-2 col-end-4 bg-green-podium flex justify-between sm:w-full w-60 sm:h-24 h-12 rounded-lg z-10 relative p-4 items-center mb-4">
                {{-- User Info --}}
                <div class="flex items-center">
                <h1 class="text-white font-bold sm:text-xl text-xs font-poppins mr-4">{{$loop->index+1}}</h1>
                    @if($data->user->avatar)
                        @if($file === true)
                            <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                <img src="{{ asset('storage/user/avatar/'. $data->user->avatar) }}" class="rounded-full border-green-nav border-4">
                            </div>
                        @else                        
                            <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                <img src="{{ $data->user->avatar }}" class="rounded-full border-yellow-avatar border-4">
                            </div>
                        @endif
                    @else
                        <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                            <img src="{{asset('images/default_profpic.png')}}" class="rounded-full border-orange-podium border-4">
                        </div>
                    @endif
                    <h1 class="text-white font-bold sm:text-xl text-xs font-poppins">{{ $data->user->name }}</h1>
                </div>
                {{-- score --}}
                <h1 class="text-white font-poppins font-bold sm:text-xl text-xs">{{ $data->points }} pts</h1>
            </div>
            
            {{-- 4th and goes on --}}
            @else
                <div class="px-12 sm:px-0 row-start-{{ $data->rank}} sm:col-start-2 col-start-1 sm:col-end-4 col-end-4 mb-4">
                    <div class="row-start-{{ $data->rank}} sm:col-start-2 col-start-1 sm:col-end-4 col-end-4 bg-gray-100 flex justify-between sm:w-full w-60 sm:h-24 h-12 rounded-lg z-10 relative p-4 items-center">
                        {{-- User Info --}}
                        <div class="flex items-center">
                            @if($data->user->avatar)
                                @if($file === true)
                                    <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                        <img src="{{ asset('storage/user/avatar/'. $data->user->avatar) }}" class="rounded-full border-green-lightBg border-4">
                                    </div>
                                @else                        
                                    <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                        <img src="{{ $data->user->avatar }}" class="rounded-full border-green-lightBg border-4">
                                    </div>
                                @endif
                            @else
                                <div class="flex items-center sm:h-16 h-8 sm:w-16 w-8 mr-2">
                                    <img src="{{asset('images/default_profpic.png')}}" class="rounded-full border-green-lightBg border-4">
                                </div>
                            @endif
                            <h1 class="text-green-nav font-bold sm:text-xl text-xs font-poppins">{{ $data->user->name }}</h1>
                        </div>
                        {{-- score --}}
                        <h1 class="text-green-nav font-poppins font-bold sm:text-xl text-xs">{{ $data->points }} pts</h1>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
    {{-- Button Show All --}}
    @if($final)
        <button class="sm:w-80 w-28 sm:h-20 h-8 bg-white z-10 relative mx-auto mt-4 flex justify-center items-center rounded-md shadow-lg">
            <h1 class="text-green-lightBg font-bold font-poppins sm:text-2xl text-xs">Lihat Semua</h1>
        </button>
    @endif

    @section('script')
        <script>
            const room_code = '{{$code}}';
            let order = '{{$order}}';
            const final = '{{$final}}';
            order = parseInt(order);
            console.log(order)
            if(!final){
                let timeLeftForLeaderboard = '{{$timeLeftForLeaderboard}}';
                timeLeftForLeaderboard = parseInt(timeLeftForLeaderboard) * 1000;
                console.log(timeLeftForLeaderboard);
                // let timeLeftForLeaderboard = 7000;
                setTimeout(() => {
                    let url = "{{ route('question.view', ['room' => ':room', 'order' => ':order']) }}";
                    url = url.replace(':room', room_code);
                    url = url.replace(':order', order+1);
                    window.location.href = url;
                }, timeLeftForLeaderboard);
            }
        </script>
    @endsection
</x-main>