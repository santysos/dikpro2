<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionProcesos extends Model
{
    protected $table = 'tb_descripcion_procesos';

    protected $primaryKey = 'id_tb_descripcion_procesos';

    public $timestamps = false;

    protected $fillable = [

        'descripcion_procesos',
        'id_tb_departamentos',
        'condicion',

    ];

    protected $guarded = [

    ];
}
