<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectAuthenticatedUserController extends Controller
{
    public function home(){
        if(auth()->user()->is_admin){
            return redirect('/dashboard');
        }

        if (!auth()->user()->is_admin) {
            return redirect('/');
        }

        else{
            return auth()->logout();
        }
    }
}
