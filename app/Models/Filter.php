<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'filters';

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
    protected $fillable = ['title'];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function getItems()
    {
        return $this->hasMany(FilterItems::class, 'filter_id', 'id');
    }
}
