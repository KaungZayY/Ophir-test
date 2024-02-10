@push('scripts')
    <!-- JScroll CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('post.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Post
                </a>
            </div>
            <div class="scrolling-pagination">
                @if ($posts->count())
                    @foreach ($posts as $post)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 post">
                            <div class="p-6 flex flex-col">
                                <div class="flex flex-row justify-between">
                                    <h1 class="text-lg font-bold text-green-400 dark:text-green-600 uppercase">{{$post->user->name}}</h1>
                                    <p class="text-sm text-gray-500" style="margin-left: auto">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex flex-row justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $post->title }}</h3>
                                    @can('edit-delete-post', $post)
                                        <button onclick="toggleDropdownMenu(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="4" viewBox="0 0 128 512" style="margin-left: auto">
                                                <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/>
                                            </svg>
                                        </button>
                                    @endcan
                                </div>
                                <div class="flex flex-row justify-between">
                                    <div class="flex flex-col">
                                        <p class="text-gray-600 dark:text-gray-400">{{ $post->body }}</p>
                                        <a href="{{route('post.detail',$post->id)}}" class="text-sm text-blue-500 hover:text-blue-700 mt-4">View Post</a>
                                    </div>
                                    @can('edit-delete-post', $post)
                                        <div class="inline-block hidden menu-buttons">
                                            <form action="{{route('post.edit',$post->id)}}" method="GET">
                                                <button class="bg-green-500 text-white px-2 py-1 mb-2 rounded-md w-full">Edit</button>
                                            </form>
                                            <form action="{{route('post.delete',$post->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 text-white px-2 py-1 mb-2 rounded-md w-full">Delete</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-lg text-center text-black dark:text-white">No Posts Here</p>
                @endif
                <div style="display:none">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() //jquery ready func
        {
            //jscroll 
            $('.scrolling-pagination').jscroll(
            {
                autoTrigger: true,
                padding: 0,
                nextSelector: 'a[rel="next"]',
                contentSelector: '.post',
                callback: function() {
                    $('ul.pagination').remove();
                },
                errorCallback: function() {
                    console.log('Error loading next page.');
                }
            });
        });
        
        //menu toggle
        function toggleDropdownMenu(button) 
        {
            const dropdownMenu = button.parentNode.nextElementSibling.children[1];
            dropdownMenu.classList.toggle('hidden');
        }
</script>
