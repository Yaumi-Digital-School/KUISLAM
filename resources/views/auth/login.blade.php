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
        <div class="pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-screen">
            {{-- form login  --}}
            <div class="@if ($errors->any()) mt-6 @endif md:mb-10 pt-10 flex justify-center items-center z-10">
                <form action="" method="POST">
                    @csrf
                    <div class="bg-white rounded-lg mx-4 mb-8 pb-2 max-w-md min-w-min relative z-10 shadow-profile">
                        <img class="block rounded-t-lg" src="{{ asset('./img/popup_auth.png') }}" alt="">
                        <div class="flex flex-col space-y-5">
                            <div class="flex flex-col space-y-2 text-center font-semibold text-3xl pt-6">
                                <h1>Masuk Akun</h1>
                            </div>
                            <a href="{{ route('auth.google') }}" class="flex font-bold justify-center items-center bg-blue-500 hover:bg-blue-600 w-5/6 mx-auto px-3 py-2 rounded-md transition">
                                <x-google-logo />
                                <span class="ml-2 text-white text-md">Masuk dengan Google</span>
                            </a>
                            <a href="{{ route('auth.facebook') }}" class="flex font-bold justify-center items-center bg-blue-facebook hover:bg-blue-facebookDark w-5/6 mx-auto px-3 py-2 rounded-md transition">
                                <x-facebook-logo />
                                <span class="ml-2 text-white text-md">Masuk dengan Facebook</span>
                            </a>
                            <p class="text-center">atau</p>
                            <div class="flex flex-col space-y-2 w-5/6 mx-auto">
                                <label for="email">Email</label>
                                <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    type="email" name="email" placeholder="Masukan email anda">
                                @error('email')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </div>
                            <div class="flex flex-col space-y-2 w-5/6 mx-auto">
                                <label for="password">Kata Sandi</label>
                                <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    type="password" name="password">
                                @error('password')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </div>
                            <a href="{{ route('password.request') }}" class="text-right w-5/6 mx-auto text-gray-400">Lupa Kata Sandi?</a>
                            <button class="w-5/6 bg-green-lightBg mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition">Lanjut</button>
                            <div class="text-center"><span>Belum punya akun?</span> <a class="text-green-lightBg" href="{{ route('register') }}">Daftar Sekarang</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>