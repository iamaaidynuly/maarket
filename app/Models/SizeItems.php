<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeItems extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'size_items';

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
    protected $fillable = ['title', 'size_id'];

    public function getTitle(){
        return $this->hasOne(Translate::class, 'id','title');
    }
    public function getParent(){
        return $this->hasOne(Size::class, 'id','size_id');
    }
}
