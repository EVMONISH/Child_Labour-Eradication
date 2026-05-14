<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseUpdate extends Model
{
    protected $fillable = ['case_id', 'updated_by', 'status', 'note', 'document_path'];

    public function case()    { return $this->belongsTo(ChildCase::class, 'case_id'); }
    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }
}
