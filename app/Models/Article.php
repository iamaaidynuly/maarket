<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'articles';

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
    protected $fillable = ['title', 'description', 'image'];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }
    public function getDescription()
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }
    public function metaTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'meta_title');
    }
    public function metaDesc()
    {
        return $this->hasOne(Translate::class, 'id', 'meta_description');
    }
}
