<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';

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
    protected $fillable = [
        'phone_number',
        'email',
        'address',
        'description',
        'title',
        'whats_app',
        'telegram',
        'instagram',
        'vk',
        'facebook',
        'meta_title',
        'meta_description',
        'main_address',
        'map',
        'retail_sale',
        'wholesale',
    ];

    protected $casts = [
        'phone_number'  =>  'array',
    ];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function getDescription()
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }

    public function getAddress()
    {
        return $this->hasOne(Translate::class, 'id', 'main_address');
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
