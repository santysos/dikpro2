<div aria-hidden="true" class="modal fade modal-slide-in-right" id="modal-delete-{{$cat->id_tb_tipo_empleados}}" role="dialog" tabindex="-1">
    {{Form::Open(array('action'=>array('TipoEmpleadoController@destroy',$cat->id_tb_tipo_empleados),'method'=>'delete'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h4 class="modal-title">
                    Eliminar Tipo de Empleado
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    Confirme si desea Eliminar el Tipo de Empleado
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
{!!Form::open(array('url'=>'personal/empleados','method'=>'POST','autocomplete'=>'off'))!!}
