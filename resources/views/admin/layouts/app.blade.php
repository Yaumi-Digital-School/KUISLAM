<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ $titlePage }}</title>

		{{-- styles and fonts  --}}
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"rel="stylesheet"/>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}" />

		{{-- script  --}}
		<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
		<script src="{{ asset('/js/init-alpine.js') }}"></script>
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
  	</body>
</html>
