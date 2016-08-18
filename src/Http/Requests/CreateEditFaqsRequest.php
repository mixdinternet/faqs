<?php
namespace Mixdinternet\Faqs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditFaqsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required'
            , 'star' => 'required'
            , 'name' => 'required|max:150'
            , 'description' => 'required'
            
        ];
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