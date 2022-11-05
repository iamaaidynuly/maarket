<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banners';

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
    protected $fillable = ['title', 'description', 'link', 'image_mobile', 'image_desktop'];

    public function getTitle(){
        return $this->hasOne(Translate::class, 'id','title');
    }
    public function getDescription()
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }


    
}
