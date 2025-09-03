<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'current_level',
        'user_id',
    ];

    // 👇 Relation with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 👇 Relation with approvals
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'request_id');
    }
}
