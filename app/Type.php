<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //

    public function sections()
    {
        return $this->belongsToMany(Section::class)->withTimestamps();
    }
}
