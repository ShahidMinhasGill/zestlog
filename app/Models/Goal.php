<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goals';
    protected $primaryKey = 'id';
}
