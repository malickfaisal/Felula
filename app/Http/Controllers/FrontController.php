<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index()
    {
        $data['blogs'] = Blog::orderBy('updated_at', 'desc')->get();        
        return response()->view('front.home', $data);
    }
    public function blog($slug)
    {
        $data['blog'] = Blog::with('admin')->where('slug', $slug)->first();
        $data['comments'] = Comment::where('blog_id', $data['blog']->id)->get();
        return response()->view('front.blog_page', $data);
    }
    public function comment_submit(Request $request){
        $data=$request->all();
        unset($data['_token']);
        $modal = new Comment;
        $affected_rows =  $modal::create($data);
        return redirect()->back();
    }
}
