<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
class usersController extends Controller
{
    use HasRoles;
    public function obtener()
    {
      try{
        if (Auth::user()->hasRole('Admin')) {
        //$users= User::get();
        $users = User::with('roles')->get();
        return response()->json($users,200);
        }else {
            return response()->json(['error' => 'No tienes permiso para acceder a esta función.'], 403);
        }
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }

    public function buscarUsuario($id)
    { 
         try{ 
            if (Auth::user()->hasRole('Admin')) {
            $user = User::with('roles')->find($id);
           // $u = User::find($id);
            return response()->json($user, 200);    
            }
            else 
            {
                return response()->json(['error' => 'No tienes permiso para acceder a esta función.'], 403);
            } 
        
            }catch(\Throwable $th){
              return response()->json(['error'=>$th->getMessage()], 500);
         }
    }

    public function createUser(Request $request)
    {
        try {
            if (Auth::user()->hasRole('Admin')) {
            $new_user = new User();
            $new_user->ci = $request->input('ci');
            $new_user->nombre = $request->input('nombre');
            $new_user->password = bcrypt($request->input('password')); // Encriptar la contraseña antes de guardarla
            //$new_user->rol = $request->input('rol');
            //$new_user->gerente = $request->input('gerente');
            
            $new_user->save();
            // Llamar a la función para asignar un rol al usuario
            //echo "id_usuario: ",$new_user->id, "rol obtenido del front: ",$request->input('rol');
            $this->asignarRol($new_user->id, $request->input('rol'));

           
            return response()->json($new_user, 200);
        }
        else 
        {
            return response()->json(['error' => 'No tienes permiso para acceder a esta función.'], 403);
        } 
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function edit($id,Request $request)
    { //info('Mensaje a registrar', ['contexto' => 'datos adicionales']);
        try {
            if (Auth::user()->hasRole('Admin')) {
            $user = User::find($id);
            $user->ci = $request->input('ci');
            $user->nombre = $request->input('nombre');
            
            // Verificar si se proporciona una nueva contraseña
            $newPassword = $request->input('password');
            if ($newPassword != '') {
                $user->password = bcrypt($newPassword); // Encriptar la nueva contraseña
            }
            //$user->rol = $request->input('rol');
            //$user->gerente = $request->input('gerente');//CORREGIR
            $user->save();

            // Llamar a la función para asignar un rol al usuario
            //echo "id_usuario: ",$user->id, "rol obtenido del front: ",$request->input('rol');
            $this->asignarRol($user->id, $request->input('rol'));

            return response()->json($user, 200);
             }
              else 
            {
                return response()->json(['error' => 'No tienes permiso para acceder a esta función.'], 403);
            } 
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
    
    
    /*public function editGerente($id, Request $request)
    {    
        try {
            $user = User::find($id);
            $gerenteValue = $request->input('Gerente');
            //$user->gerente = $gerenteValue === 1;
            if ($gerenteValue != 1 && $gerenteValue != 0) {
                return response()->json(['error' => 'El valor de gerente debe ser 1 o 0, pero es: ' . $gerenteValue . ', ID: ' . $id], 400);
            }else{
                info('Valor de gerente recibido:', ['gerenteValue' => $gerenteValue]);
            }
            //info('Valor de gerente recibido:', ['gerenteValue' => $gerenteValue]);
            $user->gerente = boolval($gerenteValue);
            $user->save();
    
            return response()->json($user, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }*/



    public function asignarRol($id, $Role)
    {
    try {
        if (Auth::user()->hasRole('Admin')) {
           
            //echo "EL id del usuario es: ",$id;
            $user = User::find($id);
            $role = Role::where('name', $Role)->first();

            if ($user && $role) {
                $user->syncRoles($role);
                return response()->json(['message' => 'Rol asignado con éxito'], 200);
            } else {
                return response()->json(['error' => 'Usuario o rol no encontrados'], 404);
            }
        } else {
            return response()->json(['error' => 'No tienes permiso para acceder a esta función.'], 403);
        }
    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 500);
    }
    }


    
    public function delete($id)
    {
        try {
            if (Auth::user()->hasRole('Admin')) {
            $user = User::find($id);
            $user->delete();
            return response()->json(['eliminado' => true], 200);

            }
            else 
            {
                return response()->json(['error' => 'No tienes permiso para acceder a esta función.'], 403);
            } 
            } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            }
    }
    
   /* public function login(Request $request)
    {
        $credentials = $request->only('ci','nombre', 'password');

    if (Auth::attempt($credentials)) {
        // La autenticación fue exitosa, el usuario está conectado
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([ 'success' => true,
         'user' => [
            'ci' => $user->ci,
            'nombre' => $user->nombre,
            //'rol' => $user->rol,
            //'Gerente' => $user ->gerente,
           
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
    }*/
}
