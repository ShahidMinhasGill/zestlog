<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AssessmentsQuestion extends Model
{
    protected $fillable = [ 
		'parent_id', 
		'title', 
	];

	static function getAssessmentsAnswer($userId,$questionId){
		return AssessmentsAnswer::where('assess_que_id', $questionId)->where('user_id', $userId)->first();
  	}

}
?>
