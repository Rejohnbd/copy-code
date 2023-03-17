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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"user"},
     *     summary="Logs user into system",
     *     operationId="login",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="The user email for login",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Header(
     *             header="X-Rate-Limit",
     *             description="calls per hour allowed by the user",
     *             @OA\Schema(
     *                 type="integer",
     *                 format="int32"
     *             )
     *         ),
     *         @OA\Header(
     *             header="X-Expires-After",
     *             description="date in UTC when token expires",
     *             @OA\Schema(
     *                 type="string",
     *                 format="datetime"
     *             )
     *         ),
     *         @OA\JsonContent(
     *             type="string"
     *         ),
     *         @OA\MediaType(
     *             mediaType="application/xml",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username/password supplied"
     *     )
     * )
     */
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
