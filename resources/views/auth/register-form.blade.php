<x-main-layout titlePage="Register Form">
    {{-- navbar --}}
    <div class="bg-green-nav fixed w-full h-16 top-0 z-20">
        <nav class="text-white flex justify-between items-center px-6 font-bold" style="height: 8vh">
            <a href="{{ route('index') }}" class="md:hidden text-4xl flex items-center text-white">
                <i class='bx bx-chevron-left'></i>
            </a>
            <a href="{{ route("index") }}" class="">
                <img src="{{ asset('./images/logo.png') }}" alt="logo">
            </a>
            <a  class="bg-green-lightBg py-1 px-3" href="{{ route('login') }}">Masuk</a>
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
                        <label for="password">Kata Sandi</label>
                        <div class="relative w-full">
                            <span id="show-password" class="absolute right-0  flex items-center pr-2">
                                <span id="eye-icon" class="p-1 mt-0.5 lg:mt-1 focus:outline-none focus:shadow-outline text-gray-400">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5003 4.6875C7.29199 4.6875 2.84408 7.92708 1.04199 12.5C2.84408 17.0729 7.29199 20.3125 12.5003 20.3125C17.7087 20.3125 22.1566 17.0729 23.9587 12.5C22.1566 7.92708 17.7087 4.6875 12.5003 4.6875ZM12.5003 17.7083C9.62533 17.7083 7.29199 15.375 7.29199 12.5C7.29199 9.625 9.62533 7.29167 12.5003 7.29167C15.3753 7.29167 17.7087 9.625 17.7087 12.5C17.7087 15.375 15.3753 17.7083 12.5003 17.7083ZM12.5003 9.375C10.7712 9.375 9.37533 10.7708 9.37533 12.5C9.37533 14.2292 10.7712 15.625 12.5003 15.625C14.2295 15.625 15.6253 14.2292 15.6253 12.5C15.6253 10.7708 14.2295 9.375 12.5003 9.375Z" fill="#7B7B7B"/></svg>
                                </span>
                            </span>
                            <input id="password" type="password" name="password"
                                class="input-password rounded-md h-8 lg:h-10 w-full pr-10 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
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
    <script>
        let type = "password";
        const showPasswordBtn = document.querySelector("#show-password");
        showPasswordBtn.addEventListener('click', function(){
            const inputPassword = document.querySelector(".input-password");
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