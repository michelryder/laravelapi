<?php
// app/Http/Requests/ServerRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ip' => 'required|ip|unique:servers,ip,' . $this->id,
            'host' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=300,max_height=300'
        ];
    }

    public function messages()
    {
        return [
            'image.dimensions' => 'La imagen no debe exceder 300x300 píxeles.',
            'ip.unique' => 'La dirección IP ya existe en el sistema.'
        ];
    }
}