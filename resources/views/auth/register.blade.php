<x-main-layout titlePage="Laravel">
    {{-- navbar --}}
    <div class="bg-green-nav fixed w-full h-16 top-0 z-20">
        <nav class="text-white flex justify-between items-center px-6 font-bold" style="height: 8vh">
            <span class="text-lg">Logo</span>
            <a class="text-lg" href="{{ route('login') }}">Login</a>
        </nav>
    </div>
    {{-- main content  --}}
    <div class="bg-green-lightBg font-poppins h-screen mt-6 relative overflow-hidden">
        {{-- main container  --}}
        <div class="grid grid-cols-12 pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-full ">
            {{-- picture lets play together  --}}
            <div class="hidden lg:col-span-6 lg:flex justify-center items-center z-10">
                <div><img class="ml-6" src="{{ asset('images/login.png') }}" alt=""></div>
            </div>
            {{-- form login  --}}
            <div class="col-span-12 lg:col-span-6 mx-auto flex justify-center items-center z-10">
                <form action="" method="POST">
                    <div class="bg-white rounded-lg mx-4 pb-2 max-w-md min-w-min">
                        <div>
                            <img src="{{ asset('images/login_form.png') }}" alt="">
                        </div>
                        <div class="flex flex-col space-y-5">
                            <div class="flex flex-col space-y-2 text-center font-bold text-xl pt-6">
                                <h1>Selamat datang di</h1>
                                <h1>Quiz Generator</h1>
                            </div>
                            <p class="lg:hidden text-justify text-sm w-5/6 mx-auto text-gray-400 ">Asah dan tingkatkan kemampuan kamu mengenal islam dengan mengikuti kuis !</p>
                            <a href="" class="flex justify-center items-center bg-blue-500 w-5/6 mx-auto px-3 py-2 rounded-md ">
                                <x-google-logo />
                                <span class="ml-2 text-white text-md">Lanjutkan dengan Google</span>
                            </a>
                            <p class="text-center">atau</p>
                            <div class="flex flex-col space-y-2 w-5/6 mx-auto">
                                <label for="email">Daftar dengan email</label>
                                <input class="rounded-md h-8 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    type="email" name="email" placeholder="Masukan email anda">
                            </div>
                            <button class="w-5/6 bg-green-lightBg mx-auto text-white rounded-md py-1 hover:bg-green-darkBg">Lanjut</button>
                            <div class="text-center"><span>Sudah punya akun?</span> <a class="text-green-lightBg" href="{{ route('register') }}">masuk</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- ball stuff  --}}
        <div class="bg-green-darkBg rounded-full absolute -left-48 -top-48" style="height: 35rem; width: 35rem"></div>
        <div class="bg-green-darkBg rounded-full absolute -right-40 -bottom-20 flex justify-center items-center" style="height: 35rem; width: 35rem">
            <div class="bg-green-lightBg rounded-full" style="height: 28rem; width: 28rem"></div>
        </div>
    </div>
</x-main-layout>