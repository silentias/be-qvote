<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
	protected $fillable = ['id', 'author_id', 'text'];

	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	public function answers(): HasMany
	{
		return $this->hasMany(Answer::class, 'question_id');
	}
}
