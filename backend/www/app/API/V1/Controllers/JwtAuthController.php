<?php

namespace App\API\V1\Controllers;

use App\API\V1\Requests\Auth\LoginUser;
use App\API\V1\Requests\Auth\RegisterUser;
use App\API\V1\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class JwtAuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post  (
     *      tags={"Authentication"},
     *      path="/auth/register",
     *      summary="Store a newly created resource in storage.",
     *      security={{ "Bearer":{} }},
     *     @OA\RequestBody(
     *          request="RegisterApiUser",
     *          description="User request fields",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Luke", description="User's name ['required', 'string', 'max:255']"),
     *              @OA\Property(property="email", type="string", example="email@example.com", description="The email used by the user ['required', 'email']"),
     *              @OA\Property(property="password", type="string", example="password", description="User password ['required', 'string', 'min:8', 'max:255']")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful response with the result of the request",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="An error response.",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation errors.",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param RegisterUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUser $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => strtolower($request->email),
                'password' => bcrypt($request->password)
            ]);
            return $this->respondSuccess('Success', 201);
        } catch (Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * @OA\Post  (
     *      tags={"Authentication"},
     *      path="/auth/login",
     *      summary="Get a JWT via given credentials.",
     *      @OA\RequestBody(
     *          request="LoginRequest",
     *          description="Auth request fields",
     *          @OA\JsonContent(
     *              type="object",
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", example="admin@gmail.com"),
     *              @OA\Property(property="password", type="string", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success auth response",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="User not authorized. Wrong login or password.",
     *          @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation errors.",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUser $request)
    {
        if (! $token = auth('api')->attempt([
            'email' => strtolower($request->email),
            'password' => $request->password
        ])) {

            return $this->respondUnAuthorized();
        }

        return $this->respondWithResource(JsonResource::make($this->respondWithToken($token)));
    }

    /**
     * @OA\Get  (
     *      tags={"Authentication"},
     *      path="/auth/user",
     *      summary="Get the authenticated User.",
     *      security={{ "Bearer":{} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful response with user data",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return $this->respondWithResource(JsonResource::make(auth('api')->user()));
    }

    /**
     * @OA\Post  (
     *      tags={"Authentication"},
     *      path="/auth/logout",
     *      summary="Log the user out (Invalidate the token).",
     *      security={{ "Bearer":{} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful logout response",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return $this->respondSuccess('Successfully logged out');
    }

    /**
     * @OA\Post  (
     *      tags={"Authentication"},
     *      path="/auth/refresh",
     *      summary="Refresh a token.",
     *      security={{ "Bearer":{} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful response with a new token.",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $response = $this->respondWithToken(auth('api')->refresh());
        return $this->respondWithResource(JsonResource::make($response));
    }

    /**
     *
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array
     */
    protected function respondWithToken($token)
    {
        return [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ] + auth('api')->user()->toArray();
    }
}
