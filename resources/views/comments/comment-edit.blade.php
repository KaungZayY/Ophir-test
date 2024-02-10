<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Comment Edit') }}
        </h2>
    </x-slot>

    <div class="py-12 mt-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="#" method="POST">
                    @csrf

                    <!-- Comment -->
                    <div class="mb-4">
                        <label for="text" class="block dark:text-white text-lg font-bold mb-2">Comment</label>
                        <textarea name="text" id="text" rows="2" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>{{$comment->text}}</textarea>
                        @error('body')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end mt-4">
                        <a href="{{route('post.detail',$comment->post_id)}}" class="mr-6 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
