<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class Utils
{
	public static function decode_and_verify_signature($jwt)
	{
		try {
			$decoded = JWT::decode($jwt, new Key(config('jwt.secret'), 'HS256'));
			return [
				'valid' => true,
				'payload' => $decoded,
				'error' => null,
			];
		} catch (ExpiredException $e) {
			return [
				'valid' => false,
				'payload' => null,
				'error' => 'expired',
			];
		} catch (SignatureInvalidException $e) {
			return [
				'valid' => false,
				'payload' => null,
				'error' => 'invalid_signature',
			];
		} catch (\Exception $e) {
			return [
				'valid' => false,
				'payload' => null,
				'error' => 'other_error',
			];
		}
	}
}
