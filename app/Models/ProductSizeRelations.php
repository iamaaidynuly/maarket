<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSizeRelations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'p_s_relations';

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
    protected $fillable = ['product_id', 'size_item_id'];

    public function getSize(){
        return $this->hasOne(FilterItems::class, 'id','size_item_id');
    }
    public function getProducts(){
        return $this->hasMany(FilterItems::class, 'id','product_id');
    }
}
