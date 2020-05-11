<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        return UserResource::collection(User::class);
//        return new UserResource(auth()->user());
        return view('home');
    }

    public function getFriends(){
//        return new UserCollection(User::all());
        return UserResource::collection(User::where('id', '!=', Auth::id())->get());
//        return User::all();
    }
}
