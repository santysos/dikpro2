<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getenEntrega(Request $request)
    {

        function formatofecha($fecha)
        {
            if ($fecha != null) {
                setlocale(LC_TIME, "es_ES.UTF-8");

                return $fec = strftime("%a, %d %b %Y - %H:%M%p", strtotime($fecha));
            } else {
                return null;
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
            } elseif ($respuesta->y == 1) {
                $respuesta = $respuesta->y . 'año ' . $respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';

                return $respuesta;
            }
            return $respuesta;
        }



        if ($request) {
            $f1 = new Carbon($request->get('s1'));
            $f2 = new Carbon($request->get('s2'));


            $f2->addHours(23);
            $f2->addMinutes(59);

            $enentrega = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.asignado')
                ->join('users as usr', 'usr.id', '=', 'pro.asignador')
                ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
                ->join('tb_ordenes as ord', 'ord.id_tb_ordenes', '=', 'pro.tb_ordenes_id_tb_ordenes')
                ->join('tb_cliente as cli', 'ord.id_tb_cliente', '=', 'cli.id_tb_cliente')
                ->select('cli.Cliente_Nombre_Comercial', 'cli.Contacto_Razon_Social', 'pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'ord.Fecha_de_Entrega')
                ->where('pro.id_tb_descripcion_procesos', '=', '9')
                ->where('pro.condicion', '=', '1')
                ->whereBetween('pro.tb_fecha_hora', [$f1, $f2])
                ->orwhere('pro.id_tb_descripcion_procesos', '=', '16')
                ->where('pro.condicion', '=', '1')
                ->whereBetween('pro.tb_fecha_hora', [$f1, $f2])
                ->orderBy('pro.tb_fecha_hora', 'desc')
                ->get();

            $ordenes = DB::table('tb_ordenes as ord')
                ->join('tb_cliente as cli', 'cli.id_tb_cliente', '=', 'ord.id_tb_cliente')
                ->join('users as user', 'user.id', '=', 'ord.agente')
                ->join('tb_procesos as pro', 'pro.tb_ordenes_id_tb_ordenes', '=', 'ord.id_tb_ordenes')
                ->join('tb_descripcion_procesos as despro', 'despro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
                ->select('ord.id_tb_ordenes', 'ord.Fecha_de_Inicio', 'ord.Total_Venta', 'ord.Abono', 'user.name', 'despro.descripcion_procesos', 'pro.num_factura', 'cli.Cliente_Nombre_Comercial')
                ->where('ord.condicion', '=', '1')
                ->where('pro.condicion', '=', '1')
                ->whereBetween('ord.Fecha_de_Inicio', [$f1, $f2])
                ->get();

            // dd($enentrega);
            $cont_ordenes = $ordenes->count();
            $enentrega->count = 0;
            $cont_a_tiempo = 0;
            $eficiencia = 0;
            $retraso          = date("Y-m-d H:i:s"); //se instancia la fecha y la hora actual

            foreach ($enentrega as $key) {

                if ($key->Fecha_de_Entrega < $key->tb_fecha_hora) //compara la fecha de entrega con la fecha del cambio de proceso EN ENTREGA
                {

                    $key->retraso = diferenciafecha($key->Fecha_de_Entrega, $key->tb_fecha_hora); // calculo la diferencia del tiempo del tiempo actual con el tiempo de la orden
                } else {
                    $key->retraso = "A tiempo";
                    $cont_a_tiempo++;
                }


                $key->tb_fecha_hora = formatofecha($key->tb_fecha_hora); //Se asigna el formato humano a la fecha
                $enentrega->count++;
            }
            if ($cont_ordenes > 0)
                $eficiencia = number_format((($cont_a_tiempo / $cont_ordenes) * 100), 2);


            // dd($enentrega, $retraso);

            return view('reportes.entrega.index', ["ordenes" => $ordenes, "cont_ordenes" => $cont_ordenes, "enentrega" => $enentrega, "eficiencia" => $eficiencia, "cont_a_tiempo" => $cont_a_tiempo, "f1" => $f1, "f2" => $f2]);
        }
    }





    public function getFacturados(Request $request)
    {
        function formatofecha($fecha)
        {
            if ($fecha != null) {
                setlocale(LC_TIME, "es_ES.UTF-8");

                return $fec = strftime("%a, %d %b %Y - %H:%M%p", strtotime($fecha));
            } else {
                return null;
            }
        }

        if ($request) {
            $query    = trim($request->get('searchText'));
            $facturados = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.asignado')
                ->join('users as usr', 'usr.id', '=', 'pro.asignador')
                ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
                ->select('pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'pro.num_factura')
                ->where('pro.id_tb_descripcion_procesos', '=', '18') // 18 es el id del proceso FACTURADO
                ->where('pro.condicion', '=', '1')
                ->where('pro.tb_ordenes_id_tb_ordenes', 'LIKE', '%' . $query . '%')
                ->orderBy('pro.tb_fecha_hora', 'desc')
                ->paginate(30);

            //dd($enentrega->tb_fecha_hora);//

            $facturados->count = 0;

            foreach ($facturados as $key) {
                $key->tb_fecha_hora = formatofecha($key->tb_fecha_hora);
                $facturados->count++;
            }
            // dd($enentrega);

            return view('reportes.facturados.index', ["facturados" => $facturados, "searchText" => $query]);
        }
    }

    public function index(Request $request)
    {
        function formatofecha($fecha)
        {
            if ($fecha != null) {
                setlocale(LC_TIME, "es_ES.UTF-8");

                return $fec = strftime("%a, %d %b %Y - %H:%M%p", strtotime($fecha));
            } else {
                return null;
            }
        }

        if ($request) {

            $f1 = new Carbon($request->get('s1'));
            $f2 = new Carbon($request->get('s2'));

            //$f1 = '2017-06-01';
            // $f2 = '2017-08-31';

            $f2->addHours(23);
            $f2->addMinutes(59);

            $ordenes = DB::table('tb_ordenes as ord')
                ->join('tb_cliente as cli', 'cli.id_tb_cliente', '=', 'ord.id_tb_cliente')
                ->join('users as user', 'user.id', '=', 'ord.agente')
                ->join('tb_procesos as pro', 'pro.tb_ordenes_id_tb_ordenes', '=', 'ord.id_tb_ordenes')
                ->join('tb_descripcion_procesos as despro', 'despro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
                ->select('ord.id_tb_ordenes', 'ord.Fecha_de_Inicio', 'ord.Total_Venta', 'ord.Abono', 'user.name', 'despro.descripcion_procesos', 'pro.num_factura', 'cli.Cliente_Nombre_Comercial')
                ->where('ord.condicion', '=', '1')
                ->where('pro.condicion', '=', '1')
                ->whereBetween('ord.Fecha_de_Inicio', [$f1, $f2])
                ->get();

            $ordenes->contordenes   = 0;
            $ordenes->sumatotal     = 0;
            $ordenes->abonos        = 0;
            $ordenes->contsinabonos = 0;

            foreach ($ordenes as $key) {

                $ordenes->contordenes++; //cuenta el numero de ordenes

                $key->Fecha_de_Inicio = formatofecha($key->Fecha_de_Inicio); //cambia el formato de fecha a humano

                $ordenes->sumatotal += $key->Total_Venta; //suma el total de ventas

                $key->Total_Venta = number_format((round($key->Total_Venta * (1.12), 2)), 2, '.', ','); //se multiplica por el 12%iva y se da formato el numero



                if ($key->Abono >= 1) { //comprueba el abono mayor que 1
                    $ordenes->abonos += $key->Abono; //suma el total de abonos recibidos
                }

                if ($key->Abono <= 1) { //comprueba los abonos menores de un dolar
                    $ordenes->contsinabonos++; //contador de ordenes sin abonos
                }
            }
            $ordenes->sumatotal = number_format((round($ordenes->sumatotal * (1.12), 2)), 2, '.', ','); //se agrega el iva 12%
            // dd($ordenes);

            return view('reportes.ordenes1.index', ["ordenes" => $ordenes, "f1" => $f1, "f2" => $f2]);
        }
    }
}
