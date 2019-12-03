<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'tb_empleados';

    protected $primaryKey = 'id_tb_empleados';

    public $timestamps = false;

    protected $fillable = [

        'id_tb_tipo_empleados',
        'id_tb_departamentos',
        'tb_empleados',
        'condicion',

    ];

    protected $guarded = [

    ];
}
