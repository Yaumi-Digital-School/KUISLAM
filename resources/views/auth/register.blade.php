<x-main-layout titlePage="Laravel">
    {{-- navbar --}}
    <div class="bg-green-nav fixed w-full h-16 top-0 z-20">
        <nav class="text-white flex justify-between items-center px-6 font-bold h-full">
            <a href="{{ route('index') }}" class="bg-gray-400 text-gray-400 text-lg font-bold py-1 w-20">Logo</a>
            <a  class="bg-green-lightBg py-1 px-3" href="{{ route('login') }}">Masuk</a>
        </nav>
    </div>
    {{-- main content  --}}
    <div class="bg-green-lightBg font-poppins mt-6">
        {{-- main container  --}}
        <div class="grid grid-cols-12 pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-screen">
            {{-- picture lets play together  --}}
            <div class="hidden lg:col-span-6 lg:flex justify-center items-center z-10">
                <div>
                    <img style="height: 30rem" class="mx-20"  src="{{ asset('images/login.png') }}" alt="">
                </div>
            </div>
            {{-- form login  --}}
            <div class="col-span-12 lg:col-span-6 mx-auto flex justify-center items-center z-10">
                <form action="" method="POST">
                    <div class="bg-white rounded-lg mx-4 pb-2 max-w-md min-w-min">
                        <div>
                            <img src="{{ asset('images/register_form.png') }}" alt="">
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
                            <p class="text-center">atau</p>
                            <a href="{{ route('register_form') }}" class="flex justify-center items-center bg-green-lightBg hover:bg-green-darkBg w-5/6 mx-auto px-3 py-2 rounded-md transition">
                                <x-mail-logo />
                                <span class="ml-2 text-white text-md">Lanjutkan dengan Google</span>
                            </a>
                            <div class="text-center"><span>Sudah punya akun?</span> <a class="text-green-lightBg" href="{{ route('login') }}">masuk</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>