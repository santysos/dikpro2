{{Form::Open(['route'=>['cliente.destroy',$cat->id_tb_cliente],'method'=>'delete'])}}
<a href="{{URL::action('ClienteController@edit',$cat->id_tb_cliente)}}">
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
<!-- <a data-target="#modal-delete-{{$cat->id_tb_cliente}}" data-toggle="modal" href="">
    <button class="btn btn-danger btn-xs" type="button">
        <span aria-hidden="true" class="glyphicon glyphicon-trash"></span>
    </button>
    </a>-->
