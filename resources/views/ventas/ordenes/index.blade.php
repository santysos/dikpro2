@extends('adminlte::page')

@section('title', 'Listado de Ordenes | Ordenes')

@section('content_header')
    <h1>Listado de Ordenes</h1>
@stop

@section('content')
<div class="container-fluid">

<div class="row">
    <div class="panel">
        <div class="panel-body">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                   
                        <a href="ordenes/create">
                            <button class="btn btn-success btn-sm">
                                Nuevo
                            </button>
                        </a>
                 
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                   
                        @include('ventas.ordenes.search')
              
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
                                # Orden
                            </th>
                            <th>
                                Cliente
                            </th>
                            <th>
                                Fecha Creación
                            </th>
                            <th>
                                Fecha Entrega
                            </th>
                            <th>
                                Agente
                            </th>
                            <th>
                                Total
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($ordenes as $cat)
                        <tr>
                            <td>
                                {{ $cat->id_tb_ordenes}}
                            </td>
                            <td>
                                {{ $cat->Cliente_Nombre_Comercial}}
                            </td>
                            <td>
                                {{ $cat->Fecha_de_Inicio}}
                            </td>
                            <td>
                                {{ $cat->Fecha_de_Entrega}}
                            </td>
                            <td>
                                {{ $cat->agente}}
                            </td>
                            <td>
                                {{ $cat->Total_Venta}}
                            </td>
                            <td>
                                <a href="{{URL::action('OrdenesController@show',$cat->id_tb_ordenes)}}">
                                    <button class="btn btn-primary btn-xs" type="button">
                                        <span aria-hidden="true" class="glyphicon glyphicon-list-alt">
                                        </span>
                                    </button>
                                </a>
                                <a href="{{URL::action('ImprimirController@reportec',$cat->id_tb_ordenes)}}" target="_blank">
                                    <button class="btn btn-success btn-xs" type="button">
                                        <span aria-hidden="true" class="glyphicon glyphicon-print">
                                        </span>
                                    </button>
                                </a>
                                @if((Auth::user()->id)==1||(Auth::user()->id)==3)
                                <a href="{{URL::action('OrdenesController@borrarorden',$cat->id_tb_ordenes)}}">
                                    <button class="btn btn-danger btn-xs" onclick="return confirm('Seguro que desea Eliminar?')" type="submit">
                                        <span aria-hidden="true" class="glyphicon glyphicon-trash">
                                        </span>
                                    </button>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                {{$ordenes->appends(Request::only(['searchText']))->render()}}
            </div>
        </div>
    </div>


</div>
</div>
@stop
