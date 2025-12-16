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
        'purchase_date', 
        'status', 
        'location', 
        'assigned_to'
    ];

    // --- [TAMBAHKAN FUNGSI INI] ---
    // Fungsi ini memberitahu Laravel bahwa aset ini milik seorang User
    public function user()
    {
        // 'assigned_to' adalah nama kolom foreign key di tabel assets
        return $this->belongsTo(User::class, 'assigned_to');
    }
}