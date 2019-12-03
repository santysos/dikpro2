@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@foreach($procesos1 as $proceso)
    <h1>Cambio Proceso  Orden # {{$proceso->tb_ordenes_id_tb_ordenes}}</h1>
    @endforeach
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
  
    {!!Form::open(array('url'=>'ventas/procesos','method'=>'POST','autocomplete'=>'off'))!!}
        {!!Form::token()!!}
    <div class="panel">
        <div class="panel-body">
           
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                @foreach($procesos1 as $proceso)
                <div class="form-group">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h2>
                                Orden # {{$proceso->tb_ordenes_id_tb_ordenes}}
                            </h2>
                            <p id="descripcion_procesos">
                                {{$proceso->descripcion_procesos}}
                            </p>
                            <p>
                                Factura #{{$proceso->num_factura}}
                            </p>
                            <p id="fecha">
                                {{$proceso->tb_fecha_hora}}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart">
                            </i>
                        </div>
                        <a class="small-box-footer">
                            Modificado por: {{$proceso->asignador}}
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="form-group" id="selectores">
                    <select class="form-control" id="id_tb_descripcion_procesos" name="id_tb_descripcion_procesos" onchange="MostrarFact();" required="">
                        <option disabled="" selected="" value="">
                            Enviar Orden a
                        </option>
                        @foreach($listadoprocesos as $listadoproceso)
                            @foreach($procesos1 as $pro)
                                    @if($listadoproceso->id_tb_departamentos== Auth::user()->id_tb_departamentos||Auth::user()->id_tb_departamentos==1)
                                        @if($listadoproceso->id_tb_descripcion_procesos!=$pro->id_tb_descripcion_procesos)
                        <option value="{{$listadoproceso->id_tb_descripcion_procesos}}">
                            {{$listadoproceso->descripcion_procesos}}
                        </option>
                        @endif
                                    @endif
                            @endforeach
                        @endforeach
                    </select>
                </div>
                @if(Auth::user()->id_tb_departamentos!=2)
                <div class="form-group" id="selectores1">
                    <select class="form-control" id="asignado" name="asignado" required="">
                        <option disabled="" selected="" value="">
                            Asignar Empleado
                        </option>
                        @foreach($usuarios as $usuario)
                            @if($usuario->id_tb_departamentos == Auth::user()->id_tb_departamentos||Auth::user()->id_tb_departamentos==1)
                        <option value="{{$usuario->id}}">
                            {{$usuario->name}}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>
                @elseif(Auth::user()->id_tb_departamentos==2)
                <div class="form-group" id="selectordiseno">
                    <select class="form-control" id="asignado" name="asignado" required="">
                        <option disabled="" selected="" value="">
                            Asignar Empleado
                        </option>
                        @foreach($usuarios as $usuario)
                            @if($usuario->id_tb_departamentos == 3)
                        <option value="{{$usuario->id}}">
                            {{$usuario->name}}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>

                @else
                <input id="asignado" name="asignado" type="hidden" value="{{Auth::user()->id}}">
                </input>
                @endif
                <div class="form-group" id="numfactura">
                    {!!Form::number('num_factura',null,['id'=>'num_factura','class'=>'form-control','placeholder'=>'Número de Factura'])!!}
                </div>
                <div class="form-group" id="selectores2">
                    {!!Form::submit('Enviar',['class'=>'form-control btn btn-primary'])!!}
                </div>
            </div>
            <input id="asignador" name="asignador" type="hidden" value="{{Auth::user()->id}}">
            </input>
            @foreach($procesos1 as $proceso)
            <input id="tb_ordenes_id_tb_ordenes" name="tb_ordenes_id_tb_ordenes" type="hidden" value="{{$proceso->tb_ordenes_id_tb_ordenes}}">
            </input>
            @endforeach
            <div class="col-lg-8 col-sm-12 col-md-12 col-xs-12">
                <table class="table table-striped table-bordered table-condensed table-hover" id="tablaprocesos">
                    <thead style="background-color: #A9D0F5">
                        <th>
                            Departamento
                        </th>
                        <th>
                            Proceso
                        </th>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Empleado
                        </th>
                        <th>
                            Asignado por
                        </th>
                    </thead>
                    @foreach($procesos as $pro)
                    <tbody>
                        <td>
                            @if($pro->id_tb_departamentos==1)
                            <span class="label label-info">
                                {{$pro->departamentos}}
                            </span>
                            @elseif($pro->id_tb_departamentos==2)
                            <span class="label label-info">
                                {{$pro->departamentos}}
                            </span>
                            @elseif($pro->id_tb_departamentos==3)
                            <span class="label label-warning">
                                {{$pro->departamentos}}
                            </span>
                            @elseif($pro->id_tb_departamentos==4)
                            <span class="label label-success">
                                {{$pro->departamentos}}
                            </span>
                            @elseif($pro->id_tb_departamentos==5)
                            <span class="label label-danger">
                                {{$pro->departamentos}}
                            </span>
                            @endif
                        </td>
                        <td>
                            {{$pro->descripcion_procesos}}
                        </td>
                        <td id="fechas">
                            {{$pro->tb_fecha_hora}}
                        </td>
                        <td>
                            {{$pro->asignado}}
                        </td>
                        <td>
                            {{$pro->asignador}}
                        </td>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>
</div>
@stop

@section('css')
@stop

@section('js')
   
<script src="{{ asset('/js/moment-with-locales.js') }}" type="text/javascript">
</script>

<script>
    moment.locale('es');



    var formatofecha = document.getElementById("fecha");   
    $("#fecha").html("El "+ moment(formatofecha).format('LLLL'));
     

$("#numfactura").hide();
$("#selectordiseno").hide();


var compruebafactura =document.getElementById("descripcion_procesos").innerHTML; 


if(compruebafactura.trim()=="Facturado")
{
    $("#selectores").hide();
        $("#selectores1").hide();
            $("#selectores2").hide();
}

else{
    $("#selectores").show();
        $("#selectores1").show();
            $("#selectores2").show();
}

    

function MostrarFact(){

    datosprocesos =document.getElementById('id_tb_descripcion_procesos').value;

    procesoselecionado = $("#id_tb_descripcion_procesos option:selected").text();

    if(procesoselecionado.trim()=="Facturado"){
        $("#numfactura").show();
    }
    else
    {
        $("#numfactura").hide();
    }
    if(procesoselecionado.trim()=="Diseño"){
        $("#selectordiseno").show();
    }
    else
    {
        $("#selectordiseno").hide();
    }
     console.log(procesoselecionado);
}


</script>
@stop


