<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $table = 'tb_departamentos';

    protected $primaryKey = 'id_tb_departamentos';

    public $timestamps = false;

    protected $fillable = [

        'departamentos',

    ];

    protected $guarded = [

    ];
}
