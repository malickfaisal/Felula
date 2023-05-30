@include('front.partials.header')

<div class="mt-16">
    <div class="grid grid-cols-12 md:grid-cols-12 gap-6 lg:gap-8">
        
        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div  class="blog_div">
                @if(isset($blog->featured_image))
                <div class="bg-red-50 dark:bg-red-800/20 flex items-center justify-center "style="width:100%">                                
                <img id="featured_image_preview"  class="img object-cover rounded-md" src="{{ $blog->featured_image }}" alt="Featured image preview" />
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

        </div>
        
    </div>
</div>
<div class="mt-16">
    <div class="grid grid-cols-12 md:grid-cols-12 gap-6 lg:gap-8">
        
        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div class="comment_div">
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
<div class="mt-16">
    <div class="grid grid-cols-12 md:grid-cols-12 gap-6 lg:gap-8">
        
        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            
            <div class="comment_div">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Post Comment</h1>
                <form method="Post" action="{{ route('comment_submit') }}">
                @csrf
                <input type='hidden' value="{{isset($blog->featured_image) ? $blog->id : ''}}" name="blog_id" />
                    <div>
                        <label>Full Name </label>
                        <div class='input-group'>
                            <input type='text' autocomplete="off" required class="form-control m-input" placeholder="Full Name"  name="full_name" />                            
                        </div>
                    </div>
                    <div>
                        <label>Comment</label>
                        <div class='input-group'>
                            <textarea autocomplete="off" required class="form-control m-input" placeholder="Comment" name="comment"></textarea>                            
                        </div>
                    </div>
                    <button type="submit" class="btn">Post</button>
                </form>
            </div>
</div>
        
    </div>
</div>
@include('front.partials.footer')
