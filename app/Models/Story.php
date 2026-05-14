<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'case_id', 'child_id', 'ngo_id', 'content', 'status', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function case()  { return $this->belongsTo(ChildCase::class, 'case_id'); }
    public function child() { return $this->belongsTo(Child::class, 'child_id'); }
    public function ngo()   { return $this->belongsTo(Ngo::class, 'ngo_id'); }
}
