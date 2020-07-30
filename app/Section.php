<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    protected $guarded = [];

    public function orientation()
    {
        return $this->belongsToMany(Orientation::class)->withTimestamps();
    }

    public function orientationMatches($orientationid)
    {
        return $this->orientation()->key_exists(['id' => $orientationid]);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
