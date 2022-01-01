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
        Questions
    </h2>
    <!--  add more topics -->
    <a href="{{ route('questions.create') }}" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-green-nav hover:bg-green-darkBg transition rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
        <div class="flex items-center justify-between space-x-3">
            <i class='bx bxs-plus-square text-lg'></i>
            <span>Add questions based on quiz</span>
        </div>                                                  
    </a>
    <table id="table-questions" class="display" style="width:100%">
        <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 ">
                <th class="px-4 py-3 text-center">No</th>
                <th class="px-4 py-3 text-center">Quiz</th>
                <th class="px-4 py-3 text-center">Question</th>
                <th class="px-4 py-3 text-center">Timer</th>
                <th class="px-4 py-3 text-center">Answer</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
            <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-sm text-center">{{ $loop->index + 1 }}</td>
                <td class="px-4 py-3 text-sm text-center">{{ $question->quiz->title }}</td>
                <td class="px-4 py-3 text-sm text-center">{{ $question->question }}</td>
                <td class="px-4 py-3 text-sm text-center">{{ $question->timer }}</td>
                <td class="px-4 py-3 text-sm text-center">{{ $question->answer }}</td>
                <td class="px-4 py-3 text-sm flex justify-center items-center space-x-3">
                    <a href="{{ route('questions.edit', $question->id ) }}" class="text-center btn-edit w-20 py-2 font-semibold leading-tight text-yellow-700 focus:outline-none bg-yellow-100 hover:bg-yellow-200 transition rounded-full">
                        Edit
                    </a>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-20 py-2 font-semibold leading-tight text-red-700 bg-red-100 focus:outline-none hover:bg-red-200 transition rounded-full">
                            Delete 
                        </button>
                    </form>
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
                <th class="px-4 py-3 text-center">Quiz</th>
                <th class="px-4 py-3 text-center">Question</th>
                <th class="px-4 py-3 text-center">Timer</th>
                <th class="px-4 py-3 text-center">Answer</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </tfoot>
    </table>

    @section('script')
        {{-- table jquery  --}}
        <script>
            $(document).ready(function() {
                $('#table-questions').DataTable();
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