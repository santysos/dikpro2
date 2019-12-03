<?php

namespace App\Http\Controllers;
use DB;
use App\DescripcionProcesos;
use App\User;
use Illuminate\Http\Request;


class CambiarProcesoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $id    = trim($request->get('searchText'));
        $procesos = DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.asignador')
            ->join('tb_ordenes as ord', 'ord.id_tb_ordenes', '=', 'pro.tb_ordenes_id_tb_ordenes')
            ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
            ->join('tb_departamentos as dep', 'dep.id_tb_departamentos', '=', 'dpro.id_tb_departamentos')
            ->select('pro.id_tb_procesos', 'pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dep.departamentos', 'dep.id_tb_departamentos', 'pro.num_factura')
            ->where('pro.tb_ordenes_id_tb_ordenes', '=', $id)
            ->where('ord.condicion', '=', '1')
            ->orderby('pro.tb_fecha_hora', 'asc')
            ->get();

        //selecciona el proceso en donde se encuentra la orden
        $procesos1 = DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.asignador')
            ->join('tb_ordenes as ord', 'ord.id_tb_ordenes', '=', 'pro.tb_ordenes_id_tb_ordenes')
            ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
            ->select('pro.id_tb_procesos', 'pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dpro.id_tb_descripcion_procesos', 'pro.num_factura')
            ->where('pro.tb_ordenes_id_tb_ordenes', '=', $id)
            ->where('ord.condicion', '=', '1')
            ->where('pro.condicion', '=', '1')
            ->get();

     //  dd($procesos1);

        $listadoprocesos = DescripcionProcesos::where('condicion', '=', '1')->get();

        $usuarios = User::where('condicion', '=', '1')->get();

        return view("ventas.procesos.show", ["procesos1" => $procesos1, "procesos" => $procesos, "listadoprocesos" => $listadoprocesos, "usuarios" => $usuarios]);
    }
}
}
