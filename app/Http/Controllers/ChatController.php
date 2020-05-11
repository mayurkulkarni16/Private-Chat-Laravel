<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageReadEvent;
use App\Events\PrivateChatEvent;
use App\Http\Resources\ChatResource;
use App\Session;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }

    /**
     * Insert sent and received messages in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Session $session
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function send(Session $session, Request $request)
    {
        $message = $session->messages()->create(['message' => $request->contents]);

        $chat = $message->sendMessage($session->id);

        $message->receiveMessage($session->id, $request->content_to);

        broadcast(new PrivateChatEvent($request->contents, $chat));

        return response($chat->id, 200);
    }

    /**
     * Get all chats of specific session from storage.
     *
     * @param Session $session
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function chats(Session $session)
    {
        return ChatResource::collection($session->chats->where('user_id', Auth::id()));
    }

    /**
     * Get all chats of specific session from storage.
     *
     * @param Session $session
     * @return string
     */
    public function readRecentMessage(Session $session)
    {
        $readChats = $session->chats->where('read_at', null)->where('type', 0)->where('user_id', '!=', Auth::id());

        foreach ($readChats as $read){
            $read->update(['read_at' => Carbon::now()]);
            broadcast(new MessageReadEvent(new ChatResource($read), $read->session_id));
        }
    }
}
