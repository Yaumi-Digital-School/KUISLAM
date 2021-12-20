<x-main-layout titlePage="Laravel">
    {{-- additional style  --}}
    @section('style')
        <style>
            .swiper-button-prev:after,
            .swiper-rtl .swiper-button-next:after {
                content: '';
            }
            .swiper-button-next:after,
            .swiper-rtl .swiper-button-next:after {
                content: '';
            }
            .swiper-button-next{
                position: absolute;
                right: -4%;
            }
            .swiper-button-prev{
                position: absolute;
                left: -4%;
            }
        </style>
    @endsection
    
    {{-- navbar  --}}
    @include('layouts.navigation', ['themePage' => 'white'])
    {{-- main content  --}}
    <div class="bg-green-lightBg font-poppins mt-6">
        {{-- main container  --}}
        <div class="flex flex-col justify-center items-center pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-screen ">
            <form action="{{ route('profile.update-account') }}" method="POST" class="z-10">
                @csrf
                @method('PUT')
                <div class="bg-white flex flex-col space-y-3 @if ($errors->any()) mt-24 mb-10 md:mt-20 md:mb-10 @endif py-4 px-4 max-w-lg rounded-lg mx-4">   
                    <h1 class="text-center text-4xl font-bold" style="color: #2A610B">Akun</h1>
                    <div>
                        <label for="name">Nama</label>
                        <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            id="name" type="text" name="name" placeholder="" value="{{ Auth::user()->name }}">
                        @error('name')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror 
                    </div>
                    <div>
                        <label for="username">Username</label>
                        <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            id="username" type="text" name="username" placeholder="" value="{{ Auth::user()->username }}">
                        @error('username')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror 
                    </div>
                    <button class="w-full bg-green-nav mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition" type="submit">Save Changes</button>
                </div>
            </form>
            <br>
            <br>
            @if(Auth::user()->google_id == NULL|| !Auth::user()->facebook_id == NULL)
                <form action="{{ route('profile.change-password') }}" method="POST" class="z-10">
                    @csrf
                    @method('PUT')
                    <div class="bg-white flex flex-col space-y-3 @if ($errors->any()) mt-24 mb-10 md:mt-20 md:mb-10 @endif py-4 px-4 max-w-lg rounded-lg mx-4">   
                        <h1 class="text-center text-4xl font-bold" style="color: #2A610B">Kata Sandi</h1>
                        <div>
                            <label for="old_password">Old Password</label>
                            <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                id="old_password" type="password" name="old_password" placeholder="Old Password" value="{{ old('old_password') }}">
                            @error('old_password')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror 
                        </div>
                        <div>
                            <label for="password">New Password</label>
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
                        <button class="w-full bg-green-nav mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition" type="submit">Change Password</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-main-layout>