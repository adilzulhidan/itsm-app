<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Request Form - PT. JTEKT INDONESIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .document-container {
            background: white;
            padding: 40px;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-width: 850px;
            margin: 40px auto;
            position: relative;
            border-top: 5px solid #4b5563; /* Garis abu-abu penanda form user biasa */
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
        .form-input:focus { border-color: #1e40af; outline: none; ring: 2px solid #bfdbfe; box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.2); }
        
        .auth-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .auth-table th, .auth-table td { border: 1px solid #333; padding: 10px; text-align: center; }
        .auth-table th { background-color: #f9fafb; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; }
        .signature-box { height: 90px; vertical-align: bottom; }
        
        .radio-group label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 6px;
            border-radius: 4px;
            transition: background 0.2s;
        }
        .radio-group label:hover { background-color: #f3f4f6; }
        .radio-group input[type="radio"] { margin-right: 12px; transform: scale(1.2); }
    </style>
</head>
<body>

    <div class="bg-white shadow-sm py-4 px-6 mb-4 border-b border-gray-200">
        <div class="max-w-[850px] mx-auto">
            <a href="{{ route('tickets.index') }}" class="text-blue-700 hover:text-blue-900 font-bold flex items-center gap-2 transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tiket
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="max-w-[850px] mx-auto bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-4 rounded shadow-sm flex items-start gap-3" role="alert">
            <i class="fas fa-check-circle text-green-500 text-xl mt-0.5"></i>
            <div>
                <p class="font-bold">Success</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-[850px] mx-auto bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-4 rounded shadow-sm flex items-start gap-3" role="alert">
            <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
            <div>
                <p class="font-bold">Terjadi Kesalahan Validasi</p>
                <ul class="list-disc pl-5 text-sm mt-1 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
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
                    <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-800" style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 4px;">IT REQUEST FORM</h2>
                </div>
                <div class="text-right text-sm">
                    <p class="font-bold text-gray-500 uppercase tracking-wider text-xs mb-1">Date</p>
                    <p class="border-b border-black min-w-[130px] font-mono text-center pb-1 font-bold">{{ date('d M Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-6">
                
                <div class="md:col-span-7 space-y-5">
                    <div>
                        <label class="form-label">Requester Name :</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly 
                               class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 outline-none font-bold text-gray-600 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="form-label">Department : <span class="text-red-500">*</span></label>
                        <select name="department" class="form-input bg-white cursor-pointer" required>
                            <option value="{{ Auth::user()->department }}" selected>{{ Auth::user()->department }}</option>
                            <option disabled>------------------------------------</option>
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
                        <label class="form-label">Subject / Title Masalah : <span class="text-red-500">*</span></label>
                        <select name="subject" class="form-input bg-white cursor-pointer" required>
                            <option value="">-- Pilih Jenis Gangguan --</option>
                            <option value="Technical Support">Technical Support (Masalah Teknis Perangkat)</option>
                            <option value="New Device">New Device (Permintaan/Pemasangan Alat Baru)</option>
                            <option value="Others">Others (Lain-lain)</option>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-5">
                    <div class="border border-gray-300 p-5 bg-gray-50 h-full rounded-xl shadow-sm">
                        <label class="form-label mb-3 text-base border-b border-gray-200 pb-2 flex items-center gap-2">
                            <i class="fas fa-th-large text-blue-800"></i> Category : <span class="text-red-500">*</span>
                        </label>
                        <div class="radio-group pl-1 text-sm text-gray-700 font-medium">
                            <label><input type="radio" name="category" value="Hardware" required> <span>Hardware (PC, Laptop, Mouse)</span></label>
                            <label><input type="radio" name="category" value="Software"> <span>Software (Office, Windows, Apps)</span></label>
                            <label><input type="radio" name="category" value="Network"> <span>Network (Internet, Wifi)</span></label>
                            <label><input type="radio" name="category" value="Printer"> <span>Printer & Scanner</span></label>
                            <label><input type="radio" name="category" value="Account"> <span>User Account & Email</span></label>
                            <label><input type="radio" name="category" value="Other"> <span>Other Request</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Description / Details of Request : <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="form-input" 
                          placeholder="Jelaskan secara rinci detail masalah Anda di sini (misal: Lokasi mesin/printer, kronologi kerusakan, pesan error yang muncul pada layar)..." required></textarea>
            </div>

            <div class="mb-8 p-4 border border-dashed border-gray-400 rounded-lg bg-gray-50 transition hover:bg-gray-100">
                <label class="form-label mb-2 flex items-center gap-2 text-gray-700">
                    <i class="fas fa-paperclip text-blue-700"></i> Attachment / Lampiran Foto Bukti (Optional) :
                </label>
                <input type="file" name="attachment" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-bold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                    cursor-pointer"
                />
                <p class="text-xs text-gray-500 mt-2 font-medium italic"><i class="fas fa-info-circle"></i> Ekstensi yang didukung: JPG, JPEG, PNG, PDF. Maksimal ukuran file: 2MB.</p>
            </div>

            <div class="mt-10">
                <h3 class="font-bold text-gray-700 mb-3 uppercase text-xs tracking-wider flex items-center gap-2">
                    <i class="fas fa-signature text-gray-500"></i> Authorization / Alur Tanda Tangan Dokumen
                </h3>
                <table class="auth-table">
                    <thead>
                        <tr>
                            <th style="width: 33%;">Requested By<br><span class="font-normal text-xs normal-case text-gray-500">(Pemohon)</span></th>
                            <th style="width: 33%;">Approved By<br><span class="font-normal text-xs normal-case text-gray-500">(Manager Dept.)</span></th>
                            <th style="width: 33%;">Processed By<br><span class="font-normal text-xs normal-case text-gray-500">(IT Dept.)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="signature-box bg-gray-50 relative">
                                <div class="absolute bottom-2 left-0 right-0 text-center flex flex-col items-center">
                                    <span class="font-bold text-gray-900 border-b border-black pb-0.5 block w-4/5 mx-auto text-sm">{{ Auth::user()->name }}</span>
                                    <span class="text-[10px] text-green-600 font-bold mt-1"><i class="fas fa-check-circle"></i> Signed System</span>
                                </div>
                            </td>
                            <td class="signature-box relative bg-white">
                                <div class="absolute bottom-5 left-0 right-0 text-center text-gray-400 italic text-xs font-medium">
                                    <i class="fas fa-clock opacity-60 mb-1 block text-sm"></i> (Waiting Manager)
                                </div>
                            </td>
                            <td class="signature-box relative bg-white">
                                <div class="absolute bottom-5 left-0 right-0 text-center text-gray-400 italic text-xs font-medium">
                                    <i class="fas fa-hourglass-half opacity-60 mb-1 block text-sm"></i> (Waiting IT Approval)
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end items-center gap-4 pt-6 border-t border-gray-200">
                <button type="reset" class="text-gray-500 hover:text-red-600 px-4 py-2 font-bold transition text-sm">
                    Reset Form
                </button>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-8 shadow-md rounded-lg flex items-center gap-2 transition transform hover:scale-[1.02] duration-200">
                    <i class="fas fa-paper-plane"></i> SUBMIT REQUEST
                </button>
            </div>

        </form>
    </div>

    <div class="max-w-[850px] mx-auto text-right text-[10px] text-gray-400 mt-2 font-mono mb-10">
        No. Dokumen: FR-IT-GNP-011-00 | JTEKT ITSM System v1.0
    </div>

</body>
</html>