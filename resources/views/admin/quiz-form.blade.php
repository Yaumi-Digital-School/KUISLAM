<x-admin-layout titlePage="admin">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Quizzes
    </h2>
    <form action="{{ isset($editQuiz) ? route('quizzes.update', $editQuiz->id) : route('quizzes.store')}}" method="POST" enctype="multipart/form-data" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        @csrf
        @isset($editQuiz)
            @method('PUT')
        @endisset
        {{-- title field  --}}
        <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Title</span>
            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="title"
                placeholder="Nabi adam dan sejarahnya"
                value="{{ isset($editQuiz->title ) ? $editQuiz->title : old('title') }}"/>
            @error('title')
                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
            @enderror 
        </label>
        {{-- message field  --}}
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">Description</span>
            <textarea name="description"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3">{{ isset($editQuiz->description) ?  $editQuiz->description : old('description') }}</textarea>
            @error('description')
                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
            @enderror
        </label>
        {{-- topic list field  --}}
        <div class="mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">
                Topic
            </span>
            <div class="mt-2 grid grid-cols-6">
                @foreach ($topics as $topic)
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400 mr-3">
                        <input type="radio"
                            class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            name="topic_id"
                            value="{{ $topic->id }}" 
                            @if(isset($editQuiz->topic->id) && ($editQuiz->topic->id == $topic->id))
                                checked
                            @elseif ($loop->index == 0)
                                checked
                            @endif/>
                        <span class="ml-2">{{ $topic->title }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        {{-- image field  --}}
        <div class="mt-4 text-sm text-gray-700">
            <p class="">Upload Quiz Image</p>
            <div class="mt-4">
                    <div class="flex space-x-6">
                        <div>
                            <label class="w-32 bg-green-nav text-regular font-semibold text-white custom-file-upload hover:bg-green-darkBg transition rounded-md px-4 py-2 cursor-pointer" style="text-align: center;">
                                Upload image
                                <input accept=".png, .jpg, .jpeg" type="file" style="display: none;" name="image" id="image"/>
                            </label>
                        </div>
                        <div class="text-sm @error('image') text-red-600 @enderror font-bold"> 
                            @error('image') <p> {{$message}}</p> @enderror 
                        </div>
                    </div>
                <img src="" style="max-height: 100px; width: auto" class="my-3" id="previewImgAdd">
            </div>
        </div>
        {{-- button submit  --}}
        <button type="submit" class="mt-4 focus:outline-none bg-green-nav hover:bg-green-darkBg transition w-full text-white font-semibold rounded-md py-1">Add Quiz</button>
    </form>
    @section('script')
        
    @endsection
</x-admin-layout>