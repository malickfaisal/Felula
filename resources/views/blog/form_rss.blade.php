<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <style>
        .img {
            width: 128px;
            border: 1px solid #aba8a8;
            margin-top: 12px;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($blog) ? 'Edit' : 'Create' }} Blog
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('blogs.import.rss_submit') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                                       
                        <div>
                            <x-input-label for="rss_url" value="RSS Feed URL" />
                            <x-text-input id="rss_url" name="rss_url" type="url" class="mt-1 block w-full" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('rss_url')" />
                        </div>
                        <p>For Testing: https://www.cbsnews.com/latest/rss/main</p>
                        <p>For Testing: https://abcnews.go.com/abcnews/usheadlines</p>
                
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>