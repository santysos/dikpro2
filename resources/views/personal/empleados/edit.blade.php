@extends ('adminlte::layouts.app')
@section ('contenido')
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4>
                    Editar tipo de empleado:
                    <span class="label label-primary">
                        {{$tipo_empleado->tipo_empleados}}
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
{!!Form::model($tipo_empleado,['method'=>'PATCH','route'=>['empleados.update', $tipo_empleado->id_tb_tipo_empleados]])!!}
{!!Form::token()!!}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('categoria', 'Tipo Empleado') !!}
				{!!Form::text('tipo_empleado',$tipo_empleado->tipo_empleados,['class'=>'form-control','id'=>'tipo_empleado','placeholder'=>'Tipo'])!!}
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
@push ('scripts')
<script>
    function titulo(){      
	    
	    document.title = 'Editar tipo de empleado | Acceso'; }
	titulo();
</script>
@endpush
@endsection
