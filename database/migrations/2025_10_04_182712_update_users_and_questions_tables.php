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
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('tg_id');
		});
		Schema::table('questions', function (Blueprint $table) {
			$table->foreignId('author_id')->constrained('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('questions', function (Blueprint $table) {
			$table->dropForeign(['author_id']);
			$table->dropColumn('author_id');
		});

		Schema::table('users', function (Blueprint $table) {
			$table->bigInteger('tg_id');
		});
	}
};
