<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_code', 
        'name', 
        'type', 
        'serial_number', 
        'last_inventory_date', 
        'status', 
        'location', 
        'assigned_to'
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function user()
    {

        return $this->belongsTo(User::class, 'assigned_to');
    }

   public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                // Kolom yang sudah ada
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('asset_code', 'like', '%' . $search . '%')
                      ->orWhere('serial_number', 'like', '%' . $search . '%')
                      
                      // --- TAMBAHAN BARU (Agar Type & Lokasi bisa dicari) ---
                      ->orWhere('type', 'like', '%' . $search . '%')
                      ->orWhere('location', 'like', '%' . $search . '%')
                      ->orWhere('status', 'like', '%' . $search . '%');
            });
        });
    }
}