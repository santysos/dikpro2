<div aria-hidden="true" class="modal fade modal-slide-in-right" id="modal-delete-{{$cat->id_tb_departamentos}}" role="dialog" tabindex="-1">
    {{Form::Open(array('action'=>array('DepartamentosController@destroy',$cat->id_tb_departamentos),'method'=>'delete'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h4 class="modal-title">
                    Eliminar Departamento
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    Confirme si desea Eliminar el Departamento
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <button class="btn btn-primary" type="submit">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
    {{Form::Close()}}
</div>
