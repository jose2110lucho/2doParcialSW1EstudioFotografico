<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Services\RekognitionService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $user = Auth::user();
        $pictures = Picture::where('user_id', $user->id)
            ->where('event_id', $event->id)->get();
        return view('event-photo.index', compact('pictures', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('event-photo.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $user = Auth::user();
        $imagen = $request->file('file');

        $rkService = new RekognitionService();
        $faces = $rkService->searchFaceUsersByImage($imagen->get());

        $fotoCloud = Cloudinary::upload($imagen->getRealPath(), ['folders' => 'users']);
        $public_id = $fotoCloud->getPublicId();
        $url = $fotoCloud->getSecurePath();
        $imageName = time() . '.' . $imagen->extension();
        $picture = Picture::create([
            'name' => $imageName,
            'url' => $url,
            'price' => $request['price'] ? $request['price'] : 5.00,
            'event_id' => $event->id,
            'user_id' => $user->id
        ]);

        if ($faces['Status'] == 'success') {
            $rkService->relateFaceUsersToPicture($faces['FaceIds'], $picture);
        }
        return response()->json(['success' => $imageName]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Picture $picture)
    {
        $picture->delete();
        return redirect()->route('event.gallery.index', $event);
    }
}
