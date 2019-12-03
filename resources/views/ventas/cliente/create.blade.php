@extends('adminlte::page')

@section('title', 'Nuevo Cliente | Clientes')

@section('content_header')
    <h1>Nuevo Cliente</h1>
@stop

@section('content')
<div class="container-fluid">
        {!!Form::open(array('url'=>'ventas/cliente','method'=>'POST','autocomplete'=>'off'))!!}
        {!!Form::token()!!}
        
<div class="row">
    <div class="panel">
        <div class="panel-body">
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
         
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
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Codigo Cliente') !!}
            {!!Form::number('id_tb_cliente',null,['class'=>'form-control' ,'placeholder'=>'Cod Tini','required' => 'required'])!!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('codigo', 'Número CED / RUC') !!}
            {!!Form::number('Cedula_Ruc',null,['class'=>'form-control', 'placeholder'=>'1001001001001' ,'required' => 'required'])!!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('nombre', 'Cliente Nombre Comercial') !!}
            {!! Form::text('Cliente_Nombre_Comercial',null,['class'=>'form-control','placeholder'=>'Nombre Comercial','required' => 'required'])!!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('nombre', 'Contacto Razón Social') !!}
            {!! Form::text('Contacto_Razon_Social',null,['class'=>'form-control','placeholder'=>'Razón Social'])!!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
                    {!! Form::label('stock', 'Teléfono') !!}
            {!! Form::text('Telefono', null, ['class' => 'form-control','placeholder'=>'Teléfono...']) !!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
                    {!! Form::label('descripcion', 'Email') !!}
            {!! Form::email('Email', 'notiene@hotmail.com', ['class' => 'form-control' ,'placeholder'=>'Email...']) !!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('direccion', 'Ciudad') !!}
            {!! Form::text('Ciudad', null, ['class' => 'form-control','placeholder'=>'Ciudad...' ]) !!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('direccion', 'Dirección') !!}
            {!! Form::text('Direccion', null, ['class' => 'form-control','placeholder'=>'Direccion...' ]) !!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
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
</div>
{!!Form::close()!!}
        </div>
@stop
