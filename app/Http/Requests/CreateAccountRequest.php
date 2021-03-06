<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAccountRequest extends Request
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
            'fi_id' => 'required',
            'account_number' => 'required',
            'account_type_id' => 'required',
            'user_id' => 'required',
            'currency_id' => 'required'
        ];
    }

    public function response(array $errors)
    {
        return response()->json(['message'=>$errors,'code'=>422]);
    }
}
