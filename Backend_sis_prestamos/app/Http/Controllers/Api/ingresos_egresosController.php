<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ingresos_egresos;
class ingresos_egresosController extends Controller
{
    public function obteneringreso_egreso()
    {
        try{
        $ingreso_egreso= ingresos_egresos::get();
        return response()->json($ingreso_egreso,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }
    public function obteneringreso_egresoID($id)
    {
        try{
        $ingreso_egreso = ingresos_egresos::find($id);
        return response()->json($ingreso_egreso,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }

    public function createingreso_egreso(Request $request)
    {
        try {
            $new_ingreso_egreso = new ingresos_egresos();
            $new_ingreso_egreso->id = $request->input('id');
            $new_ingreso_egreso->ingreso = $request->input('ingreso');
            $new_ingreso_egreso->egreso = $request->input('egreso');
            $new_ingreso_egreso->amortizacion_id = $request->input('amortizacion_id');
            $new_ingreso_egreso->Renovacion_id = $request->input('Renovacion_id');
            $new_ingreso_egreso->save();
            return response()->json($new_ingreso_egreso, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function editingreso_egreso(Request $request, $id)
    {
        try {
            $ingreso_egreso = ingresos_egresos::find($id);
            $ingreso_egreso->ingreso = $request->input('ingreso');
            $ingreso_egreso->egreso = $request->input('egreso');
            $ingreso_egreso->amortizacion_id = $request->input('amortizacion');
            $ingreso_egreso->Renovacion_id = $request->input('Renovacion_id');            $ingreso_egreso->save();
            return response()->json($ingreso_egreso, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function deleteingreso_egreso($id)
    {
        try {
            $ingreso_egreso = ingresos_egresos::find($id);
            $ingreso_egreso->delete();
            return response()->json(['eliminado' => true], 200);
            } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            }
    }


}
