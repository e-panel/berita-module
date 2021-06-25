<?php

namespace Modules\Berita\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Modules\Berita\Entities\Kategori;

class KategoriRequest extends FormRequest
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
                    'label' => 'required|unique:berita_kategori,label'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $data = Kategori::uuid(request()->segment(4))->first();
                return [
                    'label' => 'required|unique:berita_kategori,label,'.$data->id
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
