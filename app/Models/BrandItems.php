<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandItems extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'brand_items';

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
    protected $fillable = ['title', 'brand_id'];

    public function getTitle(){
        return $this->hasOne(Translate::class, 'id','title');
    }
    public function getParent(){
        return $this->hasOne(Brand::class, 'id','brand_id');
    }
}
