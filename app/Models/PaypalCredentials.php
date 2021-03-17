<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalCredentials extends Model
{
    protected $fillable = ['sandbox_client_id','live_client_id'];
}
