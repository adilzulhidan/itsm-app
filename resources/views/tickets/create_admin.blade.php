<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Request Form (Admin Mode) - PT. JTEKT INDONESIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .document-container {
            background: white;
            padding: 40px;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 40px auto;
            position: relative;
            border-top: 5px solid #1e40af; /* Garis Biru Atas penanda khusus Admin/IT */
        }
        .header-line { border-bottom: 2px solid #333; margin-bottom: 25px; padding-bottom: 15px; }
        .form-label { font-weight: 600; color: #374151; display: block; margin-bottom: 6px; font-size: 0.95rem; }
        .form-input { 
            width: 100%; 
            border: 1px solid #9ca3af; 
            padding: 10px 12px; 
            border-radius: 6px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .form-input:focus { border-color: #2563eb; outline: none; ring: 2px solid #bfdbfe; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2); }
        
        .radio-group label { display: flex; align-items: center; margin-bottom: 10px; cursor: pointer; padding: 5px; border-radius: 4px; transition: background 0.2s; }
        .radio-group label:hover { background-color: #f3f4f6; }
        .radio-group input[type="radio"] { margin-right: 12px; transform: scale(1.2); }
        
        .admin-badge {
            background-color: #1e40af; color: white; padding: 6px 14px; 
            font-size: 0.75rem; font-weight: bold; border-radius: 6px; letter-spacing: 1.5px;
            display: inline-block; margin-top: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="bg-white shadow-sm py-4 px-6 mb-4 border-b border-gray-200">
        <div class="max-w-[900px] mx-auto">
            <a href="{{ route('tickets.index') }}" class="text-blue-700 hover:text-blue-900 font-bold flex items-center gap-2 transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard Utama
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="max-w-[900px] mx-auto bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-4 rounded shadow-sm flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
            <div>
                <p class="font-bold">Terjadi Kesalahan Validasi Input</p>
                <ul class="list-disc pl-5 text-sm mt-1 space-y-1">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="document-container">
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex justify-between items-end header-line">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-jtekt.png') }}" alt="JTEKT Logo" class="h-10 mr-4 opacity-90">
                </div>
                <div class="text-center flex-grow self-center px-4">
                    <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-800" style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 4px;">
                        IT REQUEST FORM
                    </h2>
                    <span class="admin-badge"><i class="fas fa-user-shield mr-1"></i> INTERNAL IT INPUT MODE</span>
                </div>
                <div class="text-right text-sm">
                    <p class="font-bold text-gray-500 uppercase tracking-wider text-xs mb-1">Date</p>
                    <p class="border-b border-black min-w-[130px] font-mono text-center pb-1 font-bold">{{ date('d M Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-6">
                
                <div class="md:col-span-7 space-y-5">
                    
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-200 shadow-inner">
                        <label class="form-label text-blue-900 flex items-center gap-1 font-bold">
                            <i class="fas fa-user-tag text-blue-700"></i> Create For (Requester / Pemohon asli) :
                        </label>
                        <select name="created_for_user" class="form-input bg-white border-blue-400 focus:ring-blue-500 font-medium cursor-pointer mt-1" required>
                            <option value="{{ Auth::id() }}">-- Diri Sendiri ({{ Auth::user()->name ?? 'Admin' }}) --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} [Department: {{ $u->department ?? 'Tidak Ada' }}]</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-blue-600 mt-2 font-medium">* Silakan ganti nama di atas jika Anda menginput keluhan via Walk-In / Telepon atas nama karyawan lain.</p>
                    </div>

                    <div>
                        <label class="form-label">Target Department (Override Manual) :</label>
                        <select name="department" class="form-input bg-white cursor-pointer">
                            <option value="">-- Otomatis (Sesuai Departemen User Pemohon) --</option>
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
                        <label class="form-label">Subject / Judul Masalah Terstruktur : <span class="text-red-500">*</span></label>
                        <select name="subject" class="form-input bg-white cursor-pointer font-medium" required>
                            <option value="">-- Pilih Masalah / Jenis Kerusakan --</option>
                            
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
                            <label class="form-label">Source Laporan :</label>
                            <select name="source" class="form-input bg-white cursor-pointer">
                                <option value="Web System">Web System</option>
                                <option value="Email">Email</option>
                                <option value="Phone Call">Phone Call</option>
                                <option value="Direct/Walk-in">Direct / Walk-in</option>
                                <option value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Initial Priority Level :</label>
                            <select name="priority" class="form-input bg-white font-bold text-gray-700 cursor-pointer">
                                <option value="low" class="text-green-600">Low</option>
                                <option value="medium" selected class="text-yellow-600">Medium</option>
                                <option value="high" class="text-orange-600">High</option>
                                <option value="critical" class="text-red-700 bg-red-50">CRITICAL</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-5">
                    <div class="border border-gray-300 p-5 bg-gray-50 h-full rounded-xl shadow-sm flex flex-col justify-between">
                        <div>
                            <label class="form-label mb-3 text-base border-b border-gray-200 pb-2 flex items-center gap-2">
                                <i class="fas fa-th-large text-blue-800"></i> Category : <span class="text-red-500">*</span>
                            </label>
                            <div class="radio-group pl-1 text-sm text-gray-700 font-medium">
                                <label><input type="radio" name="category" value="Hardware" required> <span>Hardware</span></label>
                                <label><input type="radio" name="category" value="Software"> <span>Software</span></label>
                                <label><input type="radio" name="category" value="Network"> <span>Network</span></label>
                                <label><input type="radio" name="category" value="Printer"> <span>Printer & Scanner</span></label>
                                <label><input type="radio" name="category" value="Account"> <span>Account & Email</span></label>
                                <label><input type="radio" name="category" value="Other"> <span>Other Request</span></label>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-xs text-yellow-800 leading-relaxed font-medium">
                            <i class="fas fa-info-circle"></i> <strong>Sistem Otomatisasi:</strong><br>
                            Tiket yang dibuat langsung oleh Admin/IT Head akan otomatis memotong jalur birokrasi (*Bypass* approval Manager User) sesuai logika pada <strong>TicketController</strong>.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Description / Technical Details : <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="form-input" 
                          placeholder="Tuliskan catatan teknis lengkap atau kronologi kerusakan yang dilaporkan oleh user..." required></textarea>
            </div>

            <div class="mb-8 p-4 border border-dashed border-gray-400 rounded-lg bg-gray-50">
                <label class="form-label mb-2 flex items-center gap-2 text-gray-700">
                    <i class="fas fa-paperclip text-blue-700"></i> Attachment / Dokumen Pendukung (Optional) :
                </label>
                <input type="file" name="attachment" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                    file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100 cursor-pointer" />
            </div>

            <div class="mt-8 flex justify-end items-center gap-4 pt-6 border-t border-gray-200">
                <button type="reset" class="text-gray-500 hover:text-red-600 px-4 py-2 font-bold transition text-sm">Reset Form</button>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-8 shadow-md rounded-lg flex items-center gap-2 transition transform hover:scale-[1.02] duration-200">
                    <i class="fas fa-plus-circle"></i> CREATE TICKET
                </button>
            </div>

        </form>
    </div>

    <div class="max-w-[900px] mx-auto text-right text-[10px] text-gray-400 mt-2 font-mono mb-10">
        JTEKT ITSM System v1.0 | Mode: Internal IT Input Mode
    </div>

</body>
</html>