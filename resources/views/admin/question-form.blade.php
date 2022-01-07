<x-admin-layout titlePage="admin">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Question
    </h2>
    <form action="{{ isset($editQuestion) ? route('questions.update', $editQuestion->id) : route('questions.store')}}" method="POST" enctype="multipart/form-data" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        @csrf
        @isset($editQuestion)
            @method('PUT')
        @endisset
        {{-- question field  --}}
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">Question</span>
            <textarea name="question"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3">{{ isset($editQuestion->question) ?  $editQuestion->question : old('question') }}</textarea>
            @error('question')
                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
            @enderror
        </label>
        {{-- options field  --}}
        @for ($i = 1; $i <= 4; $i++)
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">Option {{ $i }}</span>
            <textarea name="option_{{ $i }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3">{{ isset($editQuestion->{'option_'.$i}) ?  $editQuestion->{'option_'.$i} : old("option_{$i}") }}</textarea>
            @error("option_{$i}")
                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
            @enderror
        </label>
        @endfor
        {{-- answer and timner field  --}}
        <div class="mt-4 text-sm flex">
            {{-- answer field  --}}
            <div>
                <div class="flex items-center">
                    <span class="text-gray-700 dark:text-gray-400">
                        Answer
                    </span>
                    @error("answer")
                        <span class="text-xs text-red-600 dark:text-red-400 ml-3">{{$message}}</span>
                    @enderror 
                </div>
                <div class="mt-2 grid grid-cols-6">
                    @for ($i = 1; $i <= 4; $i++)
                        <label class="inline-flex items-center text-gray-600 dark:text-gray-400 mr-3">
                            <input type="radio"
                                class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                name="answer"
                                value="option_{{ $i }}" 
                                @if(isset($editQuestion->answer) && "option_{$i}" == $editQuestion->answer)
                                    checked
                                @elseif ($i == 1)
                                    checked
                                @endif/>
                            <span class="ml-2">Option {{ $i }}</span>
                        </label>
                    @endfor
                </div>
            </div>
            {{-- timer field  --}}
            <div class="">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Timer (Seconds)</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        type="number"
                        name="timer"
                        placeholder="45"
                        value="{{ isset($editQuestion->timer ) ? $editQuestion->timer : old('timer') }}"/>
                    @error('timer')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror 
                </label>
            </div>
        </div>
        {{-- Quiz lists field  --}}
        <div class="mt-4 text-sm">
            <div class="flex items-center">
                <span class="text-gray-700 dark:text-gray-400">
                    Quiz
                </span>
                @error("quiz_id")
                    <span class="text-xs text-red-600 dark:text-red-400 ml-3">{{$message}}</span>
                @enderror 
            </div>
            <div class="mt-2 grid grid-cols-6">
                @foreach ($quizzes as $quiz)
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400 mr-3">
                        <input type="radio"
                            class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            name="quiz_id"
                            value="{{ $quiz->id }}" 
                            @if(isset($editQuestion->quiz->id) && ($editQuestion->quiz->id == $quiz->id))
                                checked
                            @elseif ($loop->index == 0)
                                checked
                            @endif/>
                        <span class="ml-2">{{ $quiz->title }}</span>
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
                            {{-- <p>Harus berupa file gambar dengan ekstensi .jpg, .jpeg, atau .png</p> --}}
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