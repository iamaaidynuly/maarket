<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clicks';

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
    protected $fillable = ['phone_number', 'product_id'];

    public function getProducts(){
        return $this->hasOne(Product::class, 'id','product_id');
    }
}
