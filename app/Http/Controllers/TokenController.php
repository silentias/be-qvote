<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenVerify;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Helpers\Utils;

class TokenController extends Controller
{
	/**
	 * @OA\Post(
	 *     path="/api/v1/user/token/verify",
	 *     summary="Verify JWT token",
	 *     tags={"Users"},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"accessToken"},
	 *             @OA\Property(property="accessToken", type="string"),
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="token is valid",
	 *         @OA\JsonContent(@OA\Property(property="accessToken", type="string"))
	 *     ),
	 *     @OA\Response(
	 *         response=401,
	 *         description="Invalid token"
	 *     )
	 * )
	 */
	public function verify(TokenVerify $request): JsonResponse
	{
		$data = $request->validated();
		$encoded = Utils::decode_and_verify_signature($data['accessToken']);
		if (!$encoded['valid']) {
			return response()->json(['message' => $encoded['error']], 401);
		}
		return response()->json(['message' => 'token is valid'], 200);
	}
}
