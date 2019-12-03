<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DetalleOrdenFormRequest;
use App\Http\Requests\FechaFormRequest;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\DetalleOrden;
use App\Ordenes;


class DetalleOrdenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) { }
    }

    public function EnviarOrdenPorEmail(Request $request)
    {
        Mail::to($request->email)->send(new EnviarEMail($request->content));
    }
    public function create()
    { }

    public function store(DetalleOrdenFormRequest $request)
    {
        /*  try {
            DB::beginTransaction();
*/
        $detalle                              = new DetalleOrden();
        $detalle->id_tb_ordenes               = $request->get('norden');
        $detalle->Cantidad                    = $request->get('cantidad');
        $detalle->Valor_Unitario              = $request->get('valortotal');
        $detalle->Descripcion                 = $request->get('descripcionorden');
        $detalle->id_tb_descripcion_servicios                 = $request->get('descripcionservicios');
        $detalle->save();

        $detalles = DB::table('tb_detalle_orden')
            ->select('Cantidad', 'Valor_Unitario')
            ->where('id_tb_ordenes', '=', $detalle->id_tb_ordenes)
            ->get();

        //se suman los nuevos valores de cada detalle de orden para obtener el valor total de toda la Orden
        $suma = 0;
        foreach ($detalles as $deta) {
            $suma += $deta->Cantidad * $deta->Valor_Unitario;
        }
        // dd($suma);

        $orden = Ordenes::findOrFail($detalle->id_tb_ordenes);
        $orden->Total_Venta = $suma;
        $orden->update();        /*
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
*/
        Session::flash('message', "El detalle de la orden '" . $detalle->Descripcion . "' se creó correctamente.");

        return Redirect::to('ventas/ordenes/' . $detalle->id_tb_ordenes);
    }

    public function show($id)
    { }

    public function edit($id)
    { }

    public function update(FechaFormRequest $request, $id)
    {
        $orden                      = Ordenes::findOrFail($id);
        $orden->Fecha_de_Entrega    = $request->get('Fecha_de_Entrega');
        // dd($orden->Fecha_de_Entrega);
        $orden->update();

        dd("hola desde update" . $id . $orden->Fecha_de_Entrega);
    }

    public function destroy($id)
    { }
}
