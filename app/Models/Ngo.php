<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ngo extends Model
{
    protected $fillable = ['name', 'contact_person', 'email', 'phone', 'address', 'city', 'state', 'is_active'];

    public function cases() { return $this->hasMany(ChildCase::class, 'assigned_ngo_id'); }
    public function users() { return $this->hasMany(User::class, 'ngo_id'); }
    public function stories() { return $this->hasMany(Story::class, 'ngo_id'); }
}
