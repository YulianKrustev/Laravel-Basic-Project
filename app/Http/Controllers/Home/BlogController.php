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

    public function EditBlog($id){
        $blogs = Blog::findOrFail($id);
        $blogCategory = BlogCategory::orderBy('blog_category','ASC')->get();
        return view('admin.blogs.blogs_edit', compact('blogs', 'blogCategory'));
    } //End Method

    public function UpdateBlog(Request $request, $id){
      $blog_id = $id;

        if ($request->file('blog_image')) {
            $image = $request->file('blog_image');
            
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            
            Image::make($image)->resize(430 ,327)->save('upload/blog/' . $name_gen);

            $save_url = 'upload/blog/'. $name_gen;


            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_description' => $request->blog_description,
                'blog_tags' => $request->blog_tags,
                'blog_image' => $save_url,
            ]);

            $notification = [
                'message' => 'Blog Updated Successfully',
                'alert-type' => 'success'
            ];

        } else {
             Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_description' => $request->blog_description,
                'blog_tags' => $request->blog_tags,
                
            ]);

            $notification = [
                'message' => 'Blog Updated without Image Successfully',
                'alert-type' => 'success'
            ];

            
        } // End Else

        return redirect()->route('all.blog')->with($notification);

    } // End Method

    public function DeleteBlog($id){

        $blog = Blog::findOrFail($id);

        if ($blog->blog_image) {
            $img = $blog->blog_image;
        unlink($img);
        }
        

        Blog::findOrFail($id)->delete();

        $notification = [
                'message' => 'Blog Deleted Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.blog')->with($notification);
    } // End Method


    public function BlogDetails($id){
        $allblogs = Blog::latest()->limit(5)->get();
        $blogs = Blog::findOrFail($id);
        $blogCategory = BlogCategory::orderBy('blog_category','ASC')->get();

        return view('frontend.blog_details', compact('blogs','allblogs','blogCategory'));

    } // End Method

    public function CategoryBlog($id){
        
        $blogpost = Blog::where('blog_category_id', $id)->orderBy('id','DESC')->get();
        $allblogs = Blog::latest()->limit(5)->get();
        $blogCategory = BlogCategory::orderBy('blog_category','ASC')->get();
        $categoryname = BlogCategory::findOrFail($id);
        return view('frontend.cat_blog_details', compact('blogpost','allblogs', 'blogCategory', 'categoryname'));
    } // End Method

    public function HomeBlog(){
        
        $blogCategory = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $allblogs = Blog::latest()->get();
        return view('frontend.blog', compact('allblogs', 'blogCategory'));
        
    } // End Method
}
