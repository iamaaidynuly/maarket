<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'shows',
        'created_at',
        'updated_at',
    ];

    public function getTitle(){
        return $this->hasOne(Translate::class, 'id','title');
    }
    public function getContent()
    {
        return $this->hasOne(Translate::class, 'id', 'description');
    }
}
