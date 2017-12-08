<?php

namespace App\Http\Controllers;

use App\Notes;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes=User::find(Auth::id())->Notes;
        return view('home')->with(['notes' => $notes]);
    }
}
