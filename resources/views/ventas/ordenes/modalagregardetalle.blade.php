<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
	id="modalagregardetalle">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
            	{!!Form::open(array('url'=>'ventas/detalleorden','method'=>'POST','autocomplete'=>'off'))!!}
				{!!Form::token()!!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Agregar Nuevo Detalle a la Orden #{{$orden->id_tb_ordenes}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                {!!Form::select('servicios',$servicios,null,['required','id'=>'servicios','class'=>'form-control','placeholder'=>'Servicios'])!!}
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                {!!Form::select('descripcionservicios',['placeholder'=>'Descripción Servicios'],null,['id'=>'descripcionservicios','class'=>'form-control'])!!}
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                {!!Form::number('cantidad',null,['required','id'=>'cantidad','class'=>'form-control','placeholder'=>'Cantidad'])!!}
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!!Form::number('valortotal',null,['min'=>'0.01','step'=>'any','required','id'=>'valortotal','class'=>'form-control','placeholder'=>'V. Unitario (sin iva)'])!!}
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!!Form::textarea('descripcionorden',null,['required','id'=>'descripcionorden','class'=>'form-control','placeholder'=>'Descripción','size' => '30x3','maxlength'=>'180'])!!}
                                </div>
                            </div>
                            {!! Form::text('norden',$orden->id_tb_ordenes, ['id'=>'norden','hidden']) !!}
					</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
        {!!Form::close()!!}
	</div>
</div>
</div>