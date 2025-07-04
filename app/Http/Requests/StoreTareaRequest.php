<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTareaRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
        {
            return [
                'titulo'      => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'estado' => 'sometimes|in:pendiente,completado',

            ];
        }




}
