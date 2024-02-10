@push('scripts')
    <!-- JScroll CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Post Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 border border-dotted">
                    <div class="p-6 flex flex-col border border-dotted">
                        <div class="flex flex-row justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $post->title }}
                            </h3>
                            @can('edit-delete-post', $post)
                                <button onclick="toggleDropdownMenu(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="4"
                                        viewBox="0 0 128 512" style="margin-left: auto">
                                        <path
                                            d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z" />
                                    </svg>
                                </button>
                            @endcan
                        </div>
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <p class="text-gray-600 dark:text-gray-400">{{ $post->body }}</p>
                            </div>
                            @can('edit-delete-post', $post)
                                <div class="inline-block hidden menu-buttons">
                                    <form action="{{ route('post.edit', $post->id) }}" method="GET">
                                        <button
                                            class="bg-green-500 text-white px-2 py-1 mb-2 rounded-md w-full">Edit</button>
                                    </form>
                                    <form action="{{ route('post.delete', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-red-500 text-white px-2 py-1 mb-2 rounded-md w-full">Delete</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <div class="flex flex-col mt-4">
                        <form action="{{route('comment.store',$post->id)}}" method="POST">
                            @csrf
                            <div class="flex flex-row mr-4 ml-4 mb-2">
                                <textarea name="text" id="text" rows="1"
                                    class="w-5/6 px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required></textarea>
                                @error('body')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                                <button type="submit"
                                    class="ml-2 w-1/6 h-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Comment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="scrolling-pagination">
                @if ($comments->count())
                    @foreach ($comments as $comment)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 comment">
                            <div class="p-6 flex flex-col">
                                <div class="flex flex-row justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                        {{ $comment->user->name }}</h3>
                                        @can('delete-comment', [$comment, $post])
                                            <button onclick="toggleDropdownMenu(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="4"
                                                    viewBox="0 0 128 512" style="margin-left: auto">
                                                    <path
                                                        d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z" />
                                                </svg>
                                            </button>
                                        @endcan
                                </div>
                                <div class="flex flex-row justify-between">
                                    <div class="flex flex-col">
                                        <p class="text-gray-600 dark:text-gray-400">{{ $comment->text }}</p>
                                    </div>
                                    @can('delete-comment', [$comment, $post])
                                            <div class="inline-block hidden menu-buttons">
                                            @can('edit-comment', [$comment, $post])
                                                <form action="{{route('comment.edit',$comment->id)}}" method="GET">
                                                    <button
                                                        class="bg-green-500 text-white px-2 py-1 mb-2 rounded-md w-full">Edit</button>
                                                </form>
                                            @endcan
                                            <form action="{{route('comment.delete',$comment->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="bg-red-500 text-white px-2 py-1 mb-2 rounded-md w-full">Delete</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-lg text-center text-black dark:text-white">No Comments Here</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() //jquery ready func
        {
            //jscroll 
            $('.scrolling-pagination').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: 'a[rel="next"]',
                contentSelector: '.comment',
                callback: function() {
                    $('ul.pagination').remove();
                },
                errorCallback: function() {
                    console.log('Error loading next page.');
                }
            });
        });

    //menu toggle
    function toggleDropdownMenu(button) {
        const dropdownMenu = button.parentNode.nextElementSibling.children[1];
        dropdownMenu.classList.toggle('hidden');
    }
</script>
