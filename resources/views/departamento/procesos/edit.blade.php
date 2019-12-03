@extends ('adminlte::layouts.app')
@section ('contenido')
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h4>
                    Editar Proceso:
                    <span class="label label-primary">
                        {{$proceso->descripcion_procesos}}
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
{!!Form::model($proceso,['method'=>'PATCH','route'=>['procesos.update', $proceso->id_tb_descripcion_procesos]])!!}
{!!Form::token()!!}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!!Form::text('Servicio',$departamento->departamentos,['class'=>'form-control','readonly','id'=>'Servicio','placeholder'=>'Servicio'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!!Form::text('descripcion_procesos',$proceso->descripcion_procesos,['class'=>'form-control','required'=>'required','placeholder'=>'Proceso'])!!}
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
        document.title = 'Editar Proceso | Configuracion'; }
    titulo();
</script>
@endpush       
@endsection
