<x-main-layout titlePage="Laravel" >
    {{-- button icon --}}
    <div class="flex justify-start mt-10 ml-8">
        <div class="bg-green-nav w-9 h-9 p-2 z-10 rounded mr-4">
            <a href="{{ route('index') }}"><img src="{{asset('images/cross_icon.svg')}}"></a>
        </div>
        <div class="bg-green-nav w-9 h-9 p-2 z-10 rounded">
            <button id="fullscreen"><img src="{{asset('images/fullscreen_icon.svg')}}"></button>
        </div>
    </div>
    {{-- quiz card --}}
    <div class="font-poppins mt-6 mb-10 ">
        <div class="flex flex-col mx-auto justify-center items-center  pt-3 max-w-md ">
            <div class="sm:max-w-lg z-10 mx-8 shadow-profile">
                <div class="bg-green-nav px-8 py-8 rounded-t-lg">
                {{-- generate quiz title --}}
                    <h1 class="text-center text-2xl font-bold text-white">Sejarah Nabi Adam AS</h1>
                </div>
                <div class="bg-white px-6 py-6 rounded-b-lg">
                    <h1 class="text-xl text-green-nav pb-1 font-bold ">Room Code</h1>
                    <div class="border border-green-nav text-center py-2">
                        <h1 class="text-3xl">12323</h1>
                    </div>
                    <h1 class="text-xl text-green-nav pt-6 pb-1 font-bold">Share Link</h1>
                    <div class="border border-green-nav text-center py-2 flex justify-evenly items-center px-1">
                        <h1 class="text-3xl ">quiz.com/12323</h1>
                        <a href="#" class=""><img src="{{asset('images/copy_vector.svg')}}" alt=""></a>
                    </div>
                    {{-- button --}}
                    <div class="flex justify-around mt-10 mb-2">
                        <a href="#" class="bg-green-nav text-white text-2xl px-7 py-1 rounded-sm font-semibold">MULAI</a>
                        <a href="#" class="border border-green-nav text-green-nav px-7 py-1 text-2xl rounded-sm font-semibold">BATAL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- user card --}}
    <div class="w-11/12 mx-auto bg-white">
    <h1 class="z-10">tes</h1>
    </div>
    @section('script')
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
    @endsection
</x-main>