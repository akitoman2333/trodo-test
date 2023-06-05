<?php

namespace App\API\V1\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Test API Documentation"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with login and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="Bearer",
 * )
 *
 * @OA\Server( url=L5_SWAGGER_CONST_HOST )
 *
 * @OA\Tag( name="Authentication", description="" )
 *
 * @OA\Response(response="Unauthorized", description="If no token...")
 *
 */

class Controller extends \App\Http\Controllers\Controller
{

}
