<?php

namespace App\Http\Controllers;

use App\Events\chat as EventsChat;
use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return response()->json([
            "data"      => Chat::where('task_id',$id)->orderBy('created_at','asc')->get(),
            "status"    => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $channel)
    {
        EventsChat::dispatch($channel,[
            'message' => $request->msg,
            'from'    => $request->from,
            'type'    => $request->type,
            'reply'   => $request->reply,
            'time'    => $request->time
        ]);
        try{
            chat::create([
                'id_chat' => Str::uuid()->toString(),
                'task_id' => $channel,
                'message' => $request->msg,
                'from'    => $request->from,
                'type'    => $request->type,
                'reply'   => $request->reply,
                'time'    => $request->time
            ]);
        }catch(\Exception $e){
            return $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chat $chat)
    {
        //
    }
}
