<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoiceStoreRequest;
use App\Models\Answer;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoiceController extends Controller
{
	/**
	 * @OA\Post(
	 *     path="/api/v1/voices",
	 *     summary="Vote for an answer",
	 *     tags={"Voices"},
	 *     security={{"bearerAuth":{}}},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"answer_id"},
	 *             @OA\Property(property="answer_id", type="integer", example=1)
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=201,
	 *         description="Successfully voted",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="successfull voice")
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="Answer not found",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="answer not found")
	 *         )
	 *     )
	 * )
	 */
	public function store(VoiceStoreRequest $request): JsonResponse
	{
		$data = $request->validated();
		$username = $request['user_payload']['username'];

		$user = User::where('username', $username)->first();
		if (!$user) {
			return response()->json(['message' => 'user not found'], 404);
		}

		$answer = Answer::find($data['answer_id']);
		if (!$answer) {
			return response()->json(['message' => 'answer not found'], 404);
		}

		UserAnswer::create([
			'user_id' => $user->id,
			'answer_id' => $answer->id,
		]);

		return response()->json(['message' => 'successful voice'], 201);
	}
}
