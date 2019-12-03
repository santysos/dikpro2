@extends('adminlte::page')

@section('title', 'Editar Departamento | Configuración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4>
                    Editar Departamento:
                    <span class="label label-primary">
                        {{$departamento->departamentos}}
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
{!!Form::model($departamento,['method'=>'PATCH','route'=>['departamentos.update', $departamento->id_tb_departamentos]])!!}
{!!Form::token()!!}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Tipo Empleado') !!}
                {!!Form::text('departamento',$departamento->departamentos,['class'=>'form-control','id'=>'departamento','placeholder'=>'Tipo'])!!}
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
