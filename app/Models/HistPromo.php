<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistPromo extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hist_promo';

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
    protected $fillable = ['code_id', 'user_id'];

    public function getCode(){
        return $this->hasOne(Promocode::class, 'id','code_id');
    }

    public function getUser(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
