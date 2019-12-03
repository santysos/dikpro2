<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'Fecha_de_Entrega' => 'required',
            'Revision_de_Diseno',
            'total_venta'      => 'required',
            'users_id',
            'Abono'            => 'required',
            'Observaciones',
            'CodigoCliente',
            'Condicion',
            'IVA',
            'iddescripcionservicios',
            'cantidad',
            'idservicios',
            'Valor_total',
            'descripcion',
            'usuario',
            'domicilio',
            

        ];
    }
}
