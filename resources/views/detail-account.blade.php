<x-main-layout titlePage="Laravel" themePage="white">
    {{-- additional style  --}}
    @section('style')
    @endsection
    
    {{-- navbar  --}}
    @include('layouts.navigation', ['themePage' => 'white'])

    {{-- main content  --}}
    <div class="font-poppins mt-20 md:mt-28">
        {{-- main container  --}}
        <div class="max-w-screen-md mx-auto h-screen grid grid-cols-12 gap-6">
            {{-- profile information desktop  --}}
            <div class="hidden md:block md:col-span-4 relative z-10">
                <div class="bg-white shadow-custom1 flex flex-col justify-between items-center px-4 py-6 space-y-4 rounded-xl">
                    @if(Auth::user()->avatar)
                        @if($file === true)
                            <img class="block w-24 rounded-full border-4 border-green-nav" src="{{ asset('storage/user/avatar/'. Auth::user()->avatar) }}" alt="">
                        @else
                            <img class="block w-24 rounded-full border-4 border-green-nav" src="{{ Auth::user()->avatar }}" alt="">
                        @endif
                    @else
                        <img class="block w-24 rounded-full border-4 border-green-nav" src="{{ asset('/images/default_profpic.png') }}" alt="">
                    @endif
                    <div class="text-center space-y-1 font-semibold">
                        <p class="text-lg">{{ Auth::user()->name }}</p>
                        <p class="text-gray-link">{{ Auth::user()->username }}</p>
                    </div>
                </div>
            </div>
            {{-- form edit  --}}
            <div class="col-span-12 md:col-span-8 relative z-10 mb-10">
                <div class="bg-white shadow-custom1 rounded-xl pb-2">
                    {{-- form nama, username, email  --}}
                    <form id="form-name-username" action="{{ route('profile.update-account') }}" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-4 py-4 px-6">
                        @csrf
                        @method('PUT')
                        {{-- title  --}}
                        <div class="flex items-center space-x-4">
                            <img class="block w-5" src="{{ asset('./images/detail_acc_pencil.png') }}" alt="">
                            <h1 class="text-center text-lg md:text-xl font-bold">Akun</h1>
                        </div>
                        {{-- fields  --}}
                        <div class="space-y-4">
                            {{-- image  --}}
                            <div class="flex items-center space-x-4">
                                @if(Auth::user()->avatar)
                                    @if($file === true)
                                        <img id="avatarInput" class="block w-20 rounded-full" src="{{ asset('storage/user/avatar/'. Auth::user()->avatar) }}" alt="">
                                    @else
                                        <img id="avatarInput" class="block w-20 rounded-full" src="{{ Auth::user()->avatar }}" alt="">
                                    @endif
                                @else
                                    <img id="avatarInput" class="block w-20 rounded-full" src="{{ asset('/images/default_profpic.png') }}" alt="">
                                @endif
                                <div class="flex flex-col space-y-2">
                                    <span class="font-semibold">{{ Auth::user()->username }}</span>
                                    <div>
                                        <label class="bg-gray-inputFileButton text-sm text-gray-inputFileButtonTxt rounded p-2 cursor-pointer" >
                                            Ganti gambar
                                            <input accept=".png, .jpg, .jpeg" type="file" style="display: none;" name="avatar" id="image"/>
                                        </label>
                                        @error('avatar')
                                            <span class="ml-3 text-red-400">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- email  --}}
                            <div>
                                <label for="">Email</label>
                                <input disabled 
                                    class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm 
                                    bg-gray-inputDisabledBg text-gray-inputDisabledTxt" 
                                    id="" type="text" name="" placeholder="" value="{{ Auth::user()->email }}">
                            </div>
                            {{-- name  --}}
                            <div>
                                <label for="name">Nama</label>
                                <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    id="name" type="text" name="name" placeholder="" value="{{ Auth::user()->name }}">
                                @error('name')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </div>
                            {{-- username  --}}
                            <div>
                                <label for="username">Username</label>
                                <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    id="username" type="text" name="username" placeholder="" value="{{ Auth::user()->username }}">
                                @error('username')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror 
                            </div>
                            <button class="w-full bg-green-nav mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition" type="submit">Simpan Perubahan</button>
                        </div>
                    </form>
                    {{-- form password  --}}
                    @if(!Auth::user()->google_id || !Auth::user()->facebook_id)
                        <form action="{{ route('profile.change-password') }}" method="POST" class="flex flex-col space-y-4 py-4 px-6">
                            @csrf
                            @method('PUT')
                            {{-- title  --}}
                            <div class="flex items-center space-x-4">
                                <img class="block w-5" src="{{ asset('./images/detail_acc_lock.png') }}" alt="">
                                <h1 class="text-center text-lg md:text-xl font-bold" >Kata Sandi</h1>
                            </div>
                            {{-- fields  --}}
                            <div class="space-y-4">
                                {{-- old password  --}}
                                <div class="">
                                    <label for="old_password">Old Password</label>
                                    <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                        id="old_password" type="password" name="old_password" placeholder="Old Password" value="{{ old('old_password') }}">
                                    @error('old_password')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror 
                                </div>
                                {{-- new password  --}}
                                <div>
                                    <label for="password">New Password</label>
                                    <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                        id="password" type="password" name="password" placeholder="">
                                </div>
                                {{-- new password confirmation  --}}
                                <div>
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input class="rounded-md h-8 lg:h-10 w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                        id="password_confirmation" type="password" name="password_confirmation" placeholder="">
                                    @error('password')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror 
                                </div>
                                <button class="w-full bg-green-nav mx-auto text-white rounded-md py-1 hover:bg-green-darkBg transition" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    @endif
                    {{-- tentang kuislam  --}}
                    <div class="text-center px-6 font-semibold">
                        <p class="text-sm text-gray-nav">Tentang</p>
                        <p class="text-gray-nav">Kuislam V1.0</p>
                    </div>
                    {{-- button logout  --}}
                    <div class="mb-20 md:mb-0">
                        <button id="logout-btn" class="border-2 text-red-redMain hover:bg-red-redMain hover:text-white transition border-red-redMain block w-2/3 mx-auto py-1 text-center my-4 rounded-md font-bold">
                            Keluar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @section('script')
        {{-- logout swal  --}}
        <script>
            // defining custom class 
            const btnClass = 'w-20 md:w-28 text-xl md:text-2xl font-poppins py-1 rounded font-semibold';

            // trigger swal 
            $("#logout-btn").click(function(){
                // use custom class 
                const logoutSwal = Swal.mixin({
                    customClass: {
                        // title: 'font-poppins',
                        confirmButton: `${btnClass} bg-green-nav text-white mr-4 hover:bg-green-darkBg transition`,
                        cancelButton: `${btnClass} border-2 border-green-nav text-green-nav hover:bg-gray-200 transition`,
                    },
                    buttonsStyling: false
                });
                // fire the swal 
                logoutSwal.fire({
                    title: 'Apa kamu yakin ingin keluar?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('logout') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function(response){
                                    let urlRedirect = "{{ route('index') }}";
                                    window.location.href = urlRedirect;
                                }
                            });
                        }
                });
            });
        </script>
        {{-- notification success edit form  --}}
        <script>
            let message, icon;
            if("{{ session('success') }}"){
                message = "{{ session('success') }}";
                icon = "success";
            }else if("{{ session('failed') }}"){
                message = "{{ session('failed') }}";
                icon = "error";
            }
            if("{{ session('success') }}" || "{{ session('failed') }}"){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    icon: icon,
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                })
                Toast.fire({
                    title: message,
                })
            }
        </script>
        {{-- change image when user select input  --}}
        <script>
            $("#image").change(function(){
                const file = this.files[0];
                // console.log(file);
                if (file){
                    let reader = new FileReader();
                    reader.onload = function(event){
                        $('#avatarInput').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endsection
</x-main-layout>