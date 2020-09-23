<?php

namespace App;

use App\Events\UserCreatedEvent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * A user has many roles
     * Example: Elvis =>admin, student, advisor
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Assign roles to the user
     */
    public function assignRole($role)
    {
        $this->roles()->sync($role, false);
    }

    /**
     * Display all abilities the user has
     */
    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }

    /**
     * Get roles from user
     */
    public function getRoles()
    {
        return $this->roles->flatten()->pluck('name')->unique();
    }

    /**
     * Grab the user's orientations list
     */
    public function orientations()
    {
        return $this->belongsToMany(Orientation::class)->withTimestamps()->withPivot('completed_at');
    }

    /**
     * User progress at any orientation
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class)->withTimestamps();
    }

    /**
     * Get the user's assessment questions
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    /**
     * Get the user's assessment answers
     */
    public function answers()
    {
        return $this->belongsToMany(Answer::class)->withTimestamps();
    }

    /**
     * Get user completion certificates
     */
    public function certificates()
    {
        return $this->belongsToMany(Certificate::class)->withTimestamps();
    }

    /**
     * Get the user signatures
     */
    public function signatures () {
        return $this->belongsToMany(Signature::class)->withTimestamps();
    }
}
