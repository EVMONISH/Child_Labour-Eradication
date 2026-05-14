<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'case_id', 'name', 'age', 'gender',
        'rescue_location', 'rescue_city', 'rescue_date',
        'school_name', 'school_enrolled',
        'guardian_name', 'guardian_phone', 'guardian_relation',
        'health_status', 'notes', 'photo_path'
    ];

    protected $casts = ['rescue_date' => 'date', 'school_enrolled' => 'boolean'];

    public function case() { return $this->belongsTo(ChildCase::class, 'case_id'); }
    public function story() { return $this->hasOne(Story::class, 'child_id'); }
}
