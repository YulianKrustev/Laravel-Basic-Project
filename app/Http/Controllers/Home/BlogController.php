<?php

namespace App\Http\Controllers\Home;

use Image;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function AllBlog(){

        $blogs = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('blogs'));

    } //End Method

    public function AddBlog(){

        $blogCategory = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blogs.blogs_add', compact('blogCategory'));
        
    } //End Method

    public function StoreBlog(Request $request){

        $image = $request->file('blog_image');
            
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            
            Image::make($image)->resize(430 ,327)->save('upload/blog/' . $name_gen);

            $save_url = 'upload/blog/'. $name_gen;


            Blog::insert([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
                'created_at' => Carbon::now()
            ]);

            $notification = [
                'message' => 'Blog Inserted Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.blog')->with($notification);
        
    } //End Method
}
