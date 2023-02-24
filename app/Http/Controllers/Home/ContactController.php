<?php

namespace App\Http\Controllers\Home;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;


class ContactController extends Controller
{
    public function Contact(){
        
        return view('frontend.contact');

    } // End Method


    public function StoreMessage(Request $request){
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now()
            
        ]);

       $notification = [
                'message' => 'Your Message Submited Successfully',
                'alert-type' => 'success'
            ];

        return redirect()->back()->with($notification);
    } // End Method


    public function ContactMessage(){
        $contacts = Contact::latest()->get();
        return view('admin.contact.allcontact', compact('contacts'));
    } // End Method


    public function DeleteMessage($id){

        Contact::findOrFail($id)->delete();

         $notification = [
                'message' => 'Your Message Deleted Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->back()->with($notification);
    } // End Method
}
