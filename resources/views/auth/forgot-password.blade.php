<x-main-layout titlePage="Login">
    <div class="font-poppins mt-10">
        {{-- main container  --}}
        <div class="pt-3 lg:pt-0 max-w-screen-2xl mx-auto h-screen flex justify-center items-center">
            {{-- form login  --}}
            <div class=" flex justify-center items-center z-10">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="bg-white rounded-lg mx-4 mb-8 pb-2 max-w-md min-w-min relative z-10 shadow-profile">
                        <img class="block rounded-t-lg" src="{{ asset('./img/popup_auth.png') }}" alt="">
                        <div class="flex flex-col">
                            <div class="flex flex-col space-y-2 text-center font-semibold text-3xl pt-6">
                                <h1>Lupa Password</h1>
                            </div>
                            <div class="mb-4 flex flex-col space-y-2 w-5/6 mx-auto">
                                <label for="email">Email</label>
                                <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    type="email" name="email" placeholder="Masukan email anda">
                                @error('email')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </div>
                            <button type="submit" class="mb-4 w-5/6 bg-green-lightBg mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition">Email Password Reset Link</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('script')
        {{-- redirect with message  --}}
        <script>
            const message = "{{ session('status') }}";
            if(message){
                Swal.fire({
                    title: message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
            }
        </script>
    @endsection
</x-main-layout>


