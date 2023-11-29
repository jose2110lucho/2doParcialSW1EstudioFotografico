<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Profile_photo;
use App\Models\Number_contact;
use App\Rules\ProfilePicture;
use App\Services\RekognitionService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ROLSELECT;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'imagen' => ['required', 'image', 'mimes:jpg,png,jpeg', new ProfilePicture],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $rkService = new RekognitionService();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Number_contact::create([
            'number' => $data['telephone'],
            'user_id' => $user->id,
        ]);

        $imagen = $data['imagen'];
        $respFaceIndex = $rkService->indexFace('users', $imagen->get());
        $fotoCloud = Cloudinary::upload($imagen->getRealPath(), ['folders' => 'users']);
        $public_id = $fotoCloud->getPublicId();
        $url = $fotoCloud->getSecurePath();
        
        Profile_photo::create([
            'profile_photo_path' => $url,
            'user_id' => $user->id,
            'face_id' => $respFaceIndex['FaceId'],
        ]);

        return $user;
    }
}
