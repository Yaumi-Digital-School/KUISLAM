<x-main-layout titlePage="Laravel">
    {{-- navbar --}}
    <div class="bg-green-nav fixed w-full h-16 top-0 z-20">
        <nav class="text-white flex w-2/3 md:w-full justify-between items-center px-6 font-bold h-full">
            <a href="{{ route('index') }}" class="md:hidden text-4xl flex items-center text-white">
                <i class='bx bx-chevron-left'></i>
            </a>
            <a href="{{ route("index") }}" class="">
                <img src="{{ asset('./images/logo.png') }}" alt="logo">
            </a>
            <a class="hidden md:block bg-green-lightBg py-1 px-3" href="{{ route('register') }}">Daftar</a>
        </nav>
    </div>
    {{-- main content  --}}
    <div class="font-poppins mt-10">
        {{-- main container  --}}
        <div class="grid grid-cols-12 pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-screen">
            {{-- picture lets play together  --}}
            <div class="hidden lg:col-span-6 lg:flex justify-center items-center z-10">
                <div>
                    <img style="height: 30rem" class="mx-20" src="{{ asset('images/login.png') }}" alt="image lets play together">
                </div>
            </div>
            {{-- form login  --}}
            <div class="col-span-12 lg:col-span-6 mx-auto  @if ($errors->any()) mt-6 @endif md:mb-10 pt-10 flex justify-center items-center z-10">
                <form action="" method="POST">
                    @csrf
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
                            <a href="{{ route('auth.google') }}" class="flex justify-center items-center bg-blue-500 hover:bg-blue-600 w-5/6 mx-auto px-3 py-2 rounded-md transition">
                                <x-google-logo />
                                <span class="ml-2 text-white text-md">Lanjutkan dengan Google</span>
                            </a>

                            <a href="{{ route('auth.facebook') }}" class="flex justify-center items-center bg-blue-500 hover:bg-blue-600 w-5/6 mx-auto px-3 py-2 rounded-md transition">
                                <x-google-logo />
                                <span class="ml-2 text-white text-md">Lanjutkan dengan Facebook</span>
                            </a>
                            <p class="text-center">atau</p>
                            <div class="flex flex-col space-y-2 w-5/6 mx-auto">
                                <label for="email">Login Melalu Email</label>
                                <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    type="email" name="email" placeholder="Masukan email anda">
                                @error('email')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </div>
                            <div class="flex flex-col space-y-2 w-5/6 mx-auto">
                                <label for="password">Password</label>
                                <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    type="password" name="password">
                                @error('password')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </div>
                            <a href="{{ route('password.request') }}" class="text-right w-5/6 mx-auto text-gray-400">Lupa password?</a>
                            <button class="w-5/6 bg-green-lightBg mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition">Lanjut</button>
                            <div class="text-center"><span>Belum punya akun?</span> <a class="text-green-lightBg" href="{{ route('register') }}">Yuk Daftar</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>