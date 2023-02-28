<?php

namespace App\Http\Controllers\Home;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory(){

        $blogcategory = BlogCategory::latest()->get();
       
        return view('admin.blog_category.blog_category_all', compact('blogcategory'));

    }   // End Method

    public function AddBlogCategory(){

          return view('admin.blog_category.blog_category_add');

    } //End Method

    public function StoreBlogCategory(Request $request){

        

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
            'created_at' => Carbon::now()
        ]);

        $notification = [
                'message' => 'Blog Category Inserted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->route('all.blog.category')->with($notification);
    } //End Method


    public function EditBlogCategory($id){

        $blogcategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit', compact('blogcategory'));

    } //End Method


    public function UpdateBlogCategory(Request $request, $id){

        $blogcategory = BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category
        ]);

        $notification = [
                'message' => 'Blog Category Updated Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->route('all.blog.category')->with($notification);

    } //End Method

    public function DeleteBlogCategory($id) {

        BlogCategory::findOrFail($id)->delete();

        $notification = [
                'message' => 'Blog Category Deleted Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);

    } //End Method
}
