<x-main-layout titlePage="Laravel">
    {{-- navbar --}}
    <div class="bg-green-nav fixed w-full h-16 top-0 z-20">
        <nav class="text-white flex justify-between items-center px-6 font-bold" style="height: 8vh">
            <span class="text-lg">Logo</span>
            <a class="text-lg" href="{{ route('login') }}">Login</a>
        </nav>
    </div>
    {{-- main content  --}}
    <div class="bg-green-lightBg font-poppins mt-6">
        {{-- main container  --}}
        <div class="flex flex-col justify-center items-center pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-screen ">
            <form action="{{ route('register.post') }}" method="POST" class="z-10">
                @csrf
                {{-- @if ($errors->any())
                    {{ dd($errors->any()) }}
                @endif --}}
                <div class="bg-white flex flex-col space-y-3 @if ($errors->any()) mt-24 mb-10 md:mt-20 md:mb-10 @endif py-4 px-4 max-w-lg rounded-lg mx-4">   
                    <h1 class="text-center text-4xl font-bold" style="color: #2A610B">Detail Akun</h1>
                    <div>
                        <label for="name">Nama</label>
                        <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            id="name" type="text" name="name" placeholder="Michael Alexander" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror 
                    </div>
                    <div>
                        <label for="username">Username</label>
                        <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            id="username" type="text" name="username" placeholder="Alex 123" value="{{ old('username') }}">
                        @error('username')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror 
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            id="email" type="email" name="email" placeholder="alex@gmail.com" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror 
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            id="password" type="password" name="password" placeholder="">
                    </div>
                    <div>
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            id="password_confirmation" type="password" name="password_confirmation" placeholder="">
                        @error('password')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror 
                    </div>
                    <button class="w-full bg-green-nav mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition" type="submit">Buat akun</button>
                    <div class="text-sm w-5/6 text-center mx-auto">Dengan mendaftar, kamu setuju dengan <span class="text-green-nav">Ketentuan Layanan</span> dan <span class="text-green-nav">Kebijakan Privasi</span></div>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>