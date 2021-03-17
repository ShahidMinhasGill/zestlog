<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAcconut extends Model
{
    //
    protected $fillable = ['user_id', 'bank_holder', 'account_number', 'bic_code','email','birthday','address_line_one','address_line_two','city',
        'postal_code','country', 'swift', 'bank_name', 'meta_data', 'meta_description'];

}
