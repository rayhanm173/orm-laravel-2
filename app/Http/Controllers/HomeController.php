<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        $users = User::where('id','!=',auth()->user()->id)->get();
        $user = null;
        $chats = null;


        if ($request->user) {
            $user = User::find($request->user);
            $chats = Chat::where(function ($query) use ($user) {
                $query->where('sender_id', auth()->id())->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)->where('receiver_id', auth()->id());
            })->get();
        }


        return view('home', compact('users', 'user', 'chats'));
    }
}
