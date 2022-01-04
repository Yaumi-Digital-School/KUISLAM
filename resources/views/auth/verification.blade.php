<x-main-layout titlePage="Laravel" themePage="white">
    {{-- navbar --}}
    @include('layouts.navigation', ['themePage' => 'white'])

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif
    {{-- main content --}}
    <div class="sm:mx-auto px-16 sm:px-0 text-center font-poppins sm:mt-60 mt-40">
        <div class="w-32 h-28 mx-auto mb-4 z-10 relative">
            <img src="{{asset('images/email.svg')}}" alt="email verif">    
        </div>
        {{-- User name --}}
        <h1 class="text-3xl font-bold mb-8 z-10 relative">Hi, {{ Auth::user()->name }}</h1>
        <p class="text-xl mb-8 z-10 relative">Lakukan verifikasi akun untuk masuk ke akun kamu!</p>
        <p class="text-xl mb-20 z-10 relative">Klik untuk mengirimkan link verifikasi akun ke alamat<br><strong>{{ Auth::user()->email }}</strong></p>
        {{-- button --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="bg-green-lightBg sm:w-40 w-28 h-12 sm:h-20 text-center text-white sm:text-2xl text-md rounded-md font-bold z-10 relative">{{ __('Kirim!') }}</button> 
            </div>
        </form>
    </div>
</x-main>