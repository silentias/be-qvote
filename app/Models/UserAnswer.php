<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
	protected $table = 'users_answers';
	protected $fillable = ['id', 'user_id', 'answer_id'];
	public $timestamps = false;
}
