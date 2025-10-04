<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Http\Requests\QuestionsStoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionsController extends Controller
{
	/**
	 * @OA\Get(
	 *     path="/api/v1/questions",
	 *     summary="Get all questions",
	 *     tags={"Questions"},
	 *     security={{"bearerAuth":{}}},
	 *     @OA\Response(
	 *         response=200,
	 *         description="List of questions",
	 *         @OA\JsonContent(
	 *             type="array",
	 *             @OA\Items(
	 *                 @OA\Property(property="id", type="integer"),
	 *                 @OA\Property(property="author_id", type="integer"),
	 *                 @OA\Property(property="text", type="string"),
	 *                 @OA\Property(property="created_at", type="string", format="date-time"),
	 *                 @OA\Property(property="updated_at", type="string", format="date-time")
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=401,
	 *         description="Unauthorized, missing or invalid token"
	 *     )
	 * )
	 */
	public function index(): JsonResponse
	{
		$questions = Question::all(['id', 'author_id', 'text', 'created_at', 'updated_at']);
		if ($questions->isEmpty()) {
			return response()->json(['message' => 'not found questions'], 404);
		}
		return response()->json($questions, 200);
	}

	/**
	 * @OA\Get(
	 *     path="/api/v1/questions/{id}",
	 *     summary="Get question with answers",
	 *     description="Returns a question by its ID along with all related answers.",
	 *     tags={"Questions"},
	 *     @OA\Parameter(
	 *         name="id",
	 *         in="path",
	 *         required=true,
	 *         description="Question ID",
	 *         @OA\Schema(type="integer")
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="Successful response with question and answers",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="id", type="integer", example=1),
	 *             @OA\Property(property="text", type="string", example="What is your favorite color?"),
	 *             @OA\Property(
	 *                 property="answers",
	 *                 type="array",
	 *                 @OA\Items(
	 *                     @OA\Property(property="id", type="integer", example=5),
	 *                     @OA\Property(property="text", type="string", example="Blue")
	 *                 )
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="Question not found",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="Question not found")
	 *         )
	 *     )
	 * )
	 */
	public function show(int $id): JsonResponse
	{
		$question = Question::with(['answers:id,text,question_id'])->find($id, ['id', 'text']);

		if (!$question) {
			return response()->json(['message' => 'Question not found'], 404);
		}

		return response()->json([
			'id' => $question->id,
			'text' => $question->text,
			'answers' => $question->answers,
		]);
	}

	/**
	 * @OA\Post(
	 *     path="/api/v1/questions",
	 *     summary="Add question",
	 *     tags={"Questions"},
	 *     security={{"bearerAuth": {}}},
	 *     @OA\RequestBody(
	 *         required=true,
	 *         @OA\JsonContent(
	 *             required={"question_text"},
	 *             @OA\Property(property="question_text", type="string"),
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=201,
	 *         description="question successful created",
	 *         @OA\JsonContent(@OA\Property(property="question_text", type="string"))
	 *     ),
	 * )
	 */
	public function store(QuestionsStoreRequest $request): JsonResponse
	{
		$data = $request->validated();
		$username = $request['user_payload']['username'];
		$user = User::where('username', $username)->firstOrFail();

		Question::create([
			'author_id' => $user->id,
			'text' => $data['question_text'],
		]);

		return response()->json(['message' => 'question successful created'], 201);
	}
}
