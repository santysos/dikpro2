<?php

namespace App\Http\Controllers;

use DB;
use App\Departamentos;
use App\Http\Requests\TipoEmpleadoFormRequest;
use App\TipoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TipoEmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $tipo_empleado = DB::table('tb_tipo_empleados as te')
                ->join('tb_departamentos as dep', 'te.id_tb_departamentos', '=', 'dep.id_tb_departamentos')
                ->where('te.condicion', '=', '1')
                ->get();

            return view('personal.empleados.index', ["tipo_empleado" => $tipo_empleado, "searchText" => $query]);
        }

    }

    public function create()
    {
        $departamentos = Departamentos::where('condicion', '=', '1')->pluck('Departamentos', 'id_tb_departamentos');

        return view('personal.empleados.create', ["departamentos" => $departamentos]);
    }

    public function store(TipoEmpleadoFormRequest $request)
    {
        $tipo_empleado                      = new TipoEmpleado;
        $tipo_empleado->id_tb_departamentos = $request->get('departamentos');
        $tipo_empleado->tipo_empleados      = $request->get('tipo_empleado');
        $tipo_empleado->save();

        Session::flash('message', "El tipo de empleado " . $tipo_empleado->tipo_empleados . " fue creado Satisfactoriamente");

        return Redirect::to('personal/empleados');
    }

    public function show($id)
    {
        return view("personal.empleados.show", ["tipo_empleado" => TipoEmpleado::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("personal.empleados.edit", ["tipo_empleado" => TipoEmpleado::findOrFail($id)]);
    }

    public function update(TipoEmpleadoFormRequest $request, $id)
    {
        $tipo_empleado                 = TipoEmpleado::findOrFail($id);
        $tipo_empleado->tipo_empleados = $request->get('tipo_empleado');
        $tipo_empleado->update();

        Session::flash('message', "El nombre del tipo de empleado " . $tipo_empleado->tipo_empleados . " fue Editado");

        return Redirect::to('personal/empleados');

    }

    public function destroy($id)
    {
        $tipo_empleado            = TipoEmpleado::findOrFail($id);
        $tipo_empleado->condicion = '0';
        $tipo_empleado->update();

        Session::flash('message', "El tipo de empleado " . $tipo_empleado->tipo_empleados . " fue Eliminado");

        return Redirect::to('personal/empleados');

    }
}
