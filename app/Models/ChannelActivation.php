<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChannelActivation extends Model
{
    protected $fillable = [ 
		'health_fitness', 
        'specialization_one',
        'specialization_two',
        'specialization_three',
        'education_one_title',
		'education_one_from', 
		'education_one_certificate', 
        'education_two_title',
        'education_two_from', 
        'education_two_certificate', 
        'education_three_title', 
        'education_three_from',
        'education_three_certificate', 
        'introduction',
        'is_verify',
    	'meta_data', 
    	'meta_description',
        'is_coach_channel'
    ];

    public function user(){
  		return $this->belongsTo(User::class, 'user_id');
   	}
}
