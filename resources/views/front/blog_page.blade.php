@include('front.partials.header')

<div class="mt-16">
    <div class="grid grid-cols-12 md:grid-cols-12 gap-6 lg:gap-8">
        
        <a href="#" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div>
                @if(isset($blog->featured_image))
                <div class="bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">                                
                <img id="featured_image_preview" style="width:100%" class="img object-cover rounded-md" src="{{ isset($blog) ? Storage::url($blog->featured_image) : url('/images/no-preview.jpeg') }}" alt="Featured image preview" />
                </div>
                @endif
                <h1 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{$blog->title}}</h1>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                {!! $blog->content !!}
                </p>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Post by: {{ isset($blog->admin->id) ? $blog->admin->name : "" }}
                </p>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Created at: {{ $blog->created_at }}
                </p>
            </div>

        </a>
        
    </div>
</div>
@include('front.partials.footer')
