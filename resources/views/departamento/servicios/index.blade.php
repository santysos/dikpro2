@extends('adminlte::page')

@section('title', 'Servicios | Configuración')

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
                        Servicios --
                        <a href="servicios/create">
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
                        @include('departamento.servicios.search')
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
                    <table class="table table-striped table-bordered table-condensed table-hover" id="example">
                        <thead>
                            <th>
                                Id
                            </th>
                            <th>
                                Servicios
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($servicio as $cat)
                        <tr>
                            <td>
                                {{ $cat->id_tb_Servicios}}
                            </td>
                            <td>
                                {{ $cat->Servicio}}
                            </td>
                            <td>
                                @include('departamento.servicios.delete')
                            </td>
                        </tr>
                        @include('departamento.servicios.modal')
                        @endforeach
                    </table>
                </div>
                {{$servicio->render()}}
            </div>
        </div>
    </div>
</div>
@stop

