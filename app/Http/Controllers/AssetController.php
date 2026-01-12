<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('asset_code', 'LIKE', "%{$search}%")
                  ->orWhere('serial_number', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $assets = $query->paginate(10);
        $assets->appends($request->all());

        return view('assets.index', compact('assets'));
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.show', compact('asset'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'required|unique:assets|string|max:50',
            'type' => 'nullable|string|max:100',
            'serial_number' => 'required|unique:assets|string|max:100',
            'location' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'purchase_date' => 'nullable|date',
        ]);

        Asset::create($request->all());

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan');
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.edit', compact('asset'));
    }

    
    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'required|string|max:50|unique:assets,asset_code,' . $id,
            'type' => 'nullable|string|max:100',
            'serial_number' => 'required|string|max:100|unique:assets,serial_number,' . $id,
            'location' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'purchase_date' => 'nullable|date',
        ]);

        $asset->update($request->all());

        return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui');
    }

    
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus');
    }

    
    public function showImportForm() 
    {
        return view('assets.import');
    }

    
    public function importProcess(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $importedCount = 0;
        $updatedCount = 0;
        $skippedCount = 0;
        
        try {
            DB::beginTransaction();
            
            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                
                
                fgetcsv($handle, 1000, ';'); 

                while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                    
                    if (empty(array_filter($row))) {
                        $skippedCount++;
                        continue;
                    }

                    if (count($row) < 10) {
                        $skippedCount++;
                        continue;
                    }
                    
                    $rawDate = $row[16] ?? null;
                    $purchaseDate = null;
                    
                    
                    if ($rawDate && strlen($rawDate) >= 10) {
                        try {
                            $dateStr = substr($rawDate, 0, 10);
                            $purchaseDate = date('Y-m-d', strtotime($dateStr));
                        } catch (\Exception $e) {
                            $purchaseDate = null;
                        }
                    }

                    $serialNumber = $row[14] ?? null;
                    
                    
                    if (empty($serialNumber)) {
                        $skippedCount++;
                        continue;
                    }

                    
                    $existingAsset = Asset::where('serial_number', $serialNumber)->first();

                    if ($existingAsset) {
                        
                        $existingAsset->update([
                            'name'          => $row[0] ?? $existingAsset->name,
                            'status'        => $row[1] ?? $existingAsset->status,
                            'type'          => $row[6] ?? $existingAsset->type,
                            'location'      => $row[9] ?? $existingAsset->location,
                            'asset_code'    => !empty($row[15]) ? $row[15] : $existingAsset->asset_code,
                            'purchase_date' => $purchaseDate ?? $existingAsset->purchase_date,
                        ]);
                        $updatedCount++;
                    } else {
                        
                        Asset::create([
                            'name'          => $row[0] ?? 'Unknown',
                            'status'        => $row[1] ?? 'Active',
                            'type'          => $row[6] ?? 'Unknown',
                            'location'      => $row[9] ?? 'Unknown',
                            'serial_number' => $serialNumber,
                            'asset_code'    => !empty($row[15]) ? $row[15] : null,
                            'purchase_date' => $purchaseDate,
                        ]);
                        $importedCount++;
                    }
                }
                fclose($handle);
            }

            DB::commit();
            
            $message = "Import berhasil! ";
            if ($importedCount > 0) {
                $message .= "{$importedCount} data baru ditambahkan. ";
            }
            if ($updatedCount > 0) {
                $message .= "{$updatedCount} data diperbarui. ";
            }
            if ($skippedCount > 0) {
                $message .= "{$skippedCount} baris dilewati.";
            }
            
            return redirect()->route('assets.index')->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('assets.import.form')->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}