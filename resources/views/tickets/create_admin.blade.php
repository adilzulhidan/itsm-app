<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Request Form (Admin Mode) - PT. JTEKT INDONESIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Style Dokumen Kertas (Sama dengan User) */
        body { background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .document-container {
            background: white;
            padding: 40px;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-width: 900px; /* Sedikit lebih lebar untuk admin */
            margin: 40px auto;
            position: relative;
            border-top: 5px solid #1e40af; /* Pembeda Visual untuk Admin (Garis Biru Atas) */
        }
        .header-line { border-bottom: 2px solid #333; margin-bottom: 25px; padding-bottom: 15px; }
        .form-label { font-weight: 600; color: #374151; display: block; margin-bottom: 6px; font-size: 0.95rem; }
        .form-input { 
            width: 100%; 
            border: 1px solid #9ca3af; 
            padding: 8px 12px; 
            border-radius: 4px;
            transition: border-color 0.2s;
        }
        .form-input:focus { border-color: #2563eb; outline: none; ring: 2px solid #bfdbfe; }
        
        .radio-group label { display: flex; align-items: center; margin-bottom: 8px; cursor: pointer; }
        .radio-group input[type="radio"] { margin-right: 10px; transform: scale(1.2); }
        
        /* Badge Admin */
        .admin-badge {
            background-color: #1e40af; color: white; padding: 5px 10px; 
            font-size: 0.7rem; font-weight: bold; border-radius: 4px; letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div class="bg-white shadow-sm py-3 px-6 mb-4 border-b border-gray-200">
        <div class="max-w-[900px] mx-auto">
            <a href="{{ route('tickets.index') }}" class="text-blue-700 hover:text-blue-900 font-medium flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="max-w-[900px] mx-auto bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="document-container">
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex justify-between items-end header-line">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-jtekt.png') }}" alt="JTEKT Logo" class="h-10 mr-4 grayscale opacity-80">
                </div>
                <div class="text-center flex-grow self-center px-4">
                    <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-800" style="text-decoration: underline; text-decoration-thickness: 2px;">
                        IT REQUEST FORM
                    </h2>
                    <span class="admin-badge">INTERNAL IT INPUT</span>
                </div>
                <div class="text-right text-sm">
                    <p class="font-bold text-gray-600">Date</p>
                    <p class="border-b border-black min-w-[120px] text-center pb-1">{{ date('d M Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-6">
                
                <div class="md:col-span-7 space-y-5">
                    
                    <div class="bg-blue-50 p-3 rounded border border-blue-200">
                        <label class="form-label text-blue-800"><i class="fas fa-user-tag mr-1"></i> Create For (Requester) :</label>
                        <select name="created_for_user" class="form-input bg-white border-blue-300 focus:ring-blue-500" required>
                            <option value="{{ Auth::id() }}">-- Diri Sendiri ({{ Auth::user()->name }}) --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} - {{ $u->department }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-blue-600 mt-1">*Pilih user jika Anda menginput tiket atas nama orang lain.</p>
                    </div>

                    <div>
                        <label class="form-label">Target Department (Override) :</label>
                        <select name="department" class="form-input bg-white">
                            <option value="">-- Auto (Sesuai User) --</option>
                            <option value="HRGA">HRGA</option>
                            <option value="Finance & Accounting">Finance & Accounting</option>
                            <option value="Production">Production</option>
                            <option value="Engineering">Engineering</option>
                            <option value="PPIC">PPIC</option>
                            <option value="QC">QC</option>
                            <option value="Purchasing/Exim">Purchasing/Exim</option>
                            <option value="Sales">Sales</option>
                            <option value="IT">IT</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Subject / Title : <span class="text-red-500">*</span></label>
                        <select name="subject" class="form-input bg-white cursor-pointer" required>
                            <option value="">-- Pilih Masalah / Request --</option>
                            
                            <optgroup label="Hardware / Perangkat">
                                <option value="Permintaan Mouse Baru">Permintaan Mouse Baru</option>
                                <option value="Permintaan Keyboard Baru">Permintaan Keyboard Baru</option>
                                <option value="Monitor Mati / Rusak">Monitor Mati / Rusak</option>
                                <option value="PC / Laptop Lambat">PC / Laptop Lambat</option>
                                <option value="Printer Macet / Error">Printer Macet / Error</option>
                            </optgroup>

                            <optgroup label="Software & Akun">
                                <option value="Install Ulang Windows/Office">Install Ulang Windows/Office</option>
                                <option value="Install Software Baru">Install Software Baru</option>
                                <option value="Permintaan Akun Email Baru">Permintaan Akun Email Baru</option>
                                <option value="Lupa Password / Reset">Lupa Password / Reset</option>
                                <option value="Error Aplikasi ERP/SAP">Error Aplikasi ERP/SAP</option>
                            </optgroup>

                            <optgroup label="Network / Jaringan">
                                <option value="Wifi Tidak Konek">Wifi Tidak Konek</option>
                                <option value="Kabel LAN Putus/Rusak">Kabel LAN Putus/Rusak</option>
                                <option value="Internet Lambat">Internet Lambat</option>
                            </optgroup>
                            
                            <optgroup label="Lainnya">
                                <option value="Peminjaman Proyektor">Peminjaman Proyektor</option>
                                <option value="Maintenance Rutin">Maintenance Rutin (IT Internal)</option>
                                <option value="Other Request">Lainnya</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Source :</label>
                            <select name="source" class="form-input bg-white">
                                <option value="Web System">Web System</option>
                                <option value="Email">Email</option>
                                <option value="Phone Call">Phone Call</option>
                                <option value="Direct/Walk-in">Direct / Walk-in</option>
                                <option value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Initial Priority :</label>
                            <select name="priority" class="form-input bg-white font-bold text-gray-700">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high" class="text-red-600">High</option>
                                <option value="critical" class="text-red-800 bg-red-100">CRITICAL</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-5">
                    <div class="border border-gray-400 p-5 bg-gray-50 h-full rounded shadow-sm">
                        <label class="form-label mb-3 text-lg border-b border-gray-300 pb-2">Category : <span class="text-red-500">*</span></label>
                        <div class="radio-group pl-1 text-sm text-gray-700">
                            
                            <label><input type="radio" name="category" value="Hardware" required> <span>Hardware</span></label>
                            <label><input type="radio" name="category" value="Software"> <span>Software</span></label>
                            <label><input type="radio" name="category" value="Network"> <span>Network</span></label>
                            <label><input type="radio" name="category" value="Printer"> <span>Printer & Scanner</span></label>
                            <label><input type="radio" name="category" value="Account"> <span>Account & Email</span></label>
                            <label><input type="radio" name="category" value="Other"> <span>Other Request</span></label>

                        </div>

                        <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded text-xs text-yellow-800">
                            <strong>Note:</strong> Tiket yang dibuat oleh Admin/IT Head akan otomatis melewati proses approval Manager User dan langsung masuk status <u>In Progress</u> atau <u>Approved</u>.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Description / Technical Details : <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="form-input" 
                          placeholder="Jelaskan detail masalah atau instruksi pengerjaan..." required></textarea>
            </div>

            <div class="mb-8 p-4 border border-dashed border-gray-400 rounded bg-gray-50">
                <label class="form-label mb-2">Attachment (Optional) :</label>
                <input type="file" name="attachment" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                    file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100 cursor-pointer" />
            </div>

            <div class="mt-8 flex justify-end items-center gap-4 pt-6 border-t border-gray-200">
                <button type="reset" class="text-gray-600 hover:text-red-600 px-4 py-2 font-medium transition text-sm">Reset</button>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-8 shadow-md rounded flex items-center gap-2 transition transform hover:scale-105">
                    <i class="fas fa-paper-plane"></i> CREATE TICKET
                </button>
            </div>

        </form>
    </div>

    <div class="max-w-[900px] mx-auto text-right text-[10px] text-gray-400 mt-2 font-mono mb-10">
        JTEKT ITSM System v1.0 | Mode: Administrator Input
    </div>

</body>
</html>