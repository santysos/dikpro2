<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\ServiciosFormRequest;
use App\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ServiciosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query    = trim($request->get('searchText'));
            $servicio = DB::table('tb_servicios')
                ->select('id_tb_Servicios', 'Servicio')
                ->where('Servicio', 'LIKE', '%' . $query . '%')
                ->where('condicion', '=', '1')
                ->paginate(10);

            return view('departamento.servicios.index', ["servicio" => $servicio, "searchText" => $query]);
        }

    }

    public function create()
    {
        return view('departamento.servicios.create');
    }

    public function store(ServiciosFormRequest $request)
    {
        $servicio           = new Servicios;
        $servicio->Servicio = $request->get('Servicio');
        $servicio->save();

        return Redirect::to('departamento/servicios');
    }

    public function show($id)
    {
        return view("departamento.servicios.show", ["servicio" => Servicios::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("departamento.servicios.edit", ["servicio" => Servicios::findOrFail($id)]);
    }

    public function update(ServiciosFormRequest $request, $id)
    {
        $servicio           = Servicios::findOrFail($id);
        $servicio->Servicio = $request->get('Servicio');
        $servicio->update();

        Session::flash('message', "El nombre del servicio " . $servicio->Servicio . " fue Editado");

        return Redirect::to('departamento/servicios');

    }

    public function destroy($id)
    {

        $servicio            = Servicios::findOrFail($id);
        $servicio->condicion = '0';
        $servicio->update();

        Session::flash('message', "El servicio " . $servicio->Servicio . " fue Eliminado");

        return Redirect::to('departamento/servicios');

    }
}
