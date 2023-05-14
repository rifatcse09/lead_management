<?php

namespace App\Http\Requests\BrokerUser;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        $auth_user = auth()->user();

        return  $auth_user->canAccess('broker-user:edit') && $this->broker_user->customer_company_id == $auth_user->customer_company_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "first_name"          => ['required', 'max:30',],
            "last_name"           => ['required', 'max:30',],
            "phone_iso_code"      => ['nullable', 'max:10'],
            "phone"        => ['nullable','integer'],
        ];
    }
}
