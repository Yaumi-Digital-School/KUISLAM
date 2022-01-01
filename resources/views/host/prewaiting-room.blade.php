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
        <div class="flex flex-col mx-auto justify-center items-center  pt-3 max-w-md">
            <div class="sm:max-w-lg z-10 mx-8">
                <div class="bg-green-nav px-8 py-8 rounded-t-lg">
                {{-- generate quiz title --}}
                    <h1 class="text-center text-2xl font-bold text-white">{{ $quiz->title }}</h1>
                </div>
                <div class="bg-white px-2 rounded-b-lg">
                    <h1 class="text-xl text-center py-4">Peraturan Permainan</h1>
                    <hr class="border-green-nav">
                    <ul class="text-left flex flex-col space-y-2 py-4 px-1">
                        <li>1. Pilih satu jawaban di setiap pertanyaan</li>
                        <li>2. Peserta dengan jawaban benar akan mendapat poin</li>
                        <li>3. Peserta dengan jawaban tercepat akan mendapatkan poin yang lebih banyak</li>
                        <li>4. Meski jawaban salah, peserta dapat lanjut bermain ke pertanyaan berikutnya</li>
                        <li>5. Di akhir sesi akan ditampilkan Leaderboard akumulasi poin jawaban benar</li>
                    </ul>
                </div>
            </div>
            {{-- button --}}
            <a href="{{ route('room.make', $quiz->slug) }}" class="bg-white my-8 hover:bg-gray-100 transition sm:w-64 py-2 rounded-md text-green-nav font-bold text-2xl cursor-pointer z-10 w-3/4 text-center shadow-profile">BUAT RUANGAN</a>
        </div>
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