<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\clientes;
class clienteController extends Controller
{
    public function obtenerCliente()
    {
        try{
        $cliente= clientes::get();
        return response()->json($cliente,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }
    public function obtenerClienteCI($CI)
    {
        try{
        $cliente = clientes::find($CI);
        return response()->json($cliente,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }

    public function createCliente(Request $request)
    {
        try {
            $new_client = new clientes();
            $new_client->CI = $request->input('CI');
            $new_client->nombre = $request->input('nombre');
            $new_client->direccion = $request->input('direccion');
            $new_client->telefono = $request->input('telefono');
            $new_client->calificacion = $request->input('calificacion');
            $new_client->estado = $request->input('estado');
            $new_client->save();
            return response()->json($new_client, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function editCliente(Request $request, $CI)
    {
        try {
            $cliente = clientes::find($CI);
            $cliente->CI = $request->input('CI');
            $cliente->nombre = $request->input('nombre');
            $cliente->direccion = $request->input('direccion');
            $cliente->telefono = $request->input('telefono');
            $cliente->calificacion = $request->input('calificacion');
            $cliente->estado = $request->input('estado');
            $cliente->save();
            return response()->json($cliente, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function deleteCliente($CI)
    {
        try {
            $cliente = clientes::find($CI);
            $cliente->delete();
            return response()->json(['eliminado' => true], 200);
            } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            }
    }
// Controlador para clientes
public function actualizarEstadoCliente($ciCliente, $nuevoEstado) {
    $cliente = clientes::where('CI', $ciCliente)->first();
    if ($cliente) {
        $cliente->estado = $nuevoEstado;
        $cliente->save();
        return response()->json(['message' => 'Estado actualizado correctamente']);
    } else {
        return response()->json(['message' => 'Cliente no encontrado'], 404);
    }
}


}
