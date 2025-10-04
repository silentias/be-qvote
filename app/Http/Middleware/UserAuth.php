<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Helpers\Utils;

class UserAuth
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */

	public function handle(Request $request, Closure $next): JsonResponse
	{
		$authHeader = $request->header('Authorization');

		if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
			return response()->json(
				[
					'message' => 'Authorization header missing or malformed',
				],
				401,
			);
		}

		$jwt = substr($authHeader, 7);
		$result = Utils::decode_and_verify_signature($jwt);

		if (!$result['valid']) {
			return response()->json(['message' => $result['error']], 401);
		}
		$request->merge(['user_payload' => (array) $result['payload']]);
		return $next($request);
	}
}
