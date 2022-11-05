<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsBlockImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'about_us_block_id',
        'image',
    ];
}
