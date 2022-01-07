<x-main-layout titlePage="Login">
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
                        <div class="flex flex-col space-y-4">
                            <div class="flex flex-col space-y-2 text-center font-semibold text-3xl pt-6">
                                <h1>Masuk Akun</h1>
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
                                <div class="relative w-full">
                                    <span id="show-password" class="absolute right-0  flex items-center pr-2">
                                        <span id="eye-icon" class="p-1 mt-0.5 lg:mt-1 focus:outline-none focus:shadow-outline text-gray-400">
                                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5003 4.6875C7.29199 4.6875 2.84408 7.92708 1.04199 12.5C2.84408 17.0729 7.29199 20.3125 12.5003 20.3125C17.7087 20.3125 22.1566 17.0729 23.9587 12.5C22.1566 7.92708 17.7087 4.6875 12.5003 4.6875ZM12.5003 17.7083C9.62533 17.7083 7.29199 15.375 7.29199 12.5C7.29199 9.625 9.62533 7.29167 12.5003 7.29167C15.3753 7.29167 17.7087 9.625 17.7087 12.5C17.7087 15.375 15.3753 17.7083 12.5003 17.7083ZM12.5003 9.375C10.7712 9.375 9.37533 10.7708 9.37533 12.5C9.37533 14.2292 10.7712 15.625 12.5003 15.625C14.2295 15.625 15.6253 14.2292 15.6253 12.5C15.6253 10.7708 14.2295 9.375 12.5003 9.375Z" fill="#7B7B7B"/></svg>
                                        </span>
                                    </span>
                                    <input id="input-password" type="password" name="password"
                                        class="rounded-md h-8 lg:h-10 w-full pr-10 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @error('password')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
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
    <script>
        let type = "password";
        const showPasswordBtn = document.querySelector("#show-password");
        showPasswordBtn.addEventListener('click', function(){
            const inputPassword = document.querySelector("#input-password");
            const eyeIcon = document.querySelector("#eye-icon");
            if(type === "password"){
                type = "text";
                inputPassword.type = type;
                eyeIcon.innerHTML = `<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5001 6.77079C15.3751 6.77079 17.7084 9.10413 17.7084 11.9791C17.7084 12.5104 17.6042 13.0208 17.4584 13.5L20.6459 16.6875C22.0938 15.4062 23.2397 13.802 23.9584 11.9687C22.1563 7.40621 17.7084 4.16663 12.5001 4.16663C11.1772 4.16663 9.90633 4.37496 8.70841 4.76038L10.9688 7.02079C11.4584 6.87496 11.9688 6.77079 12.5001 6.77079ZM2.823 3.29163C2.41675 3.69788 2.41675 4.35413 2.823 4.76038L4.87508 6.81246C3.18758 8.15621 1.84383 9.92704 1.04175 11.9791C2.84383 16.552 7.29175 19.7916 12.5001 19.7916C14.0834 19.7916 15.5938 19.4791 16.9897 18.9375L19.823 21.7708C20.2292 22.177 20.8855 22.177 21.2917 21.7708C21.698 21.3645 21.698 20.7083 21.2917 20.302L4.30216 3.29163C3.89591 2.88538 3.22925 2.88538 2.823 3.29163ZM12.5001 17.1875C9.62508 17.1875 7.29175 14.8541 7.29175 11.9791C7.29175 11.177 7.47925 10.4166 7.80216 9.74996L9.43758 11.3854C9.40633 11.5729 9.37508 11.7708 9.37508 11.9791C9.37508 13.7083 10.7709 15.1041 12.5001 15.1041C12.7084 15.1041 12.8959 15.0729 13.0938 15.0312L14.7292 16.6666C14.0522 17 13.3022 17.1875 12.5001 17.1875ZM15.5938 11.6354C15.4376 10.177 14.2917 9.04163 12.8438 8.88538L15.5938 11.6354Z" fill="#7B7B7B"/>
                                    </svg>`;
            }else {
                type = "password";
                inputPassword.type = type;
                eyeIcon.innerHTML = `<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5003 4.6875C7.29199 4.6875 2.84408 7.92708 1.04199 12.5C2.84408 17.0729 7.29199 20.3125 12.5003 20.3125C17.7087 20.3125 22.1566 17.0729 23.9587 12.5C22.1566 7.92708 17.7087 4.6875 12.5003 4.6875ZM12.5003 17.7083C9.62533 17.7083 7.29199 15.375 7.29199 12.5C7.29199 9.625 9.62533 7.29167 12.5003 7.29167C15.3753 7.29167 17.7087 9.625 17.7087 12.5C17.7087 15.375 15.3753 17.7083 12.5003 17.7083ZM12.5003 9.375C10.7712 9.375 9.37533 10.7708 9.37533 12.5C9.37533 14.2292 10.7712 15.625 12.5003 15.625C14.2295 15.625 15.6253 14.2292 15.6253 12.5C15.6253 10.7708 14.2295 9.375 12.5003 9.375Z" fill="#7B7B7B"/>
                                    </svg>`;
            }
        });
    </script>
</x-main-layout>