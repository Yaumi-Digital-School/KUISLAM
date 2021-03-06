<x-main-layout titlePage="Register">
    {{-- navbar --}}
    <div class="bg-green-nav fixed w-full h-16 top-0 z-20">
        <nav class="text-white flex w-2/3 md:w-full justify-between items-center px-6 font-bold h-full">
            <a href="{{ route('index') }}" class="md:hidden text-4xl flex items-center text-white">
                <i class='bx bx-chevron-left'></i>
            </a>
            <a href="{{ route("index") }}" class="">
                <img src="{{ asset('./images/logo.png') }}" alt="logo">
            </a>
            <a  class="hidden md:block bg-green-lightBg py-1 px-3" href="{{ route('login') }}">Masuk</a>
        </nav>
    </div>
    {{-- main content  --}}
    <div class="bg-green-lightBg font-poppins mt-6">
        {{-- main container  --}}
        <div class="pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-screen flex justify-center items-center">
            {{-- form login  --}}
            <div class="mx-auto flex justify-center items-center z-10">
                <div class="bg-white rounded-lg mx-4 pb-2 max-w-md min-w-min shadow-profile">
                    <img class="block rounded-t-lg" src="{{ asset('./img/popup_auth.png') }}" alt="">
                    <div class="flex flex-col space-y-5">
                        <div class="flex flex-col space-y-2 text-center font-semibold text-3xl pt-6">
                            <h1>Buat Akun</h1>
                        </div>
                        <a href="{{ route('auth.google') }}" class="flex font-bold justify-center items-center bg-blue-500 hover:bg-blue-600 w-5/6 mx-auto px-3 py-2 rounded-md transition">
                            <x-google-logo />
                            <span class="ml-2 text-white text-md">Masuk dengan Google</span>
                        </a>
                        {{-- <a href="{{ route('auth.facebook') }}" class="flex font-bold justify-center items-center bg-blue-facebook hover:bg-blue-facebookDark w-5/6 mx-auto px-3 py-2 rounded-md transition">
                            <x-facebook-logo />
                            <span class="ml-2 text-white text-md">Masuk dengan Facebook</span>
                        </a> --}}
                        <p class="text-center">atau</p>
                        <button class="w-5/6 bg-green-lightBg mx-auto text-white rounded-md py-2 hover:bg-green-darkBg transition flex items-center space-x-1">
                            <a href="{{ route('register.form') }}" class="flex items-center text-center  mx-auto"><svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 0H2C0.9 0 0.00999999 0.9 0.00999999 2L0 14C0 15.1 0.9 16 2 16H18C19.1 16 20 15.1 20 14V2C20 0.9 19.1 0 18 0ZM17 14H3C2.45 14 2 13.55 2 13V4L8.94 8.34C9.59 8.75 10.41 8.75 11.06 8.34L18 4V13C18 13.55 17.55 14 17 14ZM10 7L2 2H18L10 7Z" fill="white"/></svg><span class="ml-2">Lanjutkan dengan email</span> 
                            </a>
                        </button>
                        <div class="text-center"><span>Sudah punya akun?</span> <a class="text-green-lightBg" href="{{ route('login') }}">masuk</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>