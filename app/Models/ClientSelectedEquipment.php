<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSelectedEquipment extends Model
{
    //
    protected $fillable = [
        'equipment_id',
        'user_id',
        'client_id',
        'unique_id',
    ];
}
