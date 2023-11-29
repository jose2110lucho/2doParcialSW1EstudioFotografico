<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SelectRolController extends Controller
{
    public function index() {
        return view('auth.select-rol');
    }

    public function updateRol($rol) {
        $user = Auth::user();
        $role =$rol?Role::where('name', 'Fotografo') : Role::where('name', 'Organizador');
        $role = $role->first();
        $user->syncRoles([$role]);
        return redirect()->to('/home');
    }
}
