<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(title="QVote API", version="1.0")
 * @OA\Server(url="http://localhost:8000")
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
	//
}
