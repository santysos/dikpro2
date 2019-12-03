@extends('adminlte::page')

@section('title', 'Listado de Clientes| Clientes')

@section('content_header')
    <h1>Listado de clientes</h1>
@stop

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="panel">
        <div class="panel-body">
            <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                    <h4>
                        <a href="cliente/create">
                            <button class="btn btn-sm btn-success">
                                Nuevo
                            </button>
                        </a>
                    </h4>
                </div>
            </div>
            <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <h4 align="text-center">
                        @include('ventas.cliente.search')
                    </h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if(Session::has('message'))
                <p class="alert alert-info">
                    {{Session::get('message')}}
                </p>
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="example">
                        <thead>
                            <th>
                                Id
                            </th>
                            <th>
                                Nombre Comercial
                            </th>
                            <th>
                                Razón Social
                            </th>
                            <th>
                                Ced/Ruc
                            </th>
                            <th>
                                Dirección
                            </th>
                            <th>
                                Telefono
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($personas as $cat)
                        <tr>
                            @if($cat->condicion==1)
                            <td>
                                {{ $cat->id_tb_cliente}}
                            </td>
                            <td>
                                {{ $cat->Cliente_Nombre_Comercial}}
                            </td>
                            <td>
                                {{ $cat->Contacto_Razon_Social}}
                            </td>
                            <td>
                                {{ $cat->Cedula_Ruc}}
                            </td>
                            <td>
                                {{ $cat->Direccion}}
                            </td>
                            <td>
                                {{ $cat->Telefono}}
                            </td>
                            <td>
                                @include('ventas.cliente.delete')
                            </td>
                            @endif
                        </tr>
                        @include('ventas.cliente.modal')
            @endforeach
                    </table>
                </div>
                {{$personas->appends(Request::only(['searchText']))->render()}}
            </div>
        </div>
    </div>
</div>
</div>
@stop
