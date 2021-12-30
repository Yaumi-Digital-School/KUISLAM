<!DOCTYPE html>
<html x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ $titlePage }}</title>

		{{-- styles and fonts  --}}
		<link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"rel="stylesheet"/>
		<link rel='stylesheet' href='https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css'>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}" />

		{{-- script  --}}
		<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
		<script src="{{ asset('/js/init-alpine.js') }}"></script>

		@yield('style')
  	</head>
	<body>
		<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
			{{-- sidebar  --}}
			@include('admin.layouts.sidebar')
			
			{{-- navbar and main content  --}}
			<div class="flex flex-col flex-1 w-full">
				{{-- navbar  --}}
				<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
					@include('admin.layouts.navbar')
				</header>

				{{-- main content  --}}
				<main class="h-full overflow-y-auto">
					<div class="container px-6 mx-auto grid">
						{{$slot}}
					</div>
				</main>
			</div>
		</div>

		<!-- Scripts -->
		<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
        </script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        @yield('script')
  	</body>
</html>
