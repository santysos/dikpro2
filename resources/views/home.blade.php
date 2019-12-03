@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue">
                <i class="fa fa-cogs">
                </i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">
                    Ordenes en proceso
                </span>
                <span class="info-box-number">
                    {{$procesos->count}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">
                <i class="fa fa-shopping-cart">
                </i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">
                    Ventas
                </span>
                <span class="info-box-number">
                    {{$procesos->ingresoventas+$procesos->sri+$procesos->quito}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="fab fa-optin-monster">
                </i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">
                    Diseño
                </span>
                <span class="info-box-number">
                    {{$procesos->disenador+$procesos->disenado+$procesos->ingresodiseno}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow">
                <i class="fa fa-print">
                </i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">
                    Produccion
                </span>
                <span class="info-box-number">
                    {{$procesos->ingresoproduccion+$procesos->impresion+$procesos->acabados }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="callout callout-info">
            Ventas
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ingreso En Ventas
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->ingresoventas}} Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->ingresoventas}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 1)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Esperando Autorizacion SRI
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->sri}} Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->sri}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 3)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ordenes enviadas a Quito
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->quito}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->quito}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 7)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
    <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
    <div class="col-md-6">
        <div class="callout callout-success">
            Diseño
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ordenes Sin Asignar Diseñador
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->ingresodiseno}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->ingresodiseno}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 2)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Diseño en Proceso
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->disenador}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->disenador}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 5)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Diseñadas en espera de Aprobación
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->disenado}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->disenado}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 6)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
    <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
    <div class="col-md-6">
        <div class="callout callout-warning">
            Producción
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ingreso a Producción
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->ingresoproduccion}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->ingresoproduccion}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 8)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    En Proceso de Impresión
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->impresion}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->impresion}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 14)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ordenes en Acabados Finales
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->acabados}} Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->acabados}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                    @if($pro->id_tb_descripcion_procesos == 15)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_id_tb_ordenes)}}" target="_blank">
                                        {{$pro->tb_ordenes_id_tb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->tb_fecha_hora}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
</div>
@stop