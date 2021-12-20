@extends('admin.layouts.app')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
      <h2
        class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
      >
        Forms
      </h2>

      <!-- General elements -->
      <h4
        class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
      >
        Form tambah topic
      </h4>
      <div
        class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
      >
      <form class="w-full" action="{{ route('topics.store') }}" method="POST">
        @csrf
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
            </div>
            <div class="md:w-3/4">
                <label class="block text-gray-500 font-regular md:text-right mb-1 md:mb-0 pr-4"
                       for="inline-full-name">
                    Title
                </label>
                <input class="bg-grey-200 appearance-none border-1 border-grey-200 rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-purple-light"
                       id="inline-full-name" type="text" name="title">
            </div>
        </div>
        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        type="submit">
                    Tambah
                </button>
            </div>
        </div>
    </form>
        
      </div>
    </div>
  </main>

@endsection