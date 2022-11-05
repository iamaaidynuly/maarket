<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    const TYPE_AUTH = 1;
    const TYPE_NON_AUTH = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promocodes';

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
    protected $fillable = ['code', 'active', 'user_id', 'sale', 'exp_date', 'sale_price', 'type'];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
