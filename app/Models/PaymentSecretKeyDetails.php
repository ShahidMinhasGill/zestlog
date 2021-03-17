<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSecretKeyDetails extends Model
{
    protected $fillable = ['user_id','secret_key','amount','currency'];
}
