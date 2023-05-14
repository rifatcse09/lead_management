<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\LoginResource;
use Illuminate\Auth\AuthenticationException;
use App\RequestValidator\Validator;

class AuthController extends Controller
{
    public function login(LoginRequest $request ,Validator $validator)
    {

        //$validator = new Validator();
        $validator->request([
        'name'=>'',
        'email'=>'','type'=>'11', 
        'money' => '2111a', 
        'zip_code' => '12q456',
        'terms' => '1212', 
        'age' => '12',
        'phone_number' => '01867s',
        'gender' => 'f',
        'username' => 'RR',
        'password' => 'qw',
        ]);

        $rules = [
        'name' => 'required|min:3',
        //'name' => ['required', 'min:3'],
        'email' => ['required', 'email'],
        'type' => ['required', 'boolean'],
        'money' => ['required', 'numeric'],
        'zip_code' => ['required','digits:6'],
        'terms' => 'accepted',
        'age' => 'integer',
        'phone_number' => 'regex:/^[0-9\-]+$/',
        'gender' => 'required|in:male,female',
        'username' => 'required|lowercase',
        'password' => 'required|uppercase',
        ];
        $validator->rules($rules);
        //$validator->rule('name', 'required|min:3');
        $validator->validate();
        foreach ($validator->errors() as $error) {
            logger($error);
        }


        $input = $request->validated();
        $user = User::where('email', $input['email'])->where('status', User::ACTIVE)->first();

        if ($user && Hash::check($input['password'], $user->password)) {
            $token = $user->createToken('user');

            if($user->type != User::SYSTEM_ADMIN){
                $customer_company = $user->customerCompany;
                if($customer_company->auto_logout_time) {
                    $token_id = $token->accessToken->id;
                    DB::table('personal_access_tokens')->where('id', $token_id)->update(['expires_at'=>now()->addMinutes($customer_company->auto_logout_time)]);
                }
            }

            return response()->json([
                'user'  =>  new LoginResource($user),
                'token' =>  $token->plainTextToken
            ]);
        }
        throw new AuthenticationException();
    }

    public function getUser(Request $request)
    {
        return new LoginResource($request->user());
    }

    public function logout(Request $request)
    {
        # code...
        $request->user()->currentAccessToken()->delete();

        return response(null, 200);
    }
}
