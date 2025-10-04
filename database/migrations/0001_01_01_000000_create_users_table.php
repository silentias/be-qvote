<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('questions', function (Blueprint $table) {
			$table->id();
			$table->string('text');
			$table->timestamps();
		});

		Schema::create('answers', function (Blueprint $table) {
			$table->id();
			$table->string('text');
			$table->foreignId('question_id')->constrained()->onDelete('cascade');
		});

		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('username');
			$table->bigInteger('tg_id');
		});

		Schema::create('users_answers', function (Blueprint $table) {
			$table->id();
			$table->foreignId('answer_id')->constrained()->onDelete('cascade');
			$table->foreignId('user_id')->constrained()->onDelete('cascade');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('users_answers');
		Schema::dropIfExists('answers');
		Schema::dropIfExists('questions');
		Schema::dropIfExists('users');
	}
};
