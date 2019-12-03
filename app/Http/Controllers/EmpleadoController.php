<?php

namespace App\Http\Controllers;

use DB;
use App\Departamentos;
use App\Empleado;
use App\Http\Requests\EditarEmpleadoFormRequest;
use App\Http\Requests\EmpleadoFormRequest;
use App\TipoEmpleado;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $empleado = DB::table('users as us')
                ->join('tb_tipo_empleados as te', 'us.id_tb_tipo_empleados', '=', 'te.id_tb_tipo_empleados')
                ->select('te.tipo_empleados', 'us.name', 'us.email', 'us.id', 'us.condicion')
                ->where('us.name', 'LIKE', '%' . $query . '%')
                ->orderBy('te.id_tb_tipo_empleados', 'asc')
                ->groupBy('te.tipo_empleados', 'us.name', 'us.email', 'us.id', 'us.condicion','te.id_tb_tipo_empleados')
                ->paginate(20);

            return view('personal.empleado.index', ["empleado" => $empleado, "searchText" => $query]);
        }

    }

    public function create()
    {

        $departamentos = Departamentos::where('condicion', '=', '1')->orderby('departamentos', 'asc')->pluck('Departamentos', 'id_tb_departamentos');
        // $tipo_empleados = TipoEmpleado::pluck('tipo_empleados', 'id_tb_tipo_empleados');

        //$tipo_empleados = DB::table('tb_tipo_empleados')->get();

        return view('personal.empleado.create', compact('departamentos'));
    }

    public function store(EmpleadoFormRequest $request)
    {
        $empleado                       = new User;
        $empleado->id_tb_tipo_empleados = $request->get('id_tb_tipo_empleados');
        $empleado->id_tb_departamentos  = $request->get('id_tb_departamentos');
        $empleado->name                 = $request->get('name');
        $empleado->email                = $request->get('email');
        $empleado->password             = bcrypt($request->get('password'));
        $empleado->condicion            = '1';
        $empleado->save();

        Session::flash('message', "El empleado " . $empleado->name . " fue creado satisfactoriamente");

        return Redirect::to('personal/empleado');
    }

    public function show($id)
    {
        return view("personal.empleado.show", ["empleado" => Empleado::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("personal.empleado.edit", ["empleado" => User::findOrFail($id), "tipo_empleados" => TipoEmpleado::pluck('tipo_empleados', 'id_tb_tipo_empleados'), "departamentos" => Departamentos::pluck('departamentos', 'id_tb_departamentos')]);
    }

    public function update(EditarEmpleadoFormRequest $request, $id)
    {
        $empleado                       = User::findOrFail($id);
        $empleado->id_tb_departamentos  = $request->get('id_tb_departamentos');
        $empleado->id_tb_tipo_empleados = $request->get('id_tb_tipo_empleados');
        $empleado->name                 = $request->get('name');
        $empleado->email                = $request->get('email');
        $empleado->password             = bcrypt($request->get('password'));
        $empleado->condicion            = '1';
        $empleado->update();

        Session::flash('message', "El empleado " . $empleado->name . " fue Editado");

        return Redirect::to('personal/empleado');

    }

    public function destroy($id)
    {
        $empleado            = User::findOrFail($id);
        $empleado->condicion = '0';
        $empleado->update();

        Session::flash('message', "El empleado " . $empleado->name . " - " . $empleado->email . " fue Eliminado");

        return Redirect::to('personal/empleado');

    }

    public function getTipoEmpleado(Request $request, $id)
    {
        if ($request->ajax()) {
            $procesos = TipoEmpleado::TipoEmpleados($id);
            return response()->json($procesos);
        }
    }
}
