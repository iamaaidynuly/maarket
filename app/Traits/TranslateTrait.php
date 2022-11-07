<?php
namespace App\Traits;

use App\Models\Translate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait TranslateTrait
{
    public function translate($name)
    {
        return $this->hasOne(Translate::class, 'id', $name);
    }
}
