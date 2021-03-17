<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [ 
		'log_pic', 
		'description', 
		'privacy', 
		'log_category_id', 
		'is_deleted', 
    	'meta_data', 
    	'meta_description'
    ];

    public function user(){
  		return $this->belongsTo(User::class, 'user_id');
   	}
}
