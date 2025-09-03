<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'file_name',
        'file_path',
    ];

    // 🔗 Relation
    public function request()
    {
        return $this->belongsTo(RequestEntry::class, 'request_id');
    }
}
