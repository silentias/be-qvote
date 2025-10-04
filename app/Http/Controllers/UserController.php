<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Firebase\JWT\JWT;

use App\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
	/**
	 * @OA\Post(
	 *     path="/api/v1/user/login",
	 *     summary="Login without Telegram",
	 *     tags={"Users"},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"telegram_data"},
	 *             @OA\Property(property="telegram_data", type="string"),
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Successful login",
	 *         @OA\JsonContent(@OA\Property(property="accessToken", type="string"))
	 *     ),
	 *     @OA\Response(
	 *         response=401,
	 *         description="Invalid hash"
	 *     )
	 * )
	 */
	public function login(UserLoginRequest $request): JsonResponse
	{
		$data = $request->validated();

		$secret_key = hash('sha256', config('app.tg_bot_token'));
		$calculated_hash = hash_hmac('sha256', $data['telegram_data'], $secret_key);

		/*
		if (isset($data['hash']) && hash_equals($calculated_hash, $data['hash'])) {
			$dataArray = [];
			parse_str($data['telegram_data'], $dataArray);
			$username = $dataArray['username'] ?? null;
			$payload = [
				'username' => $username,
				'iat' => time(),
				'exp' => time() + config('jwt.ttl'),
			];
			$jwt = JWT::encode($payload, config('jwt.secret'), 'HS256');
			return response()->json(['accessToken' => $jwt], 200);
		} else {
			return response()->json(['message' => 'invalid hash'], 401);
		}
		*/

		$dataArray = [];
		parse_str($data['telegram_data'], $dataArray);
		$username = $dataArray['username'] ?? null;
		$payload = [
			'username' => $username,
			'role' => 'user',
			'iat' => time(),
			'exp' => time() + config('jwt.ttl'),
		];
		User::create([
			'username' => $payload['username'],
		]);
		$jwt = JWT::encode($payload, config('jwt.secret'), 'HS256');
		return response()->json(['accessToken' => $jwt], 200);
	}
}
