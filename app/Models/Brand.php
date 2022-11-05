<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'brands';

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
    protected $fillable = ['title', 'content', 'image', 'table_size', 'slug', 'popular', 'meta_title', 'meta_description'];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function getContent()
    {
        return $this->hasOne(Translate::class, 'id', 'content');
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
