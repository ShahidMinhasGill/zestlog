<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_categories';
    protected $primaryKey = 'id';
}
