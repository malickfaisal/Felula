<?php

namespace App\Http\Controllers;

use App\Models\Blog;
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
        return response()->view('front.blog_page', $data);
    }
}
