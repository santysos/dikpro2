<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarClienteFormRequest extends FormRequest
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
            'Cliente_Nombre_Comercial' => 'required|max:60',
            'Contacto_Razon_Social'    => 'required|max:60',
            'Direccion'                => 'max:300',
            'Ciudad'                   => 'max:25',
            'Telefono'                 => 'max:10',
            'Cedula_Ruc'               => 'max:13',
            'Email'                    => 'max:45',

        ];
    }
}
