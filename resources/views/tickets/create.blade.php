<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Request Form - PT. JTEKT INDONESIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Styles untuk meniru Form Kertas */
        body { background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .document-container {
            background: white;
            padding: 40px;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-width: 850px;
            margin: 40px auto;
            position: relative;
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
        
        .auth-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .auth-table th, .auth-table td { border: 1px solid #333; padding: 8px; text-align: center; }
        .auth-table th { background-color: #f3f4f6; font-size: 0.85rem; }
        .signature-box { height: 80px; vertical-align: bottom; }
        
        /* Radio Button Custom Style */
        .radio-group label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            cursor: pointer;
        }
        .radio-group input[type="radio"] { margin-right: 10px; transform: scale(1.2); }
    </style>
</head>
<body>

    <div class="bg-white shadow-sm py-3 px-6 mb-4 border-b border-gray-200">
        <div class="max-w-[850px] mx-auto">
            <a href="{{ route('tickets.index') }}" class="text-blue-700 hover:text-blue-900 font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Tiket
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="max-w-[850px] mx-auto bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-[850px] mx-auto bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm" role="alert">
            <p class="font-bold">Terjadi Kesalahan</p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="document-container">
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex justify-between items-end header-line">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-jtekt.png') }}" alt="JTEKT Logo" class="h-10 mr-4 grayscale opacity-80 hover:grayscale-0 transition">
                </div>
                <div class="text-center flex-grow self-center px-4">
                    <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-800" style="text-decoration: underline; text-decoration-thickness: 2px;">IT REQUEST FORM</h2>
                </div>
                <div class="text-right text-sm">
                    <p class="font-bold text-gray-600">Date</p>
                    <p class="border-b border-black min-w-[120px] text-center pb-1">{{ date('d M Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-6">
                
                <div class="md:col-span-7 space-y-5">
                    <div>
                        <label class="form-label">Requester Name :</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly 
                               class="w-full bg-gray-100 border-b-2 border-gray-400 px-2 py-1 outline-none font-bold text-gray-700 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="form-label">Department : <span class="text-red-500">*</span></label>
                        <select name="department" class="form-input bg-white" required>
                            <option value="{{ Auth::user()->department }}" selected>{{ Auth::user()->department }}</option>
                            <option disabled>----------------</option>
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
                            <option value="">----</option>
                            
                           
                                <option value="Technical Support">Technical Support</option>
                                <option value="New Device">New Device</option>
                                <option value="Others">Others</option>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-5">
                    <div class="border border-gray-400 p-5 bg-gray-50 h-full rounded shadow-sm">
                        <label class="form-label mb-3 text-lg border-b border-gray-300 pb-2">Category : <span class="text-red-500">*</span></label>
                        <div class="radio-group pl-1 text-sm text-gray-700">
                            
                            <label>
                                <input type="radio" name="category" value="Hardware" required>
                                <span>Hardware (PC, Laptop, Mouse)</span>
                            </label>

                            <label>
                                <input type="radio" name="category" value="Software">
                                <span>Software (Office, Windows, Apps)</span>
                            </label>

                            <label>
                                <input type="radio" name="category" value="Network">
                                <span>Network (Internet, Wifi)</span>
                            </label>
                            
                            <label>
                                <input type="radio" name="category" value="Printer">
                                <span>Printer & Scanner</span>
                            </label>

                            <label>
                                <input type="radio" name="category" value="Account">
                                <span>User Account & Email</span>
                            </label>

                            <label>
                                <input type="radio" name="category" value="Other">
                                <span>Other Request</span>
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Description / Details of Request : <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="form-input" 
                          placeholder="Jelaskan lebih detail masalah Anda di sini (misal: Lokasi printer, pesan error yang muncul, dll)..." required></textarea>
            </div>

            <div class="mb-8 p-4 border border-dashed border-gray-400 rounded bg-gray-50">
                <label class="form-label mb-2">Attachment / Lampiran (Optional) :</label>
                <input type="file" name="attachment" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                    cursor-pointer"
                />
                <p class="text-xs text-gray-500 mt-2 italic">* Supported: JPG, PNG, PDF. Max 2MB.</p>
            </div>

            <div class="mt-10">
                <h3 class="font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Authorization / Tanda Tangan</h3>
                <table class="auth-table">
                    <thead>
                        <tr>
                            <th style="width: 33%;">Requested By<br><span class="font-normal text-xs">(Pemohon)</span></th>
                            <th style="width: 33%;">Approved By<br><span class="font-normal text-xs">(Manager Dept.)</span></th>
                            <th style="width: 33%;">Processed By<br><span class="font-normal text-xs">(IT Dept.)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="signature-box bg-gray-50 relative">
                                <div class="absolute bottom-2 left-0 right-0 text-center">
                                    <span class="font-bold text-black border-b border-black pb-1 block w-3/4 mx-auto">{{ Auth::user()->name }}</span>
                                    <span class="text-[10px] text-gray-500 mt-1 block">Date: {{ date('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="signature-box relative">
                                <div class="absolute bottom-4 left-0 right-0 text-center text-gray-400 italic text-xs">
                                    (Waiting for Approval)
                                </div>
                            </td>
                            <td class="signature-box relative">
                                <div class="absolute bottom-4 left-0 right-0 text-center text-gray-400 italic text-xs">
                                    (IT Processing)
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end items-center gap-4 pt-6 border-t border-gray-200">
                <button type="reset" class="text-gray-600 hover:text-red-600 px-4 py-2 font-medium transition text-sm">
                    Reset Form
                </button>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-8 shadow-md rounded flex items-center gap-2 transition transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    SUBMIT REQUEST
                </button>
            </div>

        </form>
    </div>

    <div class="max-w-[850px] mx-auto text-right text-[10px] text-gray-400 mt-2 font-mono mb-10">
        No. Dokumen: FR-IT-GNP-011-00 | JTEKT ITSM System v1.0
    </div>

</body>
</html>