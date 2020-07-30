<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    /**
     * A role belongs to many abilities
     */
    public function abilities()
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }

    /**
     * Assign abilities to the role
     */
    public function allowTo($ability)
    {
        $this->abilities()->sync($ability, false);
    }

    /**
     * A role belongs to many users
     */
    public function backendUsers()
    {
        return $this->belongsToMany(BackendUser::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
