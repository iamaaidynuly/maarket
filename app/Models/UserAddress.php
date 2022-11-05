<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'region_id',
        'city_id',
        'user_id',
        'address',
        'apartment'
    ];

    public function getRegion()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function getCity()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
