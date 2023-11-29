<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Profile_photo;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\RekognitionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $eventos = Event::all()->where('user_id', $user->id);
        return view('event/index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $evento = Event::create([
            'name' => $request['nombre'],
            'detail' => $request['descripcion'],
            'address' => $request['direccion'],
            'key_event' => Str::uuid()->toString(),
            'start_date' => $request['fecha'],
            'start_time' => $request['hora'],
            'privacity' => $request['tipos_fotografias'],
            'user_id' => $userId,

        ]);

        return redirect('event');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $eventosID = Event::findOrFail($id);
        return view('event.show', compact('eventosID'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $eventoId = Event::findOrFail($id);
        return view('event.edit', compact('eventoId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lista = [
            'name' => $request->nombre,
            'detail' => $request->descripcion,
            'address' => $request->direccion,
            'start_date' => $request->fecha,
            'start_time' => $request->hora,
            'privacity' => $request->tipos_fotografias,
        ];

        Event::where('id', '=', $id)->update($lista);
        return redirect('event');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Event::destroy($id);
        return redirect('event');
    }

    /**
     * 
     */
    public function listGuests(Event $event)
    {
        $guests = $event->guests;
        return view('event.list_guests', compact('event'));
    }
}
