<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterItems extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'filter_items';

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
    protected $fillable = ['title', 'filter_id'];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function getParent()
    {
        return $this->hasOne(Filter::class, 'id', 'filter_id');
    }
}
