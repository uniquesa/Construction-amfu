<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'approver_id',
        'level',
        'status',
        'comments',
        'acted_at',
    ];

    // 🔗 Relations
    public function request()
    {
        return $this->belongsTo(RequestEntry::class, 'request_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
