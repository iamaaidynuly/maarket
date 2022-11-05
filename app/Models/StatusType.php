<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'status_types';

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
    protected $fillable = ['name'];

    public function getName()
    {
        return $this->hasOne(Translate::class, 'id', 'name');
    }


}
