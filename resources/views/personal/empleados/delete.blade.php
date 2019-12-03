{{Form::Open(['route'=>['empleados.destroy',$cat->id_tb_tipo_empleados],'method'=>'delete'])}}
<a href="{{URL::action('TipoEmpleadoController@edit',$cat->id_tb_tipo_empleados)}}">
    <button class="btn btn-success btn-xs" type="button">
        <span aria-hidden="true" class="glyphicon glyphicon-pencil">
        </span>
    </button>
</a>
<button class="btn btn-danger btn-xs" onclick="return confirm('Seguro que desea Eliminar?')" type="submit">
    <span aria-hidden="true" class="glyphicon glyphicon-trash">
    </span>
</button>
{{Form::Close()}}
<!-- <a data-target="#modal-delete-{{$cat->id_tb_tipo_empleados}}" data-toggle="modal" href="">
    <button class="btn btn-danger btn-xs" type="button">
        <span aria-hidden="true" class="glyphicon glyphicon-trash"></span>
    </button>
    </a>-->
