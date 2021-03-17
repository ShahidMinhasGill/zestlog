<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserFollower extends Model
{
    protected $fillable = [ 
		'follower', 
		'following' 
    ];

    public function UserFollower(){ 
  		return $this->belongsTo(User::class, 'follower');
   	}
    
    public function UserFollowing(){
      return $this->belongsTo(User::class, 'following');
    }

    static function checkFollower($follower, $following){
      return UserFollower::where('follower', $follower)
                    ->where('following', $following)
                    ->first();
    }

    static function checkFollowing($follower, $following){
      return UserFollower::where('follower', $following)
                    ->where('following', $follower)
                    ->first();
    }
}
?>
