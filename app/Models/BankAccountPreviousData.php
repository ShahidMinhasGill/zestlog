<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccountPreviousData extends Model
{
    //
    protected $fillable = ['user_id', 'bank_holder', 'account_number', 'bic_code', 'swift', 'bank_name', 'meta_data', 'meta_description'];

}
