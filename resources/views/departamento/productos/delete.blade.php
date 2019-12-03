{{Form::Open(['route'=>['productos.destroy',$cat->id_tb_descripcion_servicios],'method'=>'delete'])}}
<a href="{{URL::action('ProductosController@edit',$cat->id_tb_descripcion_servicios)}}">
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
