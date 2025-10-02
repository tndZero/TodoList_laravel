<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        // Optionally, you can check if the user is authenticated
        // if (!Auth::check()) {
        //     return redirect()->route('login.form');
        // }
        return view('main');
    }
}
