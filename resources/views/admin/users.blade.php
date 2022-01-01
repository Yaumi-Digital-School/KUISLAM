<x-admin-layout titlePage="admin">
    @section('style')
        <style>
            .dataTables_length select {
                width: 5rem;
                margin-bottom: 1.5rem;
            }
            .dataTables_length input {
                margin-bottom: 1.5rem;
            }
        </style>
    @endsection
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Users
    </h2>
    <table id="table-users" class="display" style="width:100%">
        <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 ">
                <th class="px-4 py-3 text-center">No</th>
                <th class="px-4 py-3 text-center">Name</th>
                <th class="px-4 py-3 text-center">Username</th>
                <th class="px-4 py-3 text-center">Email</th>
                <th class="px-4 py-3 text-center">Role</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-sm text-center">{{ $loop->index + 1 }}</td>
                <td class="px-4 py-3 text-sm text-center">{{ $user->name }}</td>
                <td class="px-4 py-3 text-sm text-center">{{ $user->username }}</td>
                <td class="px-4 py-3 text-sm text-center">{{ $user->email }}</td>
                <td class="px-4 py-3 text-sm text-center">
                    @if ($user->role == "admin")
                        <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                            {{ $user->role }}
                        </span>
                    @else
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                            {{ $user->role }}
                        </span>
                    @endif
                </td>
                <td class="px-4 py-3 text-sm flex justify-center items-center space-x-3">
                    @if ($user->role == "admin")
                        <a href="{{ route('users.change-role', $user->id) }}" type="submit" class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 focus:outline-none hover:bg-red-200 transition rounded-full">
                            Change to user
                        </a>
                    @else
                        <a href="{{ route('users.change-role', $user->id) }}" type="submit" class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 focus:outline-none hover:bg-red-200 transition rounded-full">
                            Change to admin
                        </a>
                    @endif
                    {{-- <button data-id="{{ $question->id }}" class="btn-delete w-20 py-2 font-semibold leading-tight text-red-700 bg-red-100 focus:outline-none hover:bg-red-200 transition rounded-full">
                        Delete 
                    </button> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 ">
                <th class="px-4 py-3 text-center">No</th>
                <th class="px-4 py-3 text-center">Name</th>
                <th class="px-4 py-3 text-center">Username</th>
                <th class="px-4 py-3 text-center">Email</th>
                <th class="px-4 py-3 text-center">Role</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </tfoot>
    </table>

    @section('script')
        {{-- table jquery  --}}
        <script>
            $(document).ready(function() {
                $('#table-users').DataTable();
            });
        </script>
        {{-- redirect with message  --}}
        <script>
            const message = "{{ session('message') }}";
            if("{{ session('message') }}"){
                Swal.fire({
                    title: message,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
            }
        </script>
        {{-- delete quiz  --}}
        <script>
            $(document).ready(function() {
                $(".btn-delete").click(function(e){
                    const id = $(this).data("id");
                    let url = "{{ route('questions.destroy', ':id') }}";
                    url = url.replace(':id', id);
                    // console.log(url)
                    Swal.fire({
                        title: 'Apa kamu yakin?',
                        text: 'Question akan dihapus secara permanen',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: `Batalkan`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    // console.log(response.success.slug);
                                    Swal.fire({
                                        title: response.message,
                                        icon: "success",
                                        timer: 1500,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                    }).then(function(){
                                        document.location.reload(); 
                                    });
                                },
                                error: function(err){
                                        // console.log(err)
                                    Swal.fire({
                                        title: "Question gagal dihapus",
                                        icon: "error",
                                        text: err.responseJSON.message,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                    });
                                }
                            });
                        } 
                    })
                })
            });
        </script>
    @endsection
</x-admin-layout>