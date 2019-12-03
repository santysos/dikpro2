@extends('adminlte::page')

@section('title', 'Listado de Usuarios | Acceso')

@section('content_header')
    <h1> Lista de Usuarios</h1>
@stop

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="panel">
        <div class="panel-body">
            <div class="col-lg-12 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                    <h4>
                       
                        <a href="empleado/create">
                            <button class="btn btn-sm btn-success">
                                Nuevo
                            </button>
                        </a>
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
                                Nombre
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Tipo Empleado
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($empleado as $cat)
                        <tr>
                            @if($cat->condicion==1)
                            <td>
                                {{ $cat->id}}
                            </td>
                            <td>
                                {{ $cat->name}}
                            </td>
                            <td>
                                {{ $cat->email}}
                            </td>
                            <td>
                                {{ $cat->tipo_empleados}}
                            </td>
                            <td>
                                @if($cat->id!= 1)
                        @include('personal.empleado.delete')
                        @endif
                            </td>
                            @endif
                        </tr>
                        @include('personal.empleado.modal')
                        @endforeach
                    </table>
                </div>
                  {{$empleado->render()}}
            </div>
        </div>
    </div>
</div>
</div>
@stop



