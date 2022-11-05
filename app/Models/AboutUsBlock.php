<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsBlock extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'about_us_blocks';

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
    protected $fillable = ['image', 'title', 'description', 'url', 'slug', 'image_mobile'];

    public function getTitle(){
        return $this->hasOne(Translate::class, 'id','title');
    }

    public function getDescription()
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }
}
