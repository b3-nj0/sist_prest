<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\prendas;
class PrendaController extends Controller
{
    public function obtenerPrenda()
    {
        try{
        $prenda= prendas::get();
        return response()->json($prenda,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }
    public function obtenerPrendaid($prenda_id)
    {
        try{
        $prenda = prendas::find($prenda_id);
        return response()->json($prenda,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }

    public function createPrenda(Request $request)
    {
        try {
            $new_prenda = new prendas();
            $new_prenda->contrato_id = $request->input('contrato_id');
            $new_prenda->valor_prenda = $request->input('valor_prenda');
            $new_prenda->descripcion = $request->input('descripcion');
            $new_prenda->estado = $request->input('estado');
            $new_prenda->save();
            return response()->json($new_prenda, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function editPrenda(Request $request, $prenda_id)
    {
        try {
            $prenda = prendas::find($prenda_id);
            $prenda->contrato_id = $request->input('contrato_id');
            $prenda->valor_prenda = $request->input('valor_prenda');
            $prenda->descripcion = $request->input('descripcion');
            $prenda->estado = $request->input('estado');
            $prenda->save();
            return response()->json($prenda, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function deletePrenda($prenda_id)
    {
        try {
            $prenda = prendas::find($prenda_id);
            $prenda->delete();
            return response()->json(['eliminado' => true], 200);
            } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            }
    }


}