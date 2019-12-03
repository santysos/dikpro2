<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    protected $table = 'tb_procesos';

    protected $primaryKey = 'id_tb_procesos';

    public $timestamps = false;

    protected $fillable = [

        'tb_ordenes_id_tb_ordenes',
        'id_tb_descripcion_procesos',
        'tb_fecha_hora',
        'asignado',
        'asignador',
        'condicion',
        'num_factura',

    ];

    protected $guarded = [

    ];
    public static function despro($id)
    {
        return DescripcionProcesos::where('id_tb_departamentos', '=', $id)
            ->where('condicion', '=', '1')
            ->get();

    }

    public static function OrdenProcesoDepartamento($id)
    {

        return DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.asignador')
            ->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
            ->select('pro.id_tb_procesos', 'pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador')
            ->where('pro.id_tb_descripcion_procesos', '=', $id)
            ->where('pro.condicion', '=', '1')
            ->orderBy('pro.tb_ordenes_id_tb_ordenes', 'desc')
            ->get();

    }
}
/*return DB::table('tb_procesos as pro')
->join('users as emp', 'emp.id', '=', 'pro.users_id')
->join('tb_descripcion_procesos as dpro', 'dpro.id_tb_descripcion_procesos', '=', 'pro.id_tb_descripcion_procesos')
->select('pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name', 'dpro.descripcion_procesos')
->groupBy('pro.tb_ordenes_id_tb_ordenes', 'pro.tb_fecha_hora', 'emp.name', 'dpro.descripcion_procesos')
->paginate(20);*/
