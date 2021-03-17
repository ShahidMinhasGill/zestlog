<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientCurrency extends Model
{
    protected $fillable = ['client_id', 'currency_id'];

    /**
     * This is used to get client currency
     *
     * @param $params
     * @return mixed
     */
    public static function getCurrency($params)
    {
        $obj = ClientCurrency::select('code')->where('client_id', '=', $params['client_id'])
            ->join('currencies as c', 'c.id', '=', 'currency_id')->first();
        $currency = '';
        if (!empty($obj)) {
            $currency = $obj->code;
        }

        return $currency;
    }
}
