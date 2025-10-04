<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $fillable = ['id', 'text', 'question_id'];

	public $timestamps = false;
}
