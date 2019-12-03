<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('personal/empleados', 'TipoEmpleadoController');
    Route::resource('personal/empleado', 'EmpleadoController');

    Route::resource('departamento/departamentos', 'DepartamentosController');
    Route::resource('departamento/servicios', 'ServiciosController');
    Route::resource('departamento/productos', 'ProductosController');
    Route::resource('departamento/procesos', 'DescripcionProcesosController');
});

Route::group(['middleware' => 'auth'], function () {

    Route::resource('ventas/cliente', 'ClienteController');
    Route::resource('ventas/detalleorden', 'DetalleOrdenController');
    Route::resource('ventas/ordenes', 'OrdenesController');
    Route::resource('ventas/procesos', 'ProcesosController');
    Route::get('ventas/procesos/dp/{id}', 'ProcesosController@getDescripcionProcesos');
    Route::get('ventas/procesos/pro/{id}', 'ProcesosController@getProcesos');
    Route::get('ventas/ordenes/ds/{id}', 'OrdenesController@getDescripcionServicios');
    Route::get('ventas/ordenes/bcli/{id}', 'OrdenesController@getClientes');
    Route::get('ventas/ordenes/borrar/{id}', 'OrdenesController@borrarorden');
    Route::get('ventas/ordenes/borrardetalle/{id}', 'OrdenesController@borrardetalle');

    Route::resource('buscarorden', 'BuscarController');
    Route::resource('cambiarproceso', 'CambiarProcesoController');

    Route::resource('reportes/ordenes1', 'ReportesController');
    Route::get('reportes/entrega', 'ReportesController@getenEntrega');
    Route::get('reportes/facturados', 'ReportesController@getFacturados');



    Route::get('personal/empleado/tm/{id}', 'EmpleadoController@getTipoEmpleado');

    Route::get('reportec/{id}', 'ImprimirController@reportec');

    Route::post('enviarmail', 'EnviarEmailController@EnviarOrdenPorEmail');

    //Route::post('ventas/ordenes/bcliS2', 'OrdenesController@getClientesS2');

    //    Route::get('/link1', function ()    {
    //        // Uses Auth Middleware
    //    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});


Route::get('/home', 'HomeController@index')->name('home');
