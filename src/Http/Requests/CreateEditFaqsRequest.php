<?php

namespace Mixdinternet\Faqs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditFaqsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'required'
            , 'star' => 'required'
            , 'name' => 'required|max:150'
            , 'description' => 'required'

        ];
    }

    public function authorize()
    {
        return true;
    }
}