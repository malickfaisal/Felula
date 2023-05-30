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
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post" action="{{ isset($blog) ? route('blogs_update', $blog->id) : route('blogs.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($blog)
                            @method('put')
                        @endisset
                
                        <div>
                            <x-input-label for="title" value="Title" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="$blog->title ?? old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="short_desc" value="Short Description" />
                            <x-textarea-input id="short_desc" name="short_desc" class="mt-1 block w-full" required autofocus>{{ $blog->short_desc ?? old('short_desc') }}</x-textarea-input>
                            <x-input-error class="mt-2" :messages="$errors->get('short_desc')" />
                        </div>
                        <div>
                            <x-input-label for="content" value="Content" />
                            <x-textarea-input id="content" name="content" class="ckeditor mt-1 block w-full" required autofocus>{{ $blog->content ?? old('content') }}</x-textarea-input>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <div>
                            <x-input-label for="featured_image" value="Featured Image" />
                            <label class="block mt-2">
                                <span class="sr-only">Choose image</span>
                                <input type="file" id="featured_image" name="featured_image" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                "/>
                            </label>
                            <div class="shrink-0 my-2">
                                <img id="featured_image_preview" class="img object-cover rounded-md" src="{{ isset($blog) ? Storage::url($blog->featured_image) : url('/images/no-preview.jpeg') }}" alt="Featured image preview" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('featured_image')" />
                        </div>
                
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // create onchange event listener for featured_image input
        document.getElementById('featured_image').onchange = function(evt) {
            const [file] = this.files
            if (file) {
                // if there is an image, create a preview in featured_image_preview
                document.getElementById('featured_image_preview').src = URL.createObjectURL(file)
            }
        }
    </script>
</x-app-layout>