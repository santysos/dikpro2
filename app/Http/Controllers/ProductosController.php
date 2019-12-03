<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\ProductosFormRequest;
use App\Productos;
use App\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query    = trim($request->get('searchText'));
            $producto = DB::table('tb_descripcion_servicios as pro')
                ->join('tb_servicios as ser', 'pro.id_tb_Servicios', '=', 'ser.id_tb_Servicios')
                ->select('pro.id_tb_descripcion_servicios', 'pro.id_tb_Servicios', 'pro.Productos', 'ser.Servicio', 'ser.id_tb_Servicios')
                ->where('pro.Productos', 'LIKE', '%' . $query . '%')
                ->where('pro.condicion', '=', '1')
                ->paginate(20);

            return view('departamento.productos.index', ["producto" => $producto, "searchText" => $query]);
        }

    }

    public function create()
    {
        $servicios = Servicios::where('condicion', '=', '1')->pluck('Servicio', 'id_tb_Servicios');

        return view('departamento.productos.create', ["servicios" => $servicios]);
    }

    public function store(ProductosFormRequest $request)
    {
        $producto                  = new Productos;
        $producto->id_tb_Servicios = $request->get('id_tb_Servicios');
        $producto->Productos       = $request->get('Productos');
        $producto->save();

        return Redirect::to('departamento/productos');
    }

    public function show($id)
    {
        return view("departamento.productos.show", ["producto" => Productos::findOrFail($id)]);
    }

    public function edit($id)
    {

        $producto = Productos::findOrFail($id);

        $servicio = Servicios::findOrFail($producto->id_tb_Servicios);

        return view("departamento.productos.edit", ["producto" => $producto, "servicio" => $servicio]);
    }

    public function update(ProductosFormRequest $request, $id)
    {
        $producto            = Productos::findOrFail($id);
        $producto->Productos = $request->get('Productos');
        $producto->update();

        Session::flash('message', "El nombre del producto " . $producto->Productos . " fue Editado");

        return Redirect::to('departamento/productos');

    }

    public function destroy($id)
    {

        $producto            = Productos::findOrFail($id);
        $producto->condicion = '0';
        $producto->update();

        Session::flash('message', "El producto " . $producto->Productos . " fue Eliminado");

        return Redirect::to('departamento/productos');

    }
}
