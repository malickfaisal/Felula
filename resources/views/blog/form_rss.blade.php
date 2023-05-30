<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Import Blog From RSS
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