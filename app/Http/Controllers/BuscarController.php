<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ordenes;
use App\Persona;
use App\Proceso;
use DB;
class BuscarController extends Controller
{
    public function index(Request $request)
    {
        if ($request) {
            $id    = trim($request->get('searchText'));
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
            $respuesta = $respuesta->y . 'a��� ' .$respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';
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
        ->select('do.id_tb_descripcion_servicios', 'do.Cantidad', 'do.Valor_Unitario', 'do.Descripcion', 'ds.Productos', 'ser.Servicio')
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

    return view("ventas.ordenes.show", ["artefinalista" => $artefinalista, "impresor" => $impresor, "disenador" => $disenador, "orden" => $orden, "cliente" => $cliente, "detalleorden" => $detalleorden, "agente" => $agente, "procesos1" => $procesos1]);
        }
}
}
