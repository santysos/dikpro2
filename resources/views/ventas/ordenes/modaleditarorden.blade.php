<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
	id="modaleditarorden-{{$cat->id_do}}">
	<div class="modal-dialog modal-lg">
	{!!Form::model($detalleorden,['method'=>'PATCH','route'=>['ordenes.update',$cat->id_do]])!!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Editar Detalle de la Orden #{{$orden->id_tb_ordenes}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                            {!!Form::text('Cant',$cat->Cantidad,['class'=>'form-control','readonly'])!!}
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                            {!!Form::text('Serv',$cat->Servicio,['class'=>'form-control','readonly'])!!} 
					</div>
					<div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                            {!!Form::text('Prod',$cat->Productos,['class'=>'form-control','readonly'])!!} 
					</div>
					<div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                            {!!Form::text('Va_Un',$cat->Valor_Unitario,['class'=>'form-control','readonly'])!!} 
					</div>
					<div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                            {!!Form::text('Tot',number_format($cat->Valor_Unitario*$cat->Cantidad,2),['class'=>'form-control','readonly'])!!} 
                    </div>
					<div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                            {!!Form::text('Desc',$cat->Descripcion,['class'=>'form-control','readonly'])!!} 
					</div>
					</div>
					<br>
				<div class="row">
				<div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
						{!!Form::text('Servicios',$cat->Servicio,['class'=>'form-control','readonly'])!!} 
				</div>
				<div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
						{!!Form::text('Productos',$cat->Productos,['class'=>'form-control','readonly'])!!} 
				</div>
				<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
						{!!Form::number('cantidad',$cat->Cantidad,['id'=>'cantidad','class'=>'form-control','placeholder'=>'Cantidad'])!!}
					</div>
					<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
								{!!Form::number('valortotal',$cat->Valor_Unitario,['min'=>'0.01','step'=>'any','id'=>'valortotal','class'=>'form-control','placeholder'=>'V. Unitario (sin iva)'])!!}
							</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							{!!Form::textarea('descripcionorden',$cat->Descripcion,['id'=>'descripcionorden','class'=>'form-control','placeholder'=>'Descripción','size' => '30x3','maxlength'=>'180'])!!}
						</div>
					</div>
				<div>

				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
	</div>
	{{Form::Close()}}
</div>
</div>