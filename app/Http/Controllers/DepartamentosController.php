<?php

namespace App\Http\Controllers;

use DB;
use App\Departamentos;
use App\Http\Requests\DepartamentosFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DepartamentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query        = trim($request->get('searchText'));
            $departamento = DB::table('tb_departamentos')
                ->select('id_tb_departamentos', 'departamentos')
                ->where('departamentos', 'LIKE', '%' . $query . '%')
                ->where('condicion', '=', '1')
                ->paginate(10);

            return view('departamento.departamentos.index', ["departamento" => $departamento, "searchText" => $query]);
        }

    }

    public function create()
    {
        return view("departamento.departamentos.create");
    }

    public function store(DepartamentosFormRequest $request)
    {
        $departamento                = new Departamentos;
        $departamento->departamentos = $request->get('departamento');
        $departamento->save();

        return Redirect::to('departamento/departamentos');
    }

    public function show($id)
    {
        return view("departamento.departamentos.show", ["departamento" => Departamentos::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("departamento.departamentos.edit", ["departamento" => Departamentos::findOrFail($id)]);
    }

    public function update(DepartamentosFormRequest $request, $id)
    {
        $departamento                = Departamentos::findOrFail($id);
        $departamento->departamentos = $request->get('departamento');
        $departamento->update();

        Session::flash('message', "El nombre del servicio " . $departamento->departamentos . " fue Editado");

        return Redirect::to('departamento/departamentos');

    }

    public function destroy($id)
    {
        $departamento            = Departamentos::findOrFail($id);
        $departamento->condicion = '0';
        $departamento->update();

        Session::flash('message', "El servicio " . $departamento->departamentos . " fue Eliminado");

        return Redirect::to('departamento/departamentos');

    }
}
