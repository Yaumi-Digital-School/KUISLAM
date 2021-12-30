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
        Topics
    </h2>
    <!--  add more topics -->
    <button id="add-topic" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-green-nav hover:bg-green-darkBg transition rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
        <div class="flex items-center justify-between space-x-3">
            <i class='bx bxs-plus-square text-lg'></i>
            <span>You can add more topics here</span>
        </div>
    </button>
   {{-- <form action="{{ route('topics.update', ['id' => 1]) }}" method="POST">
        @csrf
        @method("PUT")
        <input type="text" name="title">
        <button type="submit">Submit</button>
    </form> --}}
    <!-- New Table -->
    <table id="table-topic" class="display" style="width:100%">
        <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 ">
                <th class="px-4 py-3 text-center">No</th>
                <th class="px-4 py-3 text-center">Title</th>
                <th class="px-4 py-3 text-center">Slug</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topics as $topic)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm text-center">{{ $loop->index + 1 }}</td>
                    <td class="px-4 py-3 text-sm text-center">{{$topic->title}}</td>
                    <td class="px-4 py-3 text-sm text-center">{{$topic->slug}}</td>
                    <td class="px-4 py-3 text-sm flex justify-center items-center space-x-3">
                        <button data-id="{{ $topic->id }}" data-title="{{ $topic->title }}" class="btn-edit w-20 py-2 font-semibold leading-tight text-yellow-700 focus:outline-none bg-yellow-100 hover:bg-yellow-200 transition rounded-full">
                            Edit
                        </button>
                        <form action="{{ route('topics.destroy', $topic->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-20 py-2 font-semibold leading-tight text-red-700 bg-red-100 focus:outline-none hover:bg-red-200 transition rounded-full">
                                Delete 
                            </button>
                        </form>
                        {{-- <button data-id="{{ $topic->id }}" class="btn-delete w-20 py-2 font-semibold leading-tight text-red-700 bg-red-100 focus:outline-none hover:bg-red-200 transition rounded-full">
                            Delete 
                        </button> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 ">
                <th class="px-4 py-3 text-center">No</th>
                <th class="px-4 py-3 text-center">Title</th>
                <th class="px-4 py-3 text-center">Slug</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </tfoot>
    </table>

    @section('script')
    {{-- table jquery  --}}
    <script>
         $(document).ready(function() {
             $('#table-topic').DataTable();
         });
    </script>
    {{-- add topic  --}}
    <script>
        $(document).ready(function() {
            $("#add-topic").click(function(){
                Swal.fire({
                    title: 'Enter the title of the topic',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: (title) => {
                        // submit add data using ajax here
                        $.ajax({
                            type: "POST",
                            url: "{{ route('topics.store') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                title: title,
                            },
                            success: function(response) {
                                console.log(response.success.slug);
                                Swal.fire({
                                    title: `Topic "${response.success.title}" berhasil ditambahkan`,
                                    icon: "success",
                                    timer: 1500,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                }).then(function(){
                                    document.location.reload(); 
                                });
                            },
                            error: function(err){
                                if (err.status == 422) {
                                    Swal.fire({
                                        title: "Topic gagal ditambahkan",
                                        icon: "error",
                                        text: err.responseJSON.errors.title,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                    });
                                }
                            }
                        });
                    }                    
                })
            });
        } );
    </script>
    {{-- edit topic  --}} 
    <script>
        $(document).ready(function() {
            $(".btn-edit").click(function(e){
                // console.log($(this).data("title"));
                const title = $(this).data("title");
                const id = $(this).data("id");
                let url = "{{ route('topics.update', ':id') }}";
                url = url.replace(':id', id);

                Swal.fire({
                    title: 'Enter the title of the topic',
                    input: 'text',
                    inputValue: title,
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: (title) => {
                        // submit add data using ajax here
                        $.ajax({
                            type: "PUT",
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                title: title,
                            },
                            success: function(response) {
                                console.log(response.success.slug);
                                Swal.fire({
                                    title: `Topic "${response.success.title}" berhasil diedit`,
                                    icon: "success",
                                    timer: 1500,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                }).then(function(){
                                    document.location.reload(); 
                                });
                            },
                            error: function(err){
                                if (err.status == 422) {
                                    Swal.fire({
                                        title: "Topic gagal diedit",
                                        icon: "error",
                                        text: err.responseJSON.errors.title,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                    });
                                }
                            }
                        });
                    }                    
                })
            })
        });
    </script>
    {{-- delete topic  --}}
    <script>
        $(document).ready(function() {
            $(".btn-delete").click(function(e){
                const id = $(this).data("id");
                let url = "{{ route('topics.destroy', ':id') }}";
                url = url.replace(':id', id);

                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: 'Topic akan dihapus secara permanen',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: `Batalkan`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                console.log(response.success.slug);
                                Swal.fire({
                                    title: response.success,
                                    icon: "success",
                                    timer: 1500,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                }).then(function(){
                                    document.location.reload(); 
                                });
                            },
                            error: function(err){
                                if (err.status == 422) {
                                    Swal.fire({
                                        title: "Topic gagal dihapus",
                                        icon: "error",
                                        text: err.responseJSON.errors.title,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                    });
                                }
                            }
                        });
                    } 
                })
            })
        });
    </script>
    @endsection
</x-admin-layout>