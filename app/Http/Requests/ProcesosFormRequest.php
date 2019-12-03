<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcesosFormRequest extends FormRequest
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
            'tb_ordenes_id_tb_ordenes'   => 'required',
            'id_tb_descripcion_procesos' => 'required',
            'tb_fecha_hora',
            'num_factura',
            'asignado'                   => 'required',
            'asignador'                  => 'required',

        ];
    }
}
