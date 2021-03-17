<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    protected $fillable = ['user_id', 'client_id','service_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
