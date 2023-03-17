<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Exception;
use Illuminate\Http\Response as Res;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        $validator = validator(
            $request->all(),
            [
                'email'     => 'required|string|email|max:255',
                'password'  => 'required|string|min:8'
            ],
            [
                'email.required'    => 'Please Give User Email',
                'email.string'      => 'Provide Vaild Email Address',
                'email.email'       => 'Provide Vaild Email Address',
                'email.max'         => 'Provide Vaild Email Address',
                'password.required' => 'Please Give User Password',
                'password.string'   => 'Provide Valid User Password',
                'password.min'      => 'Password Length at Least 8 Charecters',
            ]
        );

        if ($validator->fails()) :
            return $this->responseValidationError(Res::HTTP_BAD_REQUEST, $validator->getMessageBag()->first(), $validator->getMessageBag());
        else :
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) :
                $user = Auth::user();
                // $tokenInstance = $this->getAuthToken($user);
                // $expiresAt = $this->getExpiresAt($tokenInstance);
                $tokenInstance = $user->createToken('authToken');
                $expiresAt = Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString();
                try {
                    // throw new Exception("Error Proceesing Request", 1);
                    return $this->responseWithToken(Res::HTTP_OK, $tokenInstance->accessToken, $user, $expiresAt);
                } catch (Exception $e) {
                    return $this->resposeWithExpectationFailed(Res::HTTP_EXPECTATION_FAILED, $e->getMessage());
                }
            else :
                return $this->responseError(Res::HTTP_UNAUTHORIZED, 'Sorry Invalid Email and Password');
            endif;
        endif;
    }

    // public function getAuthToken(User $user)
    // {
    //     return $user->createToken('authToken');
    // }

    // public function getExpiresAt(PersonalAccessTokenResult $tokenInstance)
    // {
    //     return Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString();
    // }
}
