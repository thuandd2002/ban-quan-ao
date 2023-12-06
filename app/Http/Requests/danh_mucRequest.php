<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class danh_mucRequest extends FormRequest
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
    public function rules()
    {
        $rules = [];
        $currenAction = $this->route()->getActionMethod();

        switch ($this->method()):
            case 'POST':
                switch ($currenAction) {
                    case 'add':
                        $rules = [
                            "name" => "required|unique:danh_mucs",
                        ];

                    default:
                        break;
                }
                break;
            default:
                break;
        endswitch;
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Bắt buộc phải nhập Tên danh mục',
            'email.unique' => 'email k đc trùng'
        ];
    }
}
