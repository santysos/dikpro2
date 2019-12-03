<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use App\DetalleOrden;
use App\Http\Requests\OrdenesFormRequest;
use App\Http\Requests\EditarDetalleOrdenFormRequest;
use App\Ordenes;
use App\Persona;
use App\Proceso;
use App\Productos;
use App\Servicios;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OrdenesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $ordenes = DB::table('tb_ordenes as ord')
                ->join('users as emp', 'emp.id', '=', 'ord.asignador')
                ->join('users as age', 'age.id', '=', 'ord.agente')
                ->join('tb_cliente as cli', 'cli.id_tb_cliente', '=', 'ord.id_tb_cliente')
                ->select('ord.id_tb_ordenes', 'ord.Fecha_de_Inicio', 'ord.Fecha_de_Entrega', 'ord.Revision_de_Diseno', 'ord.Total_Venta', 'ord.IVA', 'ord.Abono', 'ord.Observaciones', 'ord.condicion', 'emp.name as asignador', 'age.name as agente', 'cli.Cliente_Nombre_Comercial')
                ->where('cli.Cliente_Nombre_Comercial', 'LIKE', '%' . $query . '%')
                ->where('ord.condicion', '=', '1')
                ->orwhere('ord.id_tb_ordenes', '=', $query)
                ->orderBy('ord.id_tb_ordenes', 'desc')
                ->groupBy('ord.id_tb_ordenes', 'ord.Fecha_de_Inicio', 'ord.Fecha_de_Entrega', 'ord.Revision_de_Diseno', 'ord.Total_Venta', 'ord.IVA', 'ord.Abono', 'ord.Observaciones', 'ord.condicion', 'emp.name', 'cli.Cliente_Nombre_Comercial', 'age.name', 'asignador', 'agente')
                ->paginate(20);

            return view('ventas.ordenes.index', ["ordenes" => $ordenes, "searchText" => $query]);
        }
    }

    public function getDescripcionServicios(Request $request, $id)
    {
        if ($request->ajax()) {
            $descserv = Productos::dese($id);
            return response()->json($descserv);
        }
    }

    public function getClientes(Request $request, $id)
    {
        if ($request->ajax()) {
            $clientes = Persona::BuscarCliente($id);
            return response()->json($clientes);
        }
    }
    public function getClientesS2(Request $request)
    {

        if ($request->ajax()) {
            $clientes = Persona::BuscarCliente($request->term);
            return response()->json($clientes);
        }
    }
    public function create()
    {
        $agentes = User::where('id_tb_tipo_empleados', '=', '2')->where('condicion', '=', '1')->pluck('name', 'id'); //selecionar el id de agentes de ventas

        $servicios = Servicios::where('condicion', '=', '1')->pluck('Servicio', 'id_tb_Servicios');

        $ordenes = Ordenes::pluck('id_tb_ordenes')->last();

        return view('ventas.ordenes.create', compact('servicios', 'agentes', 'ordenes'));
    }

    public function store(OrdenesFormRequest $request)
    {
        try {

            DB::beginTransaction();

            $orden                = new Ordenes;
            $orden->id_tb_ordenes = $request->get('id_tb_ordenes');

            $mytime                 = Carbon::now('America/Guayaquil');
            $orden->Fecha_de_Inicio = $mytime->toDateTimeString();

            $tiempo                  = new Carbon($request->get('Fecha_de_Entrega'));
            $orden->Fecha_de_Entrega = $tiempo->toDateTimeString();

            if ($request->get('Revision_de_Diseno') != null) {
                $tiempo                    = new Carbon($request->get('Revision_de_Diseno'));
                $orden->Revision_de_Diseno = $tiempo->toDateTimeString();
            } else {
                $orden->Revision_de_Diseno = $request->get('Revision_de_Diseno');
            }

            $orden->Total_Venta   = $request->get('total_venta');
            $orden->Observaciones = $request->get('Observaciones');
            $orden->id_tb_cliente = $request->get('CodigoCliente');
            $orden->Condicion     = '1';
            $orden->agente        = $request->get('agentes');
            $orden->asignador     = $request->get('usuario');
            if ($request->get('domicilio') == "on")
                $orden->entrega_domicilio     = 1;




            $orden->IVA   = '12';
            $orden->Abono = $request->get('Abono');
            $orden->save();

            $id_tb_descripcion_servicios = $request->get('iddescripcionservicios');
            $Cantidad                    = $request->get('cantidad');
            $Valor_Unitario              = $request->get('valortotal');
            $Descripcion                 = $request->get('descripcion');

            $cont = 0;

            while ($cont < count($id_tb_descripcion_servicios)) {
                $detalle                              = new DetalleOrden();
                $detalle->id_tb_ordenes               = $orden->id_tb_ordenes;
                $detalle->id_tb_descripcion_servicios = $id_tb_descripcion_servicios[$cont];
                $detalle->Cantidad                    = $Cantidad[$cont];
                $detalle->Valor_Unitario              = $Valor_Unitario[$cont];
                $detalle->Descripcion                 = $Descripcion[$cont];

                $detalle->save();

                $cont = $cont + 1;
            }

            $proceso                             = new Proceso();
            $proceso->tb_ordenes_id_tb_ordenes   = $orden->id_tb_ordenes;
            $mytime                              = Carbon::now('America/Guayaquil');
            $proceso->tb_fecha_hora              = $mytime->toDateTimeString();
            $proceso->id_tb_descripcion_procesos = '1';
            $proceso->asignador                  = $request->get('usuario');
            $proceso->asignado                   = $orden->agente;
            $proceso->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        Session::flash('message', "Orden #" . $orden->id_tb_ordenes . " creada Satisfactoriamente");

        return Redirect::to('ventas/ordenes');
    }

    public function show($id)
    {
        function formatofecha($fecha)
        {
            if ($fecha != null) {
                setlocale(LC_TIME, "es_ES.UTF-8");

                return $fec = strftime("%A, %d de %B de %Y - %H:%M%p", strtotime($fecha));
            } else {
                return null;
            }
        }

        function consultaasignados($id, $id_descripcion_procesos)
        {
            $vart = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.asignado')
                ->join('tb_ordenes as ord', 'ord.id_tb_ordenes', '=', 'pro.tb_ordenes_id_tb_ordenes')
                ->select('pro.id_tb_procesos', 'pro.tb_fecha_hora', 'emp.name as asignado', 'emp.name as asignador')
                ->where('ord.condicion', '=', '1')
                ->where('pro.tb_ordenes_id_tb_ordenes', '=', $id)
                ->where('pro.id_tb_descripcion_procesos', '=', $id_descripcion_procesos)
                ->orderBy('tb_fecha_hora', 'desc')
                ->first();

            // dd($vart);

            if (isset($vart)) {
                $next = Proceso::select('tb_fecha_hora', 'id_tb_procesos', 'asignado')
                    ->where('tb_ordenes_id_tb_ordenes', '=', $id)
                    ->where('id_tb_procesos', '>=', $vart->id_tb_procesos)
                    ->limit('2')
                    ->get();

                //  dd($next);

                $next->finicio = formatofecha($next[0]->tb_fecha_hora);

                if (count($next) >= 2) {

                    $next->calculofechas = diferenciafecha($next[0]->tb_fecha_hora, $next[1]->tb_fecha_hora); //tiempo que se demoro en el proceso
                } else {

                    $next->calculofechas = diferenciafecha($next[0]->tb_fecha_hora, $next[0]->tb_fecha_hora);
                }

                $next->asignado = $vart->asignado;

                return $next;
            } else {

                $next = Proceso::select('tb_fecha_hora', 'id_tb_procesos', 'asignado')
                    ->where('tb_ordenes_id_tb_ordenes', '=', $id)
                    ->limit('1')
                    ->get();
                $next->finicio          = '';
                $next[0]->tb_fecha_hora = '';

                $next->calculofechas = '';
                $next->asignado      = 'No asignado';

                return $next;
            }
        }

        function diferenciafecha($fecha1, $fecha2)
        {

            $datetime1 = date_create($fecha1);
            $datetime2 = date_create($fecha2);

            $respuesta = date_diff($datetime1, $datetime2);

            if ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0 && $respuesta->h == 0 && $respuesta->i == 0 && $respuesta->s == 0) {
                $respuesta = '';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0 && $respuesta->h == 0 && $respuesta->i == 0) {
                $respuesta = $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0 && $respuesta->h == 0) {
                $respuesta = $respuesta->i . 'min ' . $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0) {
                $respuesta = $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0) {
                $respuesta = $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0) {
                $respuesta = $respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';
                return $respuesta;
            } elseif ($respuesta->y >= 1) {
                $respuesta = $respuesta->y . 'a��� ' . $respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';
                return $respuesta;
            }
            return $respuesta;
        }

        $orden = Ordenes::findOrFail($id);

        $orden->Fecha_de_Inicio    = formatofecha($orden->Fecha_de_Inicio);
        $orden->Fecha_de_Entrega   = formatofecha($orden->Fecha_de_Entrega);
        $orden->Revision_de_Diseno = formatofecha($orden->Revision_de_Diseno);

        //dd($orden->Fecha_de_Inicio);

        $cliente = Persona::findOrFail($orden->id_tb_cliente);

        $detalleorden = DB::table('tb_detalle_orden as do')
            ->join('tb_descripcion_servicios as ds', 'do.id_tb_descripcion_servicios', '=', 'ds.id_tb_descripcion_servicios')
            ->join('tb_servicios as ser', 'ser.id_tb_Servicios', '=', 'ds.id_tb_Servicios')
            ->select('do.id_do', 'do.id_tb_descripcion_servicios', 'do.Cantidad', 'do.Valor_Unitario', 'do.Descripcion', 'ds.Productos', 'ser.Servicio')
            ->where('do.id_tb_ordenes', '=', $id)
            ->get();

        //selecciona el proceso en donde se encuentra la orden
        $procesos1 = DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.asignador')
            ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
            ->select('pro.id_tb_procesos', 'pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'pro.num_factura', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dpro.id_tb_descripcion_procesos')
            ->where('pro.tb_ordenes_id_tb_ordenes', '=', $id)
            ->where('pro.condicion', '=', '1')
            ->get();

        $agente = consultaasignados($id, 1); //comprueba que el agente asignado

        $disenador = consultaasignados($id, 2); //comprueba que el diseñador asignado

        // dd($disenador);

        $impresor = consultaasignados($id, 12); //comprueba que el impresor asignado

        $artefinalista = consultaasignados($id, 13); //comprueba que el arte finalista asignado

        $servicios = Servicios::pluck('Servicio', 'id_tb_Servicios');

        //  dd($servicios);

        return view("ventas.ordenes.show", ["artefinalista" => $artefinalista, "servicios" => $servicios, "impresor" => $impresor, "disenador" => $disenador, "orden" => $orden, "cliente" => $cliente, "detalleorden" => $detalleorden, "agente" => $agente, "procesos1" => $procesos1]);
    }

    public function edit($id)
    {
        return view("ventas.ordenes.edit", ["ordenes" => Ordenes::findOrFail($id)]);
    }

    public function update(EditarDetalleOrdenFormRequest $request, $id)
    {

        $detalle                              = DetalleOrden::findOrFail($id);
        // dd($request->get('cantidad'));
        $detalle->Cantidad                    = $request->get('cantidad');
        $detalle->Valor_Unitario              = $request->get('valortotal');
        $detalle->Descripcion                 = $request->get('descripcionorden');
        $detalle->update();


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
        $orden->update();
        //dd($orden);

        Session::flash('message', "El detalle de la orden '" . $detalle->Descripcion . "' se editó correctamente.");

        return Redirect::to('ventas/ordenes/' . $detalle->id_tb_ordenes);
    }

    public function destroy($id)
    {
        $ordenes            = Ordenes::findOrFail($id);
        $ordenes->condicion = '0';
        $ordenes->update();

        return Redirect::to('ventas/ordenes');
    }
    public function borrarorden($id)
    {
        $ordenes            = Ordenes::findOrFail($id);
        $ordenes->condicion = '0';
        $ordenes->update();

        return Redirect::to('ventas/ordenes');
    }

    public function borrardetalle($id)
    {
        //selecionamos el detalle a eliminar de la Orden
        $detalle                              = DetalleOrden::findOrFail($id);
        //obtenemos el numero de ORDEN
        $num_orden = $detalle->id_tb_ordenes;

        //Obtenemos todos los detalles de la ORDEN
        $detalles = DB::table('tb_detalle_orden')
            ->where('id_tb_ordenes', '=', $num_orden)
            ->get();

        //comprobamos si la orden tiene un unico detalle, lo elimina y tambien elimina toda la orden
        if ($detalles->count() == 1) {
            $detalleorden = DB::table('tb_detalle_orden')
                ->where('id_do', '=', $id)
                ->delete();

            $ordenes            = Ordenes::findOrFail($num_orden);
            $ordenes->condicion = '0';
            $ordenes->update();

            Session::flash('message', "La Orden'" . $num_orden . "' se elimino correctamente.");

            return Redirect::to('ventas/ordenes');
        } elseif ($detalles->count() >= 1) {
            $detalleorden = DB::table('tb_detalle_orden')
                ->where('id_do', '=', $id)
                ->delete();

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
            $orden->update();
            //dd($orden);

        }

        Session::flash('message', "El detalle de la Orden '" . $detalle->Descripcion . "' se elimino correctamente.");
        return Redirect::to('ventas/ordenes/' . $detalle->id_tb_ordenes);
    }

    public function cambiarFechaEntrega(EditarDetalleOrdenFormRequest $request, $id)
    {
        dd("hola");
    }
}
