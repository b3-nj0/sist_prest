<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\clientes;
use Illuminate\Http\Request;
use App\Models\contratos;
use Illuminate\Mail\Mailables\Content;
use App\Models\prendas;
class contratoController extends Controller
{
    public function obtenerContrato()
    {
        try{
            $contratos = contratos::get();

            // Verifica cada contrato y actualiza su estado si es necesario.
            foreach ($contratos as $contrato) {
                $fechaFin = Carbon::parse($contrato->fecha_fin);
                $unaSemanaAntes = Carbon::now()->addWeek();

                
                if ($contrato->estado_contrato === 'Cancelado') {
                    // Actualiza el estado del cliente a "libre" si el contrato está "cancelado".
                    $this->actualizarEstadoCliente($contrato->CI_cliente, 'libre');
                }
               elseif ($fechaFin->lte($unaSemanaAntes)) {
                    $contrato->estado_contrato = 'por vencer';
                    $contrato->save();
                }
            }

            return response()->json($contratos, 200);
        $contrato= contratos::get();
        return response()->json($contrato,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }
    public function obtenerContratoid($contrato_id)
    {
        try{
                    
        $contrato = contratos::find($contrato_id);
        return response()->json($contrato,200);
        }catch(\Throwable $th){
           return response()->json(['error' => $th -> getMessage()], 500);
        }
    }

    public function createContrato(Request $request)
    {
        try {
            $new_contrato = new contratos();
            $new_contrato->contrato_id = $request->input('contrato_id');
            $new_contrato->CI_cliente = $request->input('CI_cliente');
            $new_contrato->monto_prestamo = $request->input('monto_prestamo');
            $new_contrato->tasa_interes = $request->input('tasa_interes');
            $new_contrato->fecha_inicio = $request->input('fecha_inicio');
            $new_contrato->fecha_fin = $request->input('fecha_fin');
            $new_contrato->estado_contrato = $request->input('estado_contrato');
            $new_contrato->save();
             // Después de guardar el contrato, verifica si el cliente tiene contratos asociados.
             $CI_cliente = $request->input('CI_cliente');
             $tieneContratos = $this->verificarContratosCliente($CI_cliente);

             if ($tieneContratos) {
                 // Si el cliente tiene contratos, actualiza su estado a "deudor".
                 $this->actualizarEstadoCliente($CI_cliente, 'deudor');
             } else {
                 // Si el cliente no tiene contratos, actualiza su estado a "libre".
                 $this->actualizarEstadoCliente($CI_cliente, 'libre');
             }
            return response()->json($new_contrato, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function editContrato(Request $request, $contrato_id)
    {
        try {
            $contrato = contratos::find($contrato_id);
            $contrato->CI_cliente = $request->input('CI_cliente');
            $contrato->monto_prestamo = $request->input('monto_prestamo');
            $contrato->tasa_interes = $request->input('tasa_interes');
            $contrato->fecha_inicio = $request->input('fecha_inicio');
            $contrato->fecha_fin = $request->input('fecha_fin');
            $contrato->estado_contrato = $request->input('estado_contrato');
            $contrato->save();
             // Después de guardar el contrato, verifica si el cliente tiene contratos asociados.
             $CI_cliente = $request->input('CI_cliente');
             $tieneContratos = $this->verificarContratosCliente($CI_cliente);

             if ($tieneContratos) {
                 // Si el cliente tiene contratos, actualiza su estado a "deudor".
                 $this->actualizarEstadoCliente($CI_cliente, 'deudor');
             } else {
                 // Si el cliente no tiene contratos, actualiza su estado a "libre".
                 $this->actualizarEstadoCliente($CI_cliente, 'libre');
             }

             $this->agregarPrendasAContrato($contrato, $request->input('prendas'));
            return response()->json($contrato, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function deleteContrato($contrato_id)
    {
        try {
            $cliente = contratos::find($contrato_id);
            $cliente->delete();
            return response()->json(['eliminado' => true], 200);
            } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            }
    }
    public function verificarContratosCliente($CI_cliente)
    {
        $contratos = contratos::where('CI_cliente', $CI_cliente)->get();
        return count($contratos) > 0;
    }

    // Función para actualizar el estado del cliente
    public function actualizarEstadoCliente($CI_cliente, $nuevoEstado)
    {
        $cliente = clientes::where('CI', $CI_cliente)->first();

        if ($cliente) {
            $cliente->estado = $nuevoEstado;
            $cliente->save();
        }
    }
    public function agregarPrendasAContrato($contrato, $prendasData)
    {
        foreach ($prendasData as $prendaData) {
            $prenda = new prendas();
            $prenda->valor_prenda = $prendaData['valor_prenda'];
            $prenda->descripcion = $prendaData['descripcion'];
            $prenda->estado = $prendaData['estado'];
            $prenda->contrato_id = $contrato->id; // Asocia la prenda al contrato
            $prenda->save();
        }
    }
}
