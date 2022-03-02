<?php

namespace App\Http\Controllers;


use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendcontact(Request $request){

     $request->validate([
         'name' => 'required',
         'email' => 'required | email',
         'message'=> 'required'
     ]);
        Mail::to('succy2010@gmail.com' )->send(new ContactMail($request->all()));
    }
}
