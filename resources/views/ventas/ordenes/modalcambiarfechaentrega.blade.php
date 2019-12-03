<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
	id="modalcambiarfechaentrega">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
                {{Form::Open(array('action'=>array('DetalleOrdenController@update',$orden->id_tb_ordenes),'method'=>'patch'))}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Cambiar la Fecha de Entrega de la Orden #{{$orden->id_tb_ordenes}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="Fecha_de_E"></div>
                                {!! Form::hidden('Fecha_de_Entrega', null, ['id'=>'Fecha_de_Entrega']) !!}
                        </div>
					</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
        {{Form::Close()}}
	</div>
</div>
</div>