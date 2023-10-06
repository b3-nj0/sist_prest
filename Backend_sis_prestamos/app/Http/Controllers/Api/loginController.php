<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\roles;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
   
   
    public function login(Request $request)
    {
        $credentials = $request->only('ci','nombre', 'password');

    if (Auth::attempt($credentials)) {
        // La autenticación fue exitosa, el usuario está conectado
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;


        // Obtener el nombre del rol del usuario
        $rol = $user->roles->first()->name;

        return response()->json([ 'success' => true,
         'user' => [
            'ci' => $user->ci,
            'nombre' => $user->nombre,
            'rol'=>$rol
        ], 
        'token' => $token,
        ], 200);
    } else {
        // La autenticación falló
        return response()->json(['error' => 'Invalid ci or password'], 401);
    }
    
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        Auth::guard('web')->logout();
        return response()->json(['success' => true, 'message' => 'User logged out'], 200);
    }
   
}
