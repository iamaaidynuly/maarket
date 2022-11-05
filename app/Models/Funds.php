<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funds extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'min_count',
        'bonus',
        'created_at',
        'updated_at',
    ];
}
