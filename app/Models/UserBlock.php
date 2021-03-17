<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserBlock extends Model
{
    protected $fillable = [ 
		'user_id', 
		'block_user_id' 
    ];

    public function BlockUser(){
  		return $this->belongsTo(User::class, 'block_user_id');
   	}

   	static function checkBlockUser($uid, $logdinUserId){
   		$blockUserData =  UserBlock::where('user_id', $logdinUserId)
   		 				->where('block_user_id' , $uid)
   		 				->get()->toArray();
		if(empty($blockUserData)){
			$blockUserData =  UserBlock::where('user_id', $uid)
   		 				->where('block_user_id' , $logdinUserId)
   		 				->get()->toArray();
		}

		return $blockUserData;

   	}
}
