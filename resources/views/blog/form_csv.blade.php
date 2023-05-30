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
                    <form method="post" action="{{ route('blogs.import.csv_submit') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                                       
                        <div>
                            
                            <x-input-label for="csv_file" value="Upload CSV" />
                            <label class="block mt-2">
                                <span class="sr-only">Choose File</span>
                                <input type="file" id="csv_file" name="csv_file" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                "/>
                            </label>
                            <x-input-error class="mt-2" :messages="$errors->get('csv_file')" />
                        </div>
                        <p>For Testing: Please find the sample csv file named as blog_sample.csv in root folder.</p>
                
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Upload') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>