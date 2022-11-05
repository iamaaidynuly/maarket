<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticSeo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'static_seos';

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
    protected $fillable = ['title','meta_title', 'meta_description','page'];

    public function metaTitle(){
        return $this->hasOne(Translate::class, 'id','meta_title');
    }
    public function metaDesc(){
        return $this->hasOne(Translate::class, 'id','meta_description');
    }
    
}
