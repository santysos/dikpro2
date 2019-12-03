<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'tb_cliente';

    protected $primaryKey = 'id_tb_cliente';

    public $timestamps = false;

    protected $fillable = [
        'id_tb_cliente',
        'Cliente_Nombre_Comercial',
        'Contacto_Razon_Social',
        'Direccion',
        'Ciudad',
        'Telefono',
        'Cedula_Ruc',
        'Email',

    ];
    protected $guarded = [

    ];
    public static function BuscarCliente($id)
    {

        return Persona::where('Cliente_Nombre_Comercial', 'LIKE', '%' . $id . '%')
            ->orwhere('Contacto_Razon_Social', 'LIKE', '%' . $id . '%')
            ->orwhere('Cedula_Ruc', 'LIKE', '%' . $id . '%')
            ->first();

    }
    /* public static function BuscarCliente1($term)
{

if ($term == -1) {
$term     = "";
$consulta = 'SELECT t.id_tb_cliente as id , t.Cliente_Nombre_Comercial as text , t.Email from tb_cliente t  limit 12';
} else {
$consulta = 'SELECT t.id_tb_cliente as id , t.Cliente_Nombre_Comercial as text, t.Email from tb_cliente t where t.Cliente_Nombre_Comercial like "%' . $term . '%"  limit 12';
}

$cliente = DB::select($consulta);

return $cliente;
}*/

}
