
<a href="" data-target="#modaleditarorden-{{$cat->id_do}}" data-toggle="modal">
    <button type="button" class="btn btn-success btn-xs">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    </button>
</a>        

<a href="{{URL::action('OrdenesController@borrardetalle',$cat->id_do)}}">
    <button class="btn btn-danger btn-xs" onclick="return confirm('Seguro que desea Eliminar?')" type="submit">
        <span aria-hidden="true" class="glyphicon glyphicon-trash">
        </span>
    </button>
</a>