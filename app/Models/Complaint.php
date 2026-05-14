<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'tracking_id', 'reporter_name', 'reporter_phone',
        'description', 'location', 'city', 'photo_path',
        'status', 'admin_notes', 'case_id'
    ];

    public function childCase() { return $this->belongsTo(ChildCase::class, 'case_id'); }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }
}
