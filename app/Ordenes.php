<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    protected $table = 'tb_ordenes';

    protected $primaryKey = 'id_tb_ordenes';

    public $timestamps = false;

    protected $fillable = [

        'Fecha_de_Entrega',
        'Revision_de_Diseno',
        'Total_Venta',
        'IVA',
        'Abono',
        'Observaciones',
        'id_tb_cliente',
        'Condicion',
        'agente',
        'asignador',
        

    ];

    protected $guarded = [

    ];
}
