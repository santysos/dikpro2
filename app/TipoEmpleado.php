<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEmpleado extends Model
{
    protected $table = 'tb_tipo_empleados';

    protected $primaryKey = 'id_tb_tipo_empleados';

    public $timestamps = false;

    protected $fillable = [

        'id_tb_departamentos',
        'tipo_empleados',

    ];

    protected $guarded = [

    ];

    public static function TipoEmpleados($id)
    {
        return TipoEmpleado::where('id_tb_departamentos', '=', $id)
            ->where('condicion', '=', '1')
            ->get();

    }
}
