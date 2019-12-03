@extends('adminlte::page')

@section('title', ' Editar Empleado | Acceso')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4>
                    Editando Usuario:
                    <span class="label label-warning">
                        {{$empleado->name}}
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
{!!Form::model($empleado,['method'=>'PATCH','route'=>['empleado.update', $empleado->id]])!!}
{!!Form::token()!!}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Departamento') !!}
				{!! Form::select('id_tb_departamentos',$departamentos,null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Nombre y Apellido') !!}
				{!! Form::text('name',null,['class'=>'form-control','required'=>'required','placeholder'=>'Juan Perez'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('Email', 'Email') !!}
				{!! Form::text('email',null,['class'=>'form-control','required'=>'required','placeholder'=>'ejemplo@dikapsa.com'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Tipo Empleado') !!}
				{!! Form::select('id_tb_tipo_empleados',$tipo_empleados,null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Contraseña') !!}
				{!! Form::Password('password',['class'=>'form-control','required'=>'required','placeholder'=>'Contraseña'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Confirmar Contraseña') !!}
				{!! Form::password('password_confirmation',['class'=>'form-control','required'=>'required','placeholder'=>'Vuelva a escribir la Contraseña'])!!}
                </div>
            </div>
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
{!!Form::close()!!}

	
@stop
