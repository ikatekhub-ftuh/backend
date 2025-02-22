<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumniRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama'              => 'required|string',
            'tgl_lahir'         => 'required|date',
            'jurusan'           => 'required|string',
            'angkatan'          => 'required|integer|digits:4',
            'jenjang'           => 'required|string|in:s1,s2,ppi,ppa',
            'no_telp'           => 'nullable',
            'kelamin'           => 'required|string|in:l,p',
            'agama'             => 'required',
            'nim'               => 'nullable',
        ];
    }
}
