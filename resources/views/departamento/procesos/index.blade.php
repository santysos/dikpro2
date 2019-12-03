@extends('adminlte::page')

@section('title', 'Procesos | Configuración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                    <h4>
                        Listado de Procesos --
                        <a href="procesos/create">
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
                        @include('departamento.procesos.search')
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
                                Departamento
                            </th>
                            <th>
                                Procesos
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($proceso as $cat)
                        <tr>
                            <td>
                                {{ $cat->id_tb_descripcion_procesos}}
                            </td>
                            <td>
                                {{ $cat->departamentos}}
                            </td>
                            <td>
                                {{ $cat->descripcion_procesos}}
                            </td>
                            <td>
                                @include('departamento.procesos.delete')
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                {{$proceso->render()}}
            </div>
        </div>
    </div>
</div>
@stop

