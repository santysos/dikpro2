<?php

namespace App\Http\Controllers;

use DB;
use App\Departamentos;
use App\DescripcionProcesos;
use App\Http\Requests\DescripcionProcesosFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DescripcionProcesosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query   = trim($request->get('searchText'));
            $proceso = DB::table('tb_descripcion_procesos as pro')
                ->join('tb_departamentos as ser', 'pro.id_tb_departamentos', '=', 'ser.id_tb_departamentos')
                ->select('pro.id_tb_descripcion_procesos', 'pro.descripcion_procesos', 'pro.id_tb_departamentos', 'ser.departamentos')
                ->where('pro.condicion', '=', '1')
                ->where('pro.id_tb_departamentos', '!=', '1') //elimina de la busqueda el depoartamento principal
                ->where('pro.descripcion_procesos', 'LIKE', '%' . $query . '%')
                ->where('ser.departamentos', 'LIKE', '%' . $query . '%')
                ->orderBy('ser.departamentos', 'desc')
                ->paginate(25);

            return view('departamento.procesos.index', ["proceso" => $proceso, "searchText" => $query]);
        }

    }

    public function create()
    {
        $departamentos = Departamentos::where('condicion', '=', '1')->where('id_tb_departamentos', '!=', '1')->pluck('Departamentos', 'id_tb_departamentos');

        return view('departamento.procesos.create', ["departamentos" => $departamentos]);
    }

    public function store(DescripcionProcesosFormRequest $request)
    {
        $proceso                       = new DescripcionProcesos;
        $proceso->id_tb_departamentos  = $request->get('id_tb_departamentos');
        $proceso->descripcion_procesos = $request->get('descripcion_procesos');
        $proceso->save();

        return Redirect::to('departamento/procesos');
    }

    public function show($id)
    {
        return view("departamento.procesos.show", ["procesos" => DescripcionProcesos::findOrFail($id)]);
    }

    public function edit($id)
    {

        $proceso = DescripcionProcesos::findOrFail($id);

        $departamento = Departamentos::findOrFail($proceso->id_tb_departamentos);

        return view("departamento.procesos.edit", ["proceso" => $proceso, "departamento" => $departamento]);
    }

    public function update(DescripcionProcesosFormRequest $request, $id)
    {
        $proceso                       = DescripcionProcesos::findOrFail($id);
        $proceso->descripcion_procesos = $request->get('descripcion_procesos');
        $proceso->update();

        Session::flash('message', "El nombre del proceso " . $proceso->descripcion_procesos . " fue Editado");

        return Redirect::to('departamento/procesos');

    }

    public function destroy($id)
    {

        $proceso            = DescripcionProcesos::findOrFail($id);
        $proceso->condicion = '0';
        $proceso->update();

        Session::flash('message', "El proceso " . $proceso->descripcion_procesos . " fue Eliminado");

        return Redirect::to('departamento/procesos');

    }
}
