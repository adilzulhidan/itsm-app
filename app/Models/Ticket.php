<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'ticket_code',
    'subject',
    'department',
    'source',
    'category',
    'priority',
    'status',
    'description',
    'attachment',
    'approved_by_manager_id',
    'manager_approved_at',
    'approved_by_it_id',
    'it_approved_at',
    'rejected_by_id',
    'rejection_reason',
    'rejected_at'
];
        public function managerApprover()
    {
        return $this->belongsTo(User::class, 'approved_by_manager_id');
    }
    public function itApprover()
    {
        return $this->belongsTo(User::class, 'approved_by_it_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}