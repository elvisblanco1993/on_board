<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('signed_at');
    }

    public function orientations()
    {
        return $this->belongsToMany(Orientation::class)->withTimestamps();
    }
}
