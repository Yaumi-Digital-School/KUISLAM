{{-- navbar desktop--}}
<div class="bg-green-nav fixed w-full h-16 top-0 z-20 font-poppins border-b-2 border-gray-nav md:border-none">
    <nav class="text-white flex justify-center md:justify-between items-center px-8 h-full" >
        <div class="flex items-center space-x-10">
            <a href="{{ route("index") }}" class="block">
                <img src="{{ asset('./images/logo.png') }}" alt="logo">
            </a>
            <div class="hidden md:flex space-x-8 font-medium">
                <a class="py-0.5" href="{{ route("index") }}" @if (request()->routeIs("index")) style="border-bottom: 3px solid white" @endif>Beranda</a>
                <a class="py-0.5 " href="{{ route("discover") }}" @if (request()->routeIs("discover")) style="border-bottom: 3px solid white" @endif>Eksplor</a>
                <a class="py-0.5 cursor-pointer"
                    @auth
                        href="{{ route("activity") }}"         
                    @endauth 
                    @guest
                        onclick="triggerAuthPopup()"
                    @endguest   
                    @if (request()->routeIs("activity") || request()->routeIs("activity.made")) style="border-bottom: 3px solid white; " @endif>Aktivitas</a>
            </div>
        </div>
        <div class="hidden md:flex justify-end w-4/12 space-x-8 items-center">
            @guest
                <a class="bg-green-lightBg py-1 px-3 hover:bg-green-darkBg transition" href="{{ route('login') }}">Masuk</a>
            @endguest
            @auth
                @php
                    $file = App\Models\User::authUserImageIsFile(Auth::user()->avatar);
                @endphp
                @if(Auth::user()->avatar)
                    @if($file === true)
                        <div class="flex items-center h-12 w-12 ">
                            <img class="rounded-full" src="{{ asset('storage/user/avatar/'. Auth::user()->avatar) }}" alt="burger icon">
                        </div>
                    @else
                        <div class="flex items-center h-12 w-12 ">
                            <img class="rounded-full" src="{{ Auth::user()->avatar }}" alt="burger icon">
                        </div>
                    @endif
                @else
                    <div class="flex items-center h-12 w-12 ">
                        <img class="rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="burger icon">
                    </div>
                @endif
            @endauth
        </div>
    </nav>
</div>

{{-- navbar bottom  --}}
<div class="bg-white md:hidden fixed w-full h-14 bottom-0 z-20 font-poppins border-t-2 border-gray-nav">
    <nav class="text-white flex justify-around items-center  h-full">
        <a href="{{ route("index") }}" class="flex flex-col space-y-1 justify-center items-center">
            <svg class="w-5 h-5" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.99998 16V11H12V16C12 16.55 12.45 17 13 17H16C16.55 17 17 16.55 17 16V8.99997H18.7C19.16 8.99997 19.38 8.42997 19.03 8.12997L10.67 0.599971C10.29 0.259971 9.70998 0.259971 9.32998 0.599971L0.969976 8.12997C0.629976 8.42997 0.839976 8.99997 1.29998 8.99997H2.99998V16C2.99998 16.55 3.44998 17 3.99998 17H6.99998C7.54998 17 7.99998 16.55 7.99998 16Z" 
                    fill="@if (request()->routeIs("index")) #8ACC3B @else #C4C4C4 @endif"/>
            </svg>
            <span class="text-sm font-semibold @if (request()->routeIs("index")) text-green-lightBg @else text-gray-nav @endif">Beranda</span>
        </a>
        <a href="{{ route("discover") }}" class="flex flex-col space-y-1 justify-center items-center">
            <svg class="w-5 h-5"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 10.9C11.39 10.9 10.9 11.39 10.9 12C10.9 12.61 11.39 13.1 12 13.1C12.61 13.1 13.1 12.61 13.1 12C13.1 11.39 12.61 10.9 12 10.9ZM12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM14.19 14.19L6 18L9.81 9.81L18 6L14.19 14.19Z" 
                    fill="@if (request()->routeIs("discover")) #8ACC3B @else #C4C4C4 @endif"/>
                </svg>
            <span class="text-sm font-semibold @if (request()->routeIs("discover")) text-green-lightBg @else text-gray-nav @endif">Eksplor</span>
        </a>
        <a  @auth
                href="{{ route("activity") }}"         
            @endauth 
            @guest
                onclick="triggerAuthPopup()"
            @endguest   
            class="flex flex-col space-y-1 justify-center items-center">
            <svg class="w-5 h-5" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.26 1.00001C7.17003 0.860011 3.00003 4.95001 3.00003 10H1.21003C0.760031 10 0.540031 10.54 0.860031 10.85L3.65003 13.65C3.85003 13.85 4.16003 13.85 4.36003 13.65L7.15003 10.85C7.46003 10.54 7.24003 10 6.79003 10H5.00003C5.00003 6.10001 8.18003 2.95001 12.1 3.00001C15.82 3.05001 18.95 6.18001 19 9.90001C19.05 13.81 15.9 17 12 17C10.39 17 8.90003 16.45 7.72003 15.52C7.32003 15.21 6.76003 15.24 6.40003 15.6C5.98003 16.02 6.01003 16.73 6.48003 17.09C8.00003 18.29 9.91003 19 12 19C17.05 19 21.14 14.83 21 9.74001C20.87 5.05001 16.95 1.13001 12.26 1.00001ZM11.75 6.00001C11.34 6.00001 11 6.34001 11 6.75001V10.43C11 10.78 11.19 11.11 11.49 11.29L14.61 13.14C14.97 13.35 15.43 13.23 15.64 12.88C15.85 12.52 15.73 12.06 15.38 11.85L12.5 10.14V6.74001C12.5 6.34001 12.16 6.00001 11.75 6.00001Z" 
                    fill="@if (request()->routeIs("activity")) #8ACC3B @else #C4C4C4 @endif"/>
            </svg>                    
            <span class="text-sm font-semibold @if (request()->routeIs("activity") || request()->routeIs("activity.made")) text-green-lightBg @else text-gray-nav @endif">Aktivitas</span>
        </a>
        <a @auth
                href="{{  route('profile.detail-account') }}"         
            @endauth 
            @guest
                onclick="triggerAuthPopup()"
            @endguest class="flex flex-col space-y-1 justify-center items-center">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 5C13.66 5 15 6.34 15 8C15 9.66 13.66 11 12 11C10.34 11 9 9.66 9 8C9 6.34 10.34 5 12 5ZM12 19.2C9.5 19.2 7.29 17.92 6 15.98C6.03 13.99 10 12.9 12 12.9C13.99 12.9 17.97 13.99 18 15.98C16.71 17.92 14.5 19.2 12 19.2Z" 
                    fill="@if (request()->routeIs("profile.detail-account")) #8ACC3B @else #C4C4C4 @endif"/>
            </svg>
            <span class="text-sm font-semibold @if (request()->routeIs("profile.detail-account")) text-green-lightBg @else text-gray-nav @endif">Akun</span>
        </a>
    </nav>
</div>