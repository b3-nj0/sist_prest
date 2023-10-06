<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ganancias_perdidas;
class ganancias_perdidasController extends Controller
{
    public function obtenerGanancia_Perdida()
    {
        try{
        $ganancia_perdida= ganancias_perdidas::get();
        return response()->json($ganancia_perdida,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }
    public function obtenerGanancia_PerdidaID($ganancias_id)
    {
        try{
        $ganancia_perdida = ganancias_perdidas::find($ganancias_id);
        return response()->json($ganancia_perdida,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }

    public function createGanancia_Perdida(Request $request)
    {
        try {
            $new_ganancia_perdida = new ganancias_perdidas();
            $new_ganancia_perdida->ganancias_id = $request->input('ganancia_perdida');
            $new_ganancia_perdida->monto_ganancia = $request->input('monto_ganancia');
            $new_ganancia_perdida->monto_perdida = $request->input('monto_perdida');
            $new_ganancia_perdida->capital = $request->input('capitañ');
            $new_ganancia_perdida->id = $request->input('id');
            $new_ganancia_perdida->save();
            return response()->json($new_ganancia_perdida, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function editGanancia_Perdida(Request $request, $ganancias_id)
    {
        try {
            $ganancia_perdida = ganancias_perdidas::find($ganancias_id);
            $ganancia_perdida->monto_ganancia = $request->input('monto_ganancia');
            $ganancia_perdida->monto_perdida = $request->input('monto_perdida');
            $ganancia_perdida->capital = $request->input('capital');
            $ganancia_perdida->id = $request->input('id');            $ganancia_perdida->save();
            return response()->json($ganancia_perdida, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function deleteGanancia_Perdida($ganancias_id)
    {
        try {
            $ganancia_perdida = ganancias_perdidas::find($ganancias_id);
            $ganancia_perdida->delete();
            return response()->json(['eliminado' => true], 200);
            } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            }
    }


}
