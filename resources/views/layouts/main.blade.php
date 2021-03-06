<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/x-icon" href="{{ asset('./images/favicon.ico') }}">

        <title>Kuislam | {{ $titlePage }}</title>

        <!-- Fonts --> 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('style')
    </head>
    <body class="@if ($themePage == "white") bg-white @else bg-green-lightBg  @endif relative min-h-screen overflow-y-scroll overflow-x-hidden">
        
        {{ $slot }}
        
        {{-- ball stuff  --}}
        <div class=" @if ($themePage == "white") bg-gray-darkBg @else bg-green-darkBg @endif rounded-full fixed -left-48 -top-48" style="height: 35rem; width: 35rem"></div>
        <div class="@if ($themePage == "white") bg-gray-darkBg @else bg-green-darkBg @endif rounded-full fixed -right-40 -bottom-20 flex justify-center items-center" style="height: 35rem; width: 35rem">
            <div class="@if ($themePage == "white") bg-white @else bg-green-lightBg  @endif rounded-full" style="height: 28rem; width: 28rem"></div>
        </div>

        <!-- Scripts -->
        {{-- swal popup auth  --}}
        <script>
            function triggerAuthPopup(){
                // defining custom class 
                const btnClass = 'w-full md:text-lg font-poppins py-1 px-2 rounded font-semibold shadow-authPopup';

                const authPopupSwal = Swal.mixin({
                    customClass: {
                        title: 'font-semibold',
                        confirmButton: `${btnClass} bg-green-nav mb-4 text-white hover:bg-green-darkBg transition focus:outline-none`,
                        cancelButton: `${btnClass} bg-white text-green-nav hover:bg-gray-200 transition`,
                    },
                    buttonsStyling: false
                });
                authPopupSwal.fire({
                        title: 'Hanya butuh beberapa detik!',
                        text: 'Daftar atau masuk ke akun kamu untuk lanjut bermain.',
                        imageUrl: "{{ asset('./img/popup_auth.png') }}",
                        imageWidth: 480,
                        imageAlt: 'Custom image',
                        showCancelButton: true,
                        focusConfirm: false,
                        confirmButtonText: "<a href='{{ route('register') }}'>Daftar Sekarang</a>",
                        cancelButtonText: "<a href='{{ route('login') }}'>Masuk Akun</a>",
                    });
            }
        </script>
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
        </script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        @yield('script')
    </body>
</html>
