<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\EditarClienteFormRequest;
use App\Http\Requests\PersonaFormRequest;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query    = trim($request->get('searchText'));
            $personas = DB::table('tb_cliente')
                
                ->orwhere('Cliente_Nombre_Comercial', 'LIKE', '%' . $query . '%')
                ->orwhere('Contacto_Razon_Social', 'LIKE', '%' . $query . '%')
                ->orwhere('Cedula_Ruc', 'LIKE', '%' . $query . '%')
                ->where('condicion', '=', '1')
->orderBy('id_tb_cliente', 'desc')
                ->paginate(50);

            //return Datatables::of(DB::table('tb_cliente'))->make(true);

            return view('ventas.cliente.index', ["personas" => $personas, "searchText" => $query]);
        }

    }

    public function create()
    {
        return view("ventas.cliente.create");
    }

    public function store(PersonaFormRequest $request)
    {
        $persona                           = new Persona;
        $persona->id_tb_cliente            = $request->get('id_tb_cliente');
        $persona->Cliente_Nombre_Comercial = $request->get('Cliente_Nombre_Comercial');
        $persona->Contacto_Razon_Social    = $request->get('Contacto_Razon_Social');
        $persona->Direccion                = $request->get('Direccion');
        $persona->Ciudad                   = $request->get('Ciudad');
        $persona->Telefono                 = $request->get('Telefono');
        $persona->Email                    = $request->get('Email');
        $persona->Cedula_Ruc               = $request->get('Cedula_Ruc');
        $persona->save();

        Session::flash('message', "El cliente " . $persona->Cliente_Nombre_Comercial . " - " . $persona->Contacto_Razon_Social . " se creo correctamente");

        return Redirect::to('ventas/cliente');

    }

    public function show($id)
    {
        return view("ventas.cliente.show", ["persona" => Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("ventas.cliente.edit", ["persona" => Persona::findOrFail($id)]);
    }

    public function update(EditarClienteFormRequest $request, $id)
    {
        $persona                           = Persona::findOrFail($id);
        $persona->id_tb_cliente            = $request->get('id_tb_cliente');
        $persona->Cliente_Nombre_Comercial = $request->get('Cliente_Nombre_Comercial');
        $persona->Contacto_Razon_Social    = $request->get('Contacto_Razon_Social');
        $persona->Direccion                = $request->get('Direccion');
        $persona->Ciudad                   = $request->get('Ciudad');
        $persona->Telefono                 = $request->get('Telefono');
        $persona->Email                    = $request->get('Email');
        $persona->Cedula_Ruc               = $request->get('Cedula_Ruc');
        $persona->update();

        Session::flash('message', "Los Datos de " . $persona->Cliente_Nombre_Comercial . " - " . $persona->Contacto_Razon_Social . " se editaron correctamente");

        return Redirect::to('ventas/cliente');

    }

    public function destroy($id)
    {
        $persona            = Persona::findOrFail($id);
        $persona->condicion = '0';
        $persona->update();

        Session::flash('message', "El cliente " . $persona->Cliente_Nombre_Comercial . " fue Eliminado");

        return Redirect::to('ventas/cliente');

    }
}
