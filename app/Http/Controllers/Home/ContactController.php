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
}
