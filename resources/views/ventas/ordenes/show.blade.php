@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')

@stop

@section('content')
<div class="container-fluid">
<div class="row">
     
    @if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>
                {{$error}}
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    @foreach ($procesos1 as $pro) @endforeach
    <div class="panel">
        <div class="panel-body">
            <div class="callout callout-success col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Orden # {{$orden->id_tb_ordenes}} - {{$pro->descripcion_procesos}} - {{$pro->num_factura}}
            </div>   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @if(Session::has('message'))
                    <p class="alert alert-warning">
                        {{Session::get('message')}}
                    </p>
                    @endif
                </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <pre><label><b>Cliente:</b></label>    {!!Form::label('',"   ".$cliente->Cliente_Nombre_Comercial)!!}<br/><label><b>Contacto:</b></label>      {!!Form::label('',$cliente->Contacto_Razon_Social)!!}<br/><label><b>Cedula/Ruc:</b></label>    {!!Form::label('',$cliente->Cedula_Ruc)!!}</pre>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <pre><label><b>Email:</b></label>         <a>{!!Form::label('',$cliente->Email )!!}</a><br/><label><b>Codigo:</b></label>        {!!Form::label('',$cliente->id_tb_cliente)!!}<br/><label><b>Dirección:</b></label>     {!!Form::label('',$cliente->Direccion)!!}</pre>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="box box-solid box-info" data-widget="box-widget">
                    <div class="box-header centrar-texto" id="FInicio">
                        Inicio: {{$orden->Fecha_de_Inicio}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="box box-solid box-info" data-widget="box-widget">
                    <div class="box-header centrar-texto" id="FDiseno">
                        Rev Diseño:   {{$orden->Revision_de_Diseno}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="box box-solid box-info" data-widget="box-widget">
                    <div class="box-header centrar-texto" id="FEntrega">
                        Entrega: {{$orden->Fecha_de_Entrega}}
                        @if((Auth::user()->id)==1||(Auth::user()->id)==3)
                        <a href="" data-target="#modalcambiarfechaentrega" data-toggle="modal">
                                <button type="button" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                </button>
                        </a> 
                        @endif
                       
                    </div>

                </div>
            
            </div> @include('ventas.ordenes.modalcambiarfechaentrega')
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover ">
                        <thead style="background-color: #A9D0F5">
                            <td>
                                Cant.
                            </td>
                            <td>
                                Servicios
                            </td>
                            <td>
                                Productos
                            </td>
                            <td>
                                Descripcion
                            </td>
                            <td>
                                Valor Unitario
                            </td>
                            <td>
                                Sub Total
                            </td>
                            <td>Editar
                                    @if((Auth::user()->id)==1||(Auth::user()->id)==3)                              
                            <a href="" data-target="#modalagregardetalle" data-toggle="modal">
                                    <button type="button" class="btn btn-warning btn-xs">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                            </a>    
                            @endif
                                @include('ventas.ordenes.modalagregardetalle')
                            </td>
                        </thead>
                        @foreach ($detalleorden as $cat)
                        <tr>
                            <td>
                                {{$cat->Cantidad}}
                            </td>
                            <td>
                                {{$cat->Servicio}}
                            </td>
                            <td>
                                {{$cat->Productos}}
                            </td>
                            <td>
                                {{$cat->Descripcion}}
                            </td>
                            <td>
                                $  {{$cat->Valor_Unitario}}
                            </td>
                            <td>
                                $  {{number_format($cat->Valor_Unitario*$cat->Cantidad,2)}}
                            </td>
                            <td >
                                    @if((Auth::user()->id)==1||(Auth::user()->id)==3)
                            
                                    @include('ventas.ordenes.modalborrarorden')
                                
                                    @endif 
                            </td>
                        </tr>
                        @include('ventas.ordenes.modaleditarorden')
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover ">
                        <thead>
                            <td width="20%">
                                <b>
                                    Subtotal:
                                </b>
                                $ {{number_format($orden->Total_Venta,2)}}
                            </td>
                            <td width="20%">
                                <b>
                                    Iva:
                                </b>
                                $ {{number_format($orden->Total_Venta*0.12,2)}}
                            </td>
                            <td width="20%">
                                <b>
                                    Valor Total:
                                </b>
                                $ {{number_format($orden->Total_Venta+($orden->Total_Venta*0.12),2)}}
                            </td>
                            <td width="20%">
                                <b>
                                    Abono:
                                </b>
                                $ {{$orden->Abono}}
                            </td>
                            <td width="20%">
                                <b>
                                    Saldo:
                                </b>
                                $ {{number_format($orden->Total_Venta+($orden->Total_Venta*0.12)-$orden->Abono,2)}}
                            </td>
                        </thead>
                    </table>
                </div>
            </div>
           
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box box-solid box-info" data-widget="box-widget">
                    <div class="box-header">
                        {{$orden->Observaciones}}
                        <h3 class="box-title">
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h4>
                            {{$agente->asignado}}
                        </h4>
                        <p>
                            {{$agente->finicio}}
                        </p>
                        <h4>
                            {{$agente->calculofechas}}
                        </h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart">
                        </i>
                    </div>
                    <a class="small-box-footer">
                        Agente Vendedor
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h4>
                            {{$disenador->asignado}}
                        </h4>
                        <p>
                            {{$disenador->finicio}}
                        </p>
                        <h4>
                            {{$disenador->calculofechas}}
                        </h4>
                    </div>
                    <div class="icon">
                        <i class="fab fa-optin-monster">
                        </i>
                    </div>
                    <a class="small-box-footer">
                        Diseñador
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h4>
                            {{$impresor->asignado}}
                        </h4>
                        <p>
                            {{$impresor->finicio}}
                        </p>
                        <h4>
                            {{$impresor->calculofechas}}
                        </h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-print">
                        </i>
                    </div>
                    <a class="small-box-footer">
                        Impresor
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h4>
                            {{$artefinalista->asignado}}
                        </h4>
                        <p>
                            {{$artefinalista->finicio}}
                        </p>
                        <h4>
                            {{$artefinalista->calculofechas}}
                        </h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-puzzle-piece">
                        </i>
                    </div>
                    <a class="small-box-footer">
                        Arte Finalista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.min.css')}}">
@stop

@section('js')
<script src="{{ asset('/js/moment-with-locales.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/selectdinamico.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript">
</script>
<script>
    function titulo(){      
    document.title = 'Orden # '+{{$orden->id_tb_ordenes}}+' | Ordenes'; }
titulo();

$('#Fecha_de_Entrega').datetimepicker({

daysOfWeekDisabled: [0, 7],
inline: true,
sideBySide: true,
locale: 'es',
format: 'YYYY-MM-DD HH:mm'
});
</script>
@stop


