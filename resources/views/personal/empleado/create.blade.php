@extends('adminlte::page')

@section('title', 'Nuevo Empleado ')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
		{!!Form::open(array('url'=>'personal/empleado','method'=>'POST','autocomplete'=>'off'))!!}
		{!!Form::token()!!}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                <h4>
                    Nuevo Empleado
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
                <hr>
                </hr>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::select('id_tb_departamentos',$departamentos,null,['id'=>'id_tb_departamentos','class'=>'form-control','placeholder'=>'Selecione Departamento'])!!}
                    {!! Form::label('', '') !!}

                     {!!Form::select('id_tb_tipo_empleados',['placeholder'=>'Selecione Tipo de Empleado'],null,['id'=>'id_tb_tipo_empleados','class'=>'form-control'])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('categoria', 'Nombre y Apellido') !!}
				    {!! Form::text('name',null,['class'=>'form-control','required'=>'required','placeholder'=>'Juan Perez'])!!}
                	{!! Form::label('Email', 'Email') !!}
					{!! Form::text('email',null,['class'=>'form-control','required'=>'required','placeholder'=>'ejemplo@dikapsa.com'])!!}
					{!! Form::label('categoria', 'Contraseña') !!}
					{!! Form::Password('password',['class'=>'form-control','required'=>'required','placeholder'=>'Contraseña'])!!}
				 	{!! Form::label('categoria', 'Confirmar Contraseña') !!}
					{!! Form::password('password_confirmation',['class'=>'form-control','required'=>'required','placeholder'=>'Vuelva a escribir la Contraseña'])!!}
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
@section('css')
@stop

@section('js')
<script src="{{ asset('/js/selectdinamicodep.js') }}" type="text/javascript">
</script>
@stop
