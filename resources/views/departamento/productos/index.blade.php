@extends('adminlte::page')

@section('title', 'Productos | Configuración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<head>
    <title>
        Page Title
    </title>
</head>
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                    <h4>
                        Productos --
                        <a href="productos/create">
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
                        @include('departamento.productos.search')
                    </h4>
                </div>
            </div>
            <hr>
            </hr>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if(Session::has('message'))
                <p class="alert alert-info">
                    {{Session::get('message')}}
                </p>
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <th>
                                Id
                            </th>
                            <th>
                                Servicios
                            </th>
                            <th>
                                Productos
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($producto as $cat)
                        <tr>
                            <td>
                                {{ $cat->id_tb_descripcion_servicios}}
                            </td>
                            <td>
                                {{ $cat->Servicio}}
                            </td>
                            <td>
                                {{ $cat->Productos}}
                            </td>
                            <td>
                                @include('departamento.productos.delete')
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                {{$producto->render()}}
            </div>
        </div>
    </div>
</div>
@stop
