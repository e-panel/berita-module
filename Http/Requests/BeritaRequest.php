<?php

namespace Modules\Berita\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeritaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'judul' => 'required',
                    'preview' => 'required',
                    'isi' => 'required',
                    'foto' => 'required|mimes:png,jpg,jpeg',
                    'sumber_foto' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'judul' => 'required',
                    'preview' => 'required',
                    'isi' => 'required',
                    'foto' => 'mimes:png,jpg,jpeg',
                    'sumber_foto' => 'required',
                ];
            }
            default:break;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
