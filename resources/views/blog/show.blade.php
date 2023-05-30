<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Show' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Title' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $blog->title }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Content' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {!! $blog->content !!}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Post By' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ isset($blog->admin->id) ? $blog->admin->name : "" }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Featured Image' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            <img class="h-64 w-128" src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" srcset="">
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Created At' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $blog->created_at }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Updated At' }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $blog->updated_at }}
                        </p>
                    </div>
                    
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Comments</h1>   
                    @if(isset($comments) && count($comments) > 0)       
                        @foreach($comments as $com)
                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{$com->full_name}} : {{$com->created_at}}</p>

                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        {{ $com->comment }}
                        </p>
                        @endforeach
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            No Comments found.
                        </p>
                    @endif
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>