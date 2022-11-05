<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pay_status';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'transaction_id', 'description','amount', 'commission', 'commission_included','attempt', 'return_url', 'merchant_id','invoice_id', 'callback_url', 'date','date_out', 'demo', 'status', 'err_code', 'err_message'];
}
