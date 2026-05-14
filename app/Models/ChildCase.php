<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildCase extends Model
{
    protected $table = 'child_cases';

    protected $fillable = [
        'case_number', 'complaint_id', 'assigned_ngo_id',
        'assigned_to_type', 'status', 'location', 'city',
        'description', 'admin_notes', 'rescued_at', 'rehabilitated_at'
    ];

    protected $casts = [
        'rescued_at'      => 'datetime',
        'rehabilitated_at' => 'datetime',
    ];

    public function complaint()  { return $this->belongsTo(Complaint::class); }
    public function ngo()        { return $this->belongsTo(Ngo::class, 'assigned_ngo_id'); }
    public function child()      { return $this->hasOne(Child::class, 'case_id'); }
    public function updates()    { return $this->hasMany(CaseUpdate::class, 'case_id')->latest(); }
    public function stories()    { return $this->hasMany(Story::class, 'case_id'); }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'            => 'warning',
            'under_investigation'=> 'info',
            'rescued'            => 'primary',
            'rehabilitated'      => 'success',
            default              => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'            => 'Pending',
            'under_investigation'=> 'Under Investigation',
            'rescued'            => 'Rescued',
            'rehabilitated'      => 'Rehabilitated',
            default              => ucfirst($this->status),
        };
    }
}
