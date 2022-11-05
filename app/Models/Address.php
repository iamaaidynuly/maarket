<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'adds',
        'city_id',
    ];

    public function getTitle()
    {
        return $this->hasOne(Translate::class, 'id','adds');
    }
}
