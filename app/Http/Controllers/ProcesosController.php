<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use App\Departamentos;
use App\DescripcionProcesos;
use App\Http\Requests\ProcesosFormRequest;
use App\Http\Requests\ProductosFormRequest;
use App\Proceso;
use App\Productos;
use App\Servicios;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProcesosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {

            $departamentos = Departamentos::where('condicion', '=', '1')->orderby('departamentos', 'asc')->pluck('Departamentos', 'id_tb_departamentos');

            $enentrega = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.asignado')
                ->join('users as usr', 'usr.id', '=', 'pro.asignador')
                ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
                ->select('pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador')
                ->where('pro.id_tb_descripcion_procesos', '=', '9')
                ->orwhere('pro.id_tb_descripcion_procesos', '=', '16')
                ->where('pro.condicion', '=', '1')
                ->orderBy('pro.tb_fecha_hora', 'desc')
                ->get();

            $enentrega->count = 0;

            foreach ($enentrega as $key) {

                $enentrega->count++;
            }

            // dd($enentrega);

            return view('ventas.procesos.index', ["departamentos" => $departamentos, "enentrega" => $enentrega]);

        }

    }

    public function getDescripcionProcesos(Request $request, $id)
    {
        if ($request->ajax()) {
            $descprocesos = Proceso::despro($id);
            return response()->json($descprocesos);
        }
    }

    public function getProcesos(Request $request, $id)
    {

        if ($request->ajax()) {
            $procesos = Proceso::OrdenProcesoDepartamento($id);
            return response()->json($procesos);
        }
    }

    public function create()
    {
        $servicios = Servicios::where('condicion', '=', '1')->pluck('Servicio', 'id_tb_Servicios');

        return view('ventas.procesos.create', ["servicios" => $servicios]);
    }

    public function store(ProcesosFormRequest $request)
    {

        $proceso                           = new Proceso;
        $mytime                            = Carbon::now('America/Guayaquil');
        $proceso->tb_fecha_hora            = $mytime->toDateTimeString();
        $proceso->tb_ordenes_id_tb_ordenes = $request->get('tb_ordenes_id_tb_ordenes');

        $cont = 0;
        
        $colocar = Proceso::where('tb_ordenes_id_tb_ordenes', '=', $proceso->tb_ordenes_id_tb_ordenes)->get(); //seleciona todos los procesos
      // dd($colocar);

     //   $colocar = Proceso::all(); //seleciona todos los procesos

        foreach ($colocar as $colo) //recorre los procesos
        {
            $nuevo = Proceso::findOrFail($colo->id_tb_procesos); //crea un nuevo Model proceso por cada fila de bdd
            if ($nuevo->tb_ordenes_id_tb_ordenes == $proceso->tb_ordenes_id_tb_ordenes) //comprueba que la nueva fila se igual a la orden a cambiar el proceso
            {
                $nuevo->condicion = 0;
                $nuevo->update();
            }
        }

        $proceso->id_tb_descripcion_procesos = $request->get('id_tb_descripcion_procesos');

        $proceso->asignado    = $request->get('asignado');
        $proceso->asignador   = $request->get('asignador');
        $proceso->num_factura = $request->get('num_factura');

        $proceso->save();

        return Redirect::to('ventas/procesos/' . $proceso->tb_ordenes_id_tb_ordenes);
    }

    public function show($id)
    {

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

        //dd($procesos1);

        $listadoprocesos = DescripcionProcesos::where('condicion', '=', '1')->get();

        $usuarios = User::where('condicion', '=', '1')->get();

        return view("ventas.procesos.show", ["procesos1" => $procesos1, "procesos" => $procesos, "listadoprocesos" => $listadoprocesos, "usuarios" => $usuarios]);
    }

    public function edit($id)
    {

        $producto = Productos::findOrFail($id);

        $servicio = Servicios::findOrFail($producto->id_tb_Servicios);

        return view("ventas.procesos.edit", ["producto" => $producto, "servicio" => $servicio]);
    }

    public function update(ProductosFormRequest $request, $id)
    {
        $producto            = Productos::findOrFail($id);
        $producto->Productos = $request->get('Productos');
        $producto->update();

        Session::flash('message', "El nombre del producto " . $producto->Productos . " fue Editado");

        return Redirect::to('departamento/procesos');

    }

    public function destroy($id)
    {

        $producto            = Productos::findOrFail($id);
        $producto->condicion = '0';
        $producto->update();

        Session::flash('message', "El producto " . $producto->Productos . " fue Eliminado");

        return Redirect::to('departamento/procesos');

    }
}
