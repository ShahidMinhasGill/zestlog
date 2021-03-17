<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AssessmentsAnswer extends Model
{
    protected $fillable = [ 
        'user_id',
        'assess_que_id',
        'answer', 
		'ans_text', 
    ];

    


}
?>
