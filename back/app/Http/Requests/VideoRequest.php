<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            'url' => 'required|url|bail',
            'start' => 'required',
            'end'  => 'required|numeric|bail',
            'newUrl' => 'unique:file',

        ];
    }

     /**
      * Get the error messages for the defined validation rules.
      *
      * @return array
    */


    public function messages()
    {
        return [

            'url.required' => 'youtube url is required!',

            'start.required' => "start time is required!",
            // 'start.numeric' => 'start time must be a number!',

            'end.required' => 'end time is required!',
            'end.numeric' => 'end time must be a number!',

            // 'newUrl.unique' => 'This post already exist!',

        ];
    }

}




