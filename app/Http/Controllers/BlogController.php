<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
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
            $validated['featured_image'] = url('/').'/storage/'.$filePath;
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
        $data['comments'] = Comment::where('blog_id', $id)->get();
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
            $validated['featured_image'] = url('/').'/storage/'.$filePath;
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
    /**
     * Show the form for importing rss a new resource.
     */
    public function import_rss()
    {
        return response()->view('blog.form_rss');
    }

    /**
     * Submit form of importing rss in DB.
     */
    public function import_rss_submit(Request $request)
    {
        echo $rss_url = $request->rss_url;
        $current_user = Auth::user()->id;
        $ret = array();

        // retrieve search results 
        if($xml = simplexml_load_file($rss_url)) {      
            $result["item"] = $xml->xpath("/rss/channel/item"); 
            foreach($result as $key => $attribute) { 
                $i=0; 
                foreach($attribute as $element) { 
                    $ret[$i]['title'] = (string)$element->title; 
                    $ret[$i]['content'] = (string)$element->description; 
                    $ret[$i]['short_desc'] = (string)$element->description; 
                    if(isset($element->image)){                    
                        $ret[$i]['featured_image'] = (string)$element->image; 
                    }
                    if(isset($element->content)){                    
                        $ret[$i]['content'] = $element->content; 
                    }
                    $ret[$i]['user_id'] = $current_user;
                    $ret[$i]['slug'] = Str::slug($ret[$i]['title']); 
                    $ret[$i]['created_at'] = date('Y-m-d H:i:s');  
                    $ret[$i]['updated_at'] = date('Y-m-d H:i:s'); 
                    $i++;
                } 
            } 
           // dd($ret);
            // insert all read rss entries in db
            $create = Blog::insert($ret);
            
            if($create) {
                // Alert flash for the success notification
                session()->flash('notif.success', 'Blog imported successfully!');
                return redirect()->route('blogs_view');
            }

            
        }  
        return abort(500);
        
    }
    
    /**
     * Show the form for importing csv a new resource.
     */
    public function import_csv()
    {
        return response()->view('blog.form_csv');
    }

    /**
     * Submit form of importing csv in DB.
     */
    public function import_csv_submit(Request $request)
    {
        echo $rss_url = $request->rss_url;
        $current_user = Auth::user()->id;
        $data_csv = array();
        if ($request->hasFile('csv_file')) {
            // Read CSV file
            $file = fopen(request()->file('csv_file'), 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
              //$line is an array of the csv elements
              $data_csv[] = $line;
            }
            fclose($file);
            unset($data_csv[0]);
            $data_csv = array_values($data_csv);
        } 
        $ret = array();
        
        // retrieve search results 
        if(isset($data_csv[0])) {      
            $i=0; 
            foreach($data_csv as $key => $element) {                 
                $ret[$i]['title'] = $element[0]; 
                $ret[$i]['content'] = $element[1]; 
                $ret[$i]['short_desc'] = $element[1]; 
                if(isset($element[2])){                    
                    $ret[$i]['featured_image'] = (string)$element[2]; 
                }
                $ret[$i]['user_id'] = $current_user;
                $ret[$i]['slug'] = Str::slug($ret[$i]['title']); 
                $ret[$i]['created_at'] = date('Y-m-d H:i:s');  
                $ret[$i]['updated_at'] = date('Y-m-d H:i:s'); 
                $i++;                
            } 
            // insert all csv entries in db
            $create = Blog::insert($ret);
            
            if($create) {
                // Alert flash for the success notification
                session()->flash('notif.success', 'Blog imported successfully!');
                return redirect()->route('blogs_view');
            }            
        }  
        return abort(500);        
    }
}
