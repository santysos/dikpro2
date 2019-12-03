<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'tb_servicios';

    protected $primaryKey = 'id_tb_Servicios';

    public $timestamps = false;

    protected $fillable = [

        'Servicio',

    ];

    protected $guarded = [

    ];
}
