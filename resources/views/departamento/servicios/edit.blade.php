@extends('adminlte::page')

@section('title', 'Editar Servicio | Configuración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4>
                    Editar Servicio:
                    <span class="label label-primary">
                        {{$servicio->Servicio}}
                    </span>
                </h4>
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
            </div>
        </div>
    </div>
</div>
{!!Form::model($servicio,['method'=>'PATCH','route'=>['servicios.update', $servicio->id_tb_Servicios]])!!}
{!!Form::token()!!}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Tipo Empleado') !!}
                {!!Form::text('Servicio',$servicio->Servicio,['class'=>'form-control','id'=>'Servicio','placeholder'=>'Tipo'])!!}
                </div>
            </div>
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        Guardar
                    </button>
                    <button class="btn btn-danger" type="reset">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}

@stop
