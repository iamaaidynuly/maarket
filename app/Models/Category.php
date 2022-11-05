<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

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
    protected $fillable = ['title', 'content', 'image', 'parent_id', 'slug', 'position', 'meta_title', 'meta_description'];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function getContent()
    {
        return $this->hasOne(Translate::class, 'id', 'content');
    }

    public function getParent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function getChilds()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getFilters()
    {
        return $this->hasMany(CategoryFilterRelations::class, 'category_id', 'id');
    }

    public function metaTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'meta_title');
    }

    public function metaDesc()
    {
        return $this->hasOne(Translate::class, 'id', 'meta_description');
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

}
