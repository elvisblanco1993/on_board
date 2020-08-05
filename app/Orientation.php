<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orientation extends Model
{
    //
    protected $guarded = [];

    public function sections()
    {
        return $this->belongsToMany(Section::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('completed_at');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class)->withTimestamps();
    }

    /**
     * Append a section to an Orientation
     */
    public function appendSection($section)
    {
        $this->sections()->sync($section, false);
    }
}
