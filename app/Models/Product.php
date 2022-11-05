<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

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
    protected $fillable = [
        'title',
        'artikul',
        'description',
        'specifications', 'price', 'sale', 'current_price', 'brand_id', 'country_id', 'stock', 'slug', 'meta_title', 'meta_description', 'best',
        'funds_1',
        'funds_2',
    ];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }
    // public function getShort(){
    //     return $this->hasOne(Translate::class, 'id','short_description');
    // }
    public function getDesc()
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function getSpec()
    {
        return $this->hasOne(Translate::class, 'id', 'specifications');
    }

    public function metaTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'meta_title');
    }

    public function metaDesc()
    {
        return $this->hasOne(Translate::class, 'id', 'meta_description');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function priceTypes()
    {
        return $this->hasMany(ProductPriceTypes::class, 'product_id', 'id');
    }

}
