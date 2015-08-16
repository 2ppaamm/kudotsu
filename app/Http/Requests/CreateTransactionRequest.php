<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTransactionRequest extends Request
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
            'user_id' => 'required',
            'bank_account_id'=>'required',
            'txn_currencyid' => 'required',
            'amount_in_txn_currency' =>'required',
            'transaction_address' => 'required',
            'merchant_code' =>'required'
        ];
    }

    public function response(array $errors)
    {
        return response()->json(['message'=>$errors, 'code'=>422], 422);
    }
}
