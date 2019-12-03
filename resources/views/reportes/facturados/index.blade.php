<link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@extends('adminlte::page')

@section('title', 'Cambio de Procesos | Procesos')

@section('content_header')
    <h1>Ordenes Facturadas</h1>
@stop

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="panel">
        <div class="panel-body">
                <div class="col-lg-9 col-md-3 col-sm-3 col-xs-12">
                    
                </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <h3 align="text-center">
                        @include('reportes.facturados.search')
                    </h3>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="tabla">
                        <thead>
                            <th>
                                # Orden
                            </th>
                            <th>
                                Proceso
                            </th>
                            <th>
                                Fecha Hora
                            </th>
                            <th>
                                Empleado
                            </th>
                            <th>
                                Modificado por
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($facturados as $cat)
                        <tr>
                            <td>
                                <a href="{{URL::action('OrdenesController@show',$cat->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                    {{ $cat->tb_ordenes_id_tb_ordenes}}
                                </a>
                            </td>
                            <td>
                                {{ $cat->descripcion_procesos}} {{ $cat->num_factura}}
                            </td>
                            <td>
                                {{ $cat->tb_fecha_hora}}
                            </td>
                            <td>
                                {{ $cat->asignado}}
                            </td>
                            <td>
                                {{ $cat->asignador}}
                            </td>
                            <td>
                                <a href="{{URL::action('ProcesosController@show',$cat->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                    <button class="btn btn-success btn-xs" type="button">
                                        <span aria-hidden="true" class="glyphicon glyphicon-pencil">
                                        </span>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                 {{$facturados->render()}}
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="{{ asset('/js/moment-with-locales.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/selectdinamico-procesos.js') }}" type="text/javascript">
</script>

</script>
<script type="text/javascript">

$("#norden").keyup(function(e){                      
       consulta = $("#norden").val();
        console.log(consulta);
    });

$('#boton').click(function(){
location.href='procesos/'+consulta;
        });
</script>
@stop

