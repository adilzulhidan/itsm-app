<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // --- 1. DAFTAR ASET (INDEX) ---
    public function index(Request $request)
    {
        $query = Asset::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('asset_code', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%');
            });
        }

        // Tampilkan data terbaru, 10 per halaman dengan relasi user
        $assets = $query->latest()->with('user')->paginate(10);
        
        return view('assets.index', compact('assets'));
    }

    // --- 2. FORM TAMBAH (CREATE) ---
    public function create()
    {
        $users = User::all();
        return view('assets.create', compact('users'));
    }

    // --- 3. SIMPAN DATA (STORE) ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'serial_number' => 'required|unique:assets,serial_number',
            'status' => 'required',
        ]);

        // Generate Kode: AST-YYYYMMDD-XXXX
        $code = 'AST-' . date('Ymd') . '-' . strtoupper(substr(md5(time()), 0, 4));

        Asset::create([
            'asset_code'    => $code,
            'name'          => $request->name,
            'type'          => $request->type,
            'serial_number' => $request->serial_number,
            'purchase_date' => $request->purchase_date,
            'status'        => $request->status,
            'location'      => $request->location,
            'assigned_to'   => $request->assigned_to,
        ]);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil didaftarkan!');
    }

    // --- 4. FORM EDIT (EDIT) ---
    public function edit(Asset $asset)
    {
        $users = User::all();
        return view('assets.edit', compact('asset', 'users'));
    }

    public function show(Asset $asset)
    {
        // Pastikan relasi user diambil juga
        $asset->load('user'); 
        return view('assets.show', compact('asset'));
    }

    // --- 5. UPDATE DATA (UPDATE) ---
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required',
            // Validasi unik kecuali untuk aset ini sendiri
            'serial_number' => 'required|unique:assets,serial_number,' . $asset->id,
        ]);

        // Update spesifik agar aman
        $asset->update([
            'name'          => $request->name,
            // 'type'       => $request->type, // Tipe biasanya tidak diubah saat edit, tapi boleh dibuka jika perlu
            'serial_number' => $request->serial_number,
            'purchase_date' => $request->purchase_date ?? $asset->purchase_date,
            'status'        => $request->status,
            'location'      => $request->location,
            'assigned_to'   => $request->assigned_to,
        ]);

        return redirect()->route('assets.index')->with('success', 'Data aset diperbarui!');
    }

    // --- 6. HAPUS DATA (DESTROY) ---
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Aset dihapus dari sistem.');
    }
}