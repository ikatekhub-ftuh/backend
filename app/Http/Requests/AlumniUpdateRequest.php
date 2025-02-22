<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumniUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama'              => 'sometimes|required|string|max:100',
            'nim'               => 'sometimes|required|string|max:20',
            'tgl_lahir'         => 'sometimes|required|date',
            'jurusan'           => 'sometimes|required|string|max:100',
            'angkatan'          => 'sometimes|required|integer|digits:4',
            'no_telp'           => 'sometimes|required|string|max:20',
            'agama'             => 'sometimes|nullable|string|max:50',
            'kelamin'           => 'sometimes|string|in:l,p',
            'golongan_darah'    => 'sometimes|nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ];
    }
}
