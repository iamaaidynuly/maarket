<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorRelations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'color_relations';

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
    protected $fillable = ['product_id', 'color_id'];

    
}
