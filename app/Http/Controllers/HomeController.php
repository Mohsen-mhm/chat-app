<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

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
        $messages = Message::all();
        return view('home', compact('messages'));
    }

    /**
     * @return string
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $newMessage = new Message();
        $message = $newMessage->createMessage($request->message, $user->id);
        event(new MessageSent($user, $message));
        return true;
    }
}
