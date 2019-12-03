<?php

namespace App\Http\Controllers;

use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            } elseif ($respuesta->y >= 1) {
                $respuesta = $respuesta->y . 'añ ' .$respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';
                return $respuesta;
            }
            return $respuesta;
        }

        $procesos = DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.asignador')
            ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
            ->join('tb_ordenes as ord','ord.id_tb_ordenes','=','pro.tb_ordenes_id_tb_ordenes')
            ->select('pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dpro.id_tb_descripcion_procesos', 'pro.condicion')
            ->where('pro.id_tb_descripcion_procesos', '!=', '18') //no selecciono los facturados
            ->where('pro.id_tb_descripcion_procesos', '!=', '16') //no selecciono los facturados
            ->where('pro.id_tb_descripcion_procesos', '!=', '9') //no selecciono los facturados
            ->where('ord.condicion', '=', '1')
            ->where('pro.condicion', '=', '1')
            ->orderby('pro.tb_fecha_hora', 'asc')
            ->get();

        $procesos->count             = 0;
        $procesos->ingresoventas     = 0;
        $procesos->sri               = 0;
        $procesos->quito             = 0;
        $procesos->disenador         = 0;
        $procesos->disenado          = 0;
        $procesos->ingresodiseno     = 0;
        $procesos->ingresoproduccion = 0;
        $procesos->impresion         = 0;
        $procesos->acabados          = 0;

        $retraso = date("Y-m-d H:i:s"); //se instancia la fecha y la hora actual

        foreach ($procesos as $key) {

            if ($key->id_tb_descripcion_procesos == 1) {
                $procesos->ingresoventas++;
            } else if ($key->id_tb_descripcion_procesos == 3) {
                $procesos->sri++;
            } else if ($key->id_tb_descripcion_procesos == 7) {
                $procesos->quito++;
            } else if ($key->id_tb_descripcion_procesos == 5) {
                $procesos->disenador++;
            } else if ($key->id_tb_descripcion_procesos == 6) {
                $procesos->disenado++;
            } else if ($key->id_tb_descripcion_procesos == 2) {
                $procesos->ingresodiseno++;
            } else if ($key->id_tb_descripcion_procesos == 8) {
                $procesos->ingresoproduccion++;
            } else if ($key->id_tb_descripcion_procesos == 14) {
                $procesos->impresion++;
            } else if ($key->id_tb_descripcion_procesos == 15) {
                $procesos->acabados++;
            }

            $key->retraso = diferenciafecha($retraso, $key->tb_fecha_hora); //se obtiene la diferencia de fechas para calcular el retraso

            $key->tb_fecha_hora = formatofecha($key->tb_fecha_hora); //formato para humano fechas
            $procesos->count++;

        }

        
         //dd($procesos);

        return view("home", ["procesos" => $procesos]);
    }
}
