<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'status',
        'paper_orientation',
        'body_bg',
        'cert_bg',
        'cert_border_out_color',
        'cert_border_out_radius',
        'cert_border_out_thickness',
        'cert_border_out_style',
        'cert_border_in_color',
        'cert_border_in_radius',
        'cert_border_in_thickness',
        'cert_border_in_style',
        'cert_text_color',
        'footer_text_color',
    ];

    public function orientation()
    {
        return $this->belongsToMany(Orientation::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
