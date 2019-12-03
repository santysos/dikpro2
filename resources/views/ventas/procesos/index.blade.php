@extends('adminlte::page')

@section('title', 'Cambio de Procesos | Procesos')

@section('content_header')
    <h1>                        Cambio de Estado Proceso Orden
    </h1>
@stop

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="panel">
        <div class="panel-body">
            <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
           
            </div>
            <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <div class="input-group col-lg-12">
                        <input class="form-control" id="norden" name="norden" placeholder="Buscar por numero de Orden" type="number" value="">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" id="boton" type="submit">
                                    Buscar
                                </button>
                            </span>
                        </input>
                    </div>
                </div>
            </div>
          
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!!Form::select('departamentos',$departamentos,null,['id'=>'departamentos','required' => 'required','class'=>'form-control','placeholder'=>'Selecione el Departamento'])!!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!!Form::select('descripcionprocesos',['placeholder'=>'Descripción Procesos'],null,['id'=>'descripcionprocesos','class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="tablaprocesos">
                        <thead>
                            <th>
                                # Orden
                            </th>
                            <th>
                                Proceso
                            </th>
                            <th>
                                Fecha Hora
                            </th>
                            <th>
                                Empleado
                            </th>
                            <th>
                                Modificado por
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        <tr>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="{{ asset('/js/moment-with-locales.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/selectdinamico-procesos.js') }}" type="text/javascript">
</script>
<script>
 

    $("#norden").keyup(function(e){                      
           consulta = $("#norden").val();
            console.log(consulta);
        });
    
    $('#boton').click(function(){
    location.href='procesos/'+consulta;
            });
    </script>
@stop

