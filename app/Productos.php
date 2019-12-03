<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'tb_descripcion_servicios';

    protected $primaryKey = 'id_tb_descripcion_servicios';

    public $timestamps = false;

    protected $fillable = [

        'id_tb_Servicios',
        'Productos',

    ];

    protected $guarded = [

    ];

    public static function dese($id)
    {
        return Productos::where('id_tb_Servicios', '=', $id)
            ->where('condicion', '=', '1')
            ->get();

    }
}
