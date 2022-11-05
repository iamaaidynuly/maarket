<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryFilterRelations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'c_f_relations';

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
    protected $fillable = ['category_id', 'filter_id'];

    public function getFilter(){
        return $this->hasOne(Filter::class, 'id', 'filter_id');
    }

    public function getCategories(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
