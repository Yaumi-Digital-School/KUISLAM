<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
	<div class="py-4 text-gray-500 dark:text-gray-400">
		{{-- Logo --}}
		<a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
			Kuislam
		</a>
		{{-- links sidebar  --}}
		<ul class="mt-6">
			{{-- dashboard  --}}
			<li class="relative px-6 py-3">
				{{-- check if its active link  --}}
				@if ((request()->routeIs("test.admin.dashboard")))
					@include('admin.components.active-link')
				@endif
				{{-- actual link  --}}
				<a class="inline-flex items-center w-full text-sm font-semibold 
					@if ((request()->routeIs("test.admin.dashboard")))
						text-gray-800
					@endif 
					transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
					href="{{ route('test.admin.dashboard') }}">
					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
					</svg>
					<span class="ml-4">Dashboard</span>
				</a>
			</li>
			{{-- topics  --}}
			<li class="relative px-6 py-3">
				{{-- check if its active link  --}}
				@if ((request()->routeIs("topics.index")))
					@include('admin.components.active-link')
				@endif
				{{-- actual link  --}}
				<a class="inline-flex items-center w-full text-sm font-semibold 
					@if ((request()->routeIs("topics.index")))
						text-gray-800
					@endif 
					transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
					href="{{ route('topics.index') }}">
					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor" >
						<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
					</svg>
					<span class="ml-4">Topics</span>
				</a>
			</li>
			{{-- quiz  --}}
			<li class="relative px-6 py-3">
				{{-- check if its active link  --}}
				@if ((request()->routeIs("quizzes.index")))
					@include('admin.components.active-link')
				@endif
				<a class="inline-flex items-center w-full text-sm font-semibold 
					@if ((request()->routeIs("quizzes.index")))
						text-gray-800
					@endif
					transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
					href="{{ route('quizzes.index') }}" >
					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
					</svg>
					<span class="ml-4">Quiz</span>
				</a>
			</li>
			{{-- question  --}}
			<li class="relative px-6 py-3">
				<a
				class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
				href="cards.html"
				>
				<svg
					class="w-5 h-5"
					aria-hidden="true"
					fill="none"
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path
					d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
					></path>
				</svg>
				<span class="ml-4">Questions</span>
				</a>
			</li>
			{{-- users  --}}
			<li class="relative px-6 py-3">
				<a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
					href="charts.html">
					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
						<path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
					</svg>
					<span class="ml-4">Users</span>
				</a>
			</li>
		</ul>
		{{-- button create account  --}}
		<div class="px-6 my-6">
			<button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150  border border-transparent rounded-lg bg-green-nav hover:bg-green-darkBg focus:outline-none focus:shadow-outline-green">
				Create account <span class="ml-2" aria-hidden="true">+</span>
			</button>
		</div>
	</div>
</aside>

<!-- Backdrop for darkening back screen-->
<div x-show="isSideMenuOpen"
	x-transition:enter="transition ease-in-out duration-150"
	x-transition:enter-start="opacity-0"
	x-transition:enter-end="opacity-100"
	x-transition:leave="transition ease-in-out duration-150"
	x-transition:leave-start="opacity-100"
	x-transition:leave-end="opacity-0"
	class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
</div>

<!-- Mobile sidebar -->
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
	x-show="isSideMenuOpen"
	x-transition:enter="transition ease-in-out duration-150"
	x-transition:enter-start="opacity-0 transform -translate-x-20"
	x-transition:enter-end="opacity-100"
	x-transition:leave="transition ease-in-out duration-150"
	x-transition:leave-start="opacity-100"
	x-transition:leave-end="opacity-0 transform -translate-x-20"
	@click.away="closeSideMenu"
	@keydown.escape="closeSideMenu">
	<div class="py-4 text-gray-500 dark:text-gray-400">
		{{-- Logo --}}
		<a class="ml-6 text-lg font-bold dark:text-gray-200" href="#">
			Kuislam
		</a>
		{{-- left sidebar  --}}
		<ul class="mt-6">
			{{-- dashboard  --}}
			<li class="relative px-6 py-3">
				{{-- check if its active link  --}}
				@if ((request()->routeIs("test.admin.dashboard")))
					@include('admin.components.active-link')
				@endif
				{{-- actual links  --}}
				<a class="inline-flex items-center w-full text-sm font-semibold 
					@if ((request()->routeIs("test.admin.dashboard")))
						text-gray-800
					@endif
					transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" 
					href="{{ route('test.admin.dashboard') }}">
					<svg
						class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
						></path>
					</svg>
					<span class="ml-4">Dashboard</span>
				</a>
			</li>
			{{-- topics  --}}
			<li class="relative px-6 py-3">
				{{-- check if its active link  --}}
				@if ((request()->routeIs("topics.index")))
					@include('admin.components.active-link')
				@endif
				<a class="inline-flex items-center w-full text-sm font-semibold
					@if ((request()->routeIs("topics.index")))
						text-gray-800
					@endif 
					transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
					href="{{ route('topics.index') }}">
					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
					</svg>
					<span class="ml-4">Topics</span>
				</a>
			</li>
			{{-- quiz  --}}
			<li class="relative px-6 py-3">
				{{-- check if its active link  --}}
				@if ((request()->routeIs("quizzes.index")))
					@include('admin.components.active-link')
				@endif
				<a class="inline-flex items-center w-full text-sm font-semibold 
					@if ((request()->routeIs("quizzes.index")))
						text-gray-800
					@endif
					transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
					href="{{ route('quizzes.index') }}">
					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
					</svg>
					<span class="ml-4">Quiz</span>
				</a>
			</li>
			{{-- questions  --}}
			<li class="relative px-6 py-3">
				<a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
					href="cards.html">
					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
					</svg>
					<span class="ml-4">Questions</span>
				</a>
			</li>
			{{-- users  --}}
			<li class="relative px-6 py-3">
				<a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
					href="charts.html">

					<svg class="w-5 h-5"
						aria-hidden="true"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor">
						<path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
						<path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
					</svg>
					<span class="ml-4">Users</span>
				</a>
			</li>
		</ul>
		{{-- button add account  --}}
		<div class="px-6 my-6">
			<button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg bg-green-nav hover:bg-green-darkBg focus:outline-none focus:shadow-outline-green">
				Create account <span class="ml-2" aria-hidden="true">+</span>
			</button>
		</div>
	</div>
</aside>