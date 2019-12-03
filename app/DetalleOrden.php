<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = 'tb_detalle_orden';

    protected $primaryKey = 'id_do';

    public $timestamps = false;

    protected $fillable = [

        'id_tb_ordenes',
        'id_tb_descripcion_servicios',
        'Cantidad',
        'Valor_Unitario',
        'Descripcion',

    ];

    protected $guarded = [

    ];
}
