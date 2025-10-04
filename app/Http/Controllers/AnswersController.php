<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswersStoreRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;

class AnswersController extends Controller
{
	/**
	 * @OA\Post(
	 *     path="/api/v1/answers",
	 *     summary="Create an answer to a question",
	 *     description="Creates a new answer for a given question. Requires Bearer JWT authentication.",
	 *     tags={"Answers"},
	 *
	 *     security={{"bearerAuth": {}}},
	 *
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"question_id", "text"},
	 *             @OA\Property(
	 *                 property="question_id",
	 *                 type="integer",
	 *                 example=5,
	 *                 description="The ID of the question to answer"
	 *             ),
	 *             @OA\Property(
	 *                 property="text",
	 *                 type="string",
	 *                 example="This is my answer to your question.",
	 *                 description="The content of the answer"
	 *             )
	 *         )
	 *     ),
	 *
	 *     @OA\Response(
	 *         response=201,
	 *         description="Answer successfully created",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="answer successfully created")
	 *         )
	 *     ),
	 *
	 *     @OA\Response(
	 *         response=404,
	 *         description="Question or user not found",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="question not found")
	 *         )
	 *     )
	 * )
	 */
	public function store(AnswersStoreRequest $request): JsonResponse
	{
		$data = $request->validated();
		$username = $request['user_payload']['username'];

		$question = Question::where('id', $data['question_id'])
			->whereHas('author', fn($q) => $q->where('username', $username))
			->first();

		if (!$question) {
			return response()->json(['message' => 'question not found'], 404);
		}

		Answer::create(['text' => $data['text'], 'question_id' => $data['question_id']]);
		return response()->json(['message' => 'answer succesfull created'], 201);
	}
}
