<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLogs extends Model
{
    use HasFactory;

    protected $primaryKey = 'audit_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'action_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
