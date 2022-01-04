<x-main-layout titlePage="Laravel">
    {{-- header leaderbord  --}}
    @if($final === false)
        {{-- Breadcrumbs question --}}
        <h1 class="text-2xl md:text-3xl text-white font-bold pt-12 pb-8 sm:px-20 z-10 relative font-poppins text-center sm:text-left">{{ $order }}/10</h1>
        <h1 class="text-3xl md:text-4xl text-white font-poppins font-bold text-center z-10 relative pb-8">Curent Ranking</h1>
    @elseif($final === true)
        {{-- Button Close if it's Final Leaderboard --}}
        <div class="flex justify-start">
            <div class="bg-green-nav w-9 h-9 p-2 z-10 rounded mt-12 mb-8 ml-12 realtive">
                <a href="{{ route('game.exit', $code) }}"><img src="{{asset('images/cross_icon.svg')}}"></a>
            </div>
        </div>
        <h1 class="text-3xl md:text-4xl text-white font-poppins font-bold text-center z-10 relative pb-8">Leaderboard</h1>
    @endif
    
    {{-- rank board  --}}
    @php
        $colorBgLeaderbord = "bg-green-leaderbord ";
        $colorTextLeaderboard = "text-brown-leaderboard";
        $colorPointLeaderboard = "text-green-darkBg";
        $colorBorderAva = "border-green-nav";
    @endphp
    {{-- Rank Container--}}
    <div class="z-10 relative px-12 flex mb-8 flex-col justify-center space-y-4 items-center font-poppins max-w-2xl mx-auto">
        @foreach($roomUser as $data)
            @if ($data->user->id == Auth::id())
                @php
                    $colorBgLeaderbord = "bg-white";
                @endphp
            @endif
            @php
                $file = App\Models\User::authUserImageIsFile($data->user->avatar);
            @endphp
            {{-- user card  --}}
            <div class="relative z-10 h-16 md:h-20 lg:h-24 w-full">
                @if ($final)
                    @php
                        $colorPointLeaderboard = "text-white";
                        $colorTextLeaderboard = "text-white";
                        $colorBorderAva = "border-gray-nav";
                        if($loop->index + 1 == 1){
                            $medal = "images/1st_medal.svg";
                            $colorBgLeaderbord = "bg-orange-podium";
                        } 
                        else if($loop->index + 1 == 2){
                            $medal = "images/2nd_medal.svg";
                            $colorBgLeaderbord = "bg-blue-blueMain";
                        } 
                        else if($loop->index + 1 == 3){
                            $medal = "images/3rd_medal.svg";
                            $colorBgLeaderbord = "bg-red-redMain";
                        } 
                    @endphp
                    {{-- medal  --}}
                    <div class="flex justify-center absolute -left-10 sm:-left-14 top-2 sm:top-0 md:top-2 lg:top-4">
                        <img class="z-20 relative h-10 sm:h-14" src="{{asset($medal)}}"> 
                    </div> 
                @endif
                {{-- rank info --}}
                <div class="{{ $colorBgLeaderbord }} flex justify-between items-center space-x-3 w-full h-full 
                    rounded-lg mb-4 px-3 py-3 {{ $colorTextLeaderboard }} font-bold text-md sm:text-lg md:text-xl lg:text-2xl">
                    {{-- User Position --}}
                    <div class="">
                        <h1 class="">{{$loop->index+1}}</h1>
                    </div>
                    {{-- User Avatar  --}}
                    <div class="flex justify-center items-center w-3/12 sm:w-2/12 h-full">
                        @if($data->user->avatar)
                            @if($file === true)
                            <img src="{{ asset('storage/user/avatar/'. $data->user->avatar) }}" class="h-10 sm:h-12 lg:h-14 rounded-full {{ $colorBorderAva }} border-4">
                            @else                        
                            <img src="{{ $data->user->avatar }}" class="h-10 sm:h-12 lg:h-14 rounded-full {{ $colorBorderAva }} border-4">
                            @endif
                        @else
                            <img src="{{asset('images/default_profpic.png')}}" class="h-10 sm:h-12 lg:h-14 rounded-full {{ $colorBorderAva }} border-4">
                        @endif
                    </div>
                    {{-- User Name  --}}
                    <div class="w-6/12">
                        <h1 class="">{{ $data->user->name }}</h1>
                    </div>
                    {{-- User Points  --}}
                    <div class="w-2/12 sm:w-3/12 {{ $colorPointLeaderboard }}">
                        <h1 class=" text-center">{{ $data->points }} pts</h1>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Button Show All --}}
    @if($final)
        <button class="px-4 py-2 mb-8 hover:bg-gray-200 transition focus:outline-none bg-white z-10 relative mx-auto mt-4 flex justify-center items-center rounded-md shadow-lg">
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
                let intervalId = setTimeout(() => {
                    let url = "{{ route('question.view', ['room' => ':room', 'order' => ':order']) }}";
                    url = url.replace(':room', room_code);
                    url = url.replace(':order', order+1);
                    window.location.href = url;
                    clearTimeout(intervalId);
                }, timeLeftForLeaderboard);
            }
        </script>
    @endsection
</x-main>