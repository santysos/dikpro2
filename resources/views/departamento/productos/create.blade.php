@extends('adminlte::page')

@section('title', 'Nuevo Producto | Configuración')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
        {!!Form::open(array('url'=>'departamento/productos','method'=>'POST','autocomplete'=>'off'))!!}
        {!!Form::token()!!}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                <h4>
                    Nuevo Producto
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
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                <h4>
                </h4>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!!Form::select('id_tb_Servicios',$servicios,null,['class'=>'form-control','required'=>'required','placeholder'=>'Seleccione el Servicio'])!!}
                </div>
                <div class="form-group">
                    {!!Form::text('Productos',null,['class'=>'form-control','required'=>'required','placeholder'=>'Nuevo Producto'])!!}
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
            {!!Form::close()!!}
        </div>
    </div>
</div>
@stop

