<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIdentity extends Model
{
    protected $fillable = ['user_id','is_identity_verified','identity_verified_by','first_name',
        'middle_name','last_name','birthday','id_photo','ids_type'];
}
