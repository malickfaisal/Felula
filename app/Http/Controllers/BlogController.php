<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\Blog\StoreRequest;
use App\Http\Requests\Blog\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['blogs'] = Blog::orderBy('updated_at', 'desc')->get();
        
        return response()->view('blog.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('blog.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        
        $validated = $request->validated();
        
        if ($request->hasFile('featured_image')) {
             // store image in the public storage folder
            $filePath = Storage::disk('public')->put('images/posts/featured-images', request()->file('featured_image'));
            $validated['featured_image'] = $filePath;
        }
        
        $validated['user_id'] = Auth::user()->id;
        $validated['slug'] = Str::slug($request->title);
        
        // insert only requests that already validated in the StoreRequest
        $create = Blog::create($validated);

        if($create) {
            // Alert flash for the success notification
            session()->flash('notif.success', 'Blog created successfully!');
            return redirect()->route('blogs_view');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['blog'] = Blog::with('admin')->findOrFail($id);
        return response()->view('blog.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['blog'] = Blog::findOrFail($id);
        return response()->view('blog.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $blog = Blog::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            // Remove image from folder
            Storage::disk('public')->delete($blog->featured_image);

            $filePath = Storage::disk('public')->put('images/posts/featured-images', request()->file('featured_image'), 'public');
            $validated['featured_image'] = $filePath;
        }        
        $validated['slug'] = Str::slug($request->title);

        $update = $blog->update($validated);

        if($update) {
            session()->flash('notif.success', 'Post updated successfully!');
            return redirect()->route('blogs_view');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $blog = Blog::findOrFail($id);

        Storage::disk('public')->delete($blog->featured_image);
        
        $delete = $blog->delete($id);

        if($delete) {
            session()->flash('notif.success', 'Blog deleted successfully!');
            return redirect()->route('blogs_view');
        }

        return abort(500);
    }
}
