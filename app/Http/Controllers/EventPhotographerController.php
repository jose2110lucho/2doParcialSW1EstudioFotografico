<?php

namespace App\Http\Controllers;

use App\Models\EventPhotographer;
use App\Http\Requests\StoreEventPhotographerRequest;
use App\Http\Requests\UpdateEventPhotographerRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Models\UserEventAccess;

class EventPhotographerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $eventos = EventPhotographer::where('user_id', $user->id)
                  ->where('status', 1)->get();
        return view('event.eventphotographer', compact('eventos'));
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
    public function store(StoreEventPhotographerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $eventosID = $event;
        $user = Auth::user();
        $token = EventPhotographer::where('event_id', $event->id)
        ->where('user_id',$user->id)->first()->token;
        return view('event.eventphotoshow',compact('eventosID','token'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventPhotographer $eventPhotographer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventPhotographerRequest $request, EventPhotographer $eventPhotographer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventPhotographer $eventPhotographer)
    {
        //
    }

    public function verifyToken(Request $request, Event $event) {
        if ($request['token']) {
          $token = $request['token'];
          $key = $event->key_event;
          $result = JWT::decode($token, new Key($key, 'HS256'));
          if ($result) {
            $eventUser = EventPhotographer::where('event_id', $event->id)
            ->where('user_id',$result->user_id)->first();
              if ($eventUser->presence) {
                $message = "La invitacion ya fue usada";
                return view('event.verify-token', compact('event', 'message'));
              }
            $result = User::find($result->user_id);
            return view('event.verify-token', compact('result', 'event'));
          }  
        }
        $message = "No se encontraron resultados";
        return view('event.verify-token',compact('event', 'message'));
    }

    public function eventConfirm(Request $request, Event $event, User $user) {
        $eventUser = EventPhotographer::where('event_id', $event->id)
        ->where('user_id',$user->id)->first();
        if (!$eventUser) {
            $eventUser = UserEventAccess::where('event_id', $event->id)
            ->where('user_id',$user->id)->first();
        }
        $eventUser->presence = 1;
        $eventUser->save();
        $message = "";
        return redirect()->route('verify.token',compact('event', 'message'));
    }
}
