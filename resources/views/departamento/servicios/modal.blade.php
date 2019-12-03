<div aria-hidden="true" class="modal fade modal-slide-in-right" id="modal-delete-{{$cat->id_tb_Servicios}}" role="dialog" tabindex="-1">
    {{Form::Open(['route'=>['servicios.destroy',$cat->id_tb_Servicios],'method'=>'delete'])}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h4 class="modal-title">
                    Eliminar Servicio
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    Confirme si desea Eliminar el Servicio
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
<!--{{Form::Open(array('action'=>array('ServiciosController@destroy',$cat->id_tb_Servicios),'method'=>'delete'))}} -->
