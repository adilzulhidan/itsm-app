
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Request Form - PT. JTEKT INDONESIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Style tambahan agar terlihat seperti kertas dokumen */
        body { background-color: #f3f4f6; }
        .document-container {
            background: white;
            padding: 30px;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 40px auto;
        }
        .header-line { border-bottom: 2px solid black; margin-bottom: 20px; }
        .form-label { font-weight: bold; color: #374151; display: block; margin-bottom: 5px; }
        .form-input { width: 100%; border: 1px solid #9ca3af; padding: 8px 12px; }
        .auth-table th, .auth-table td { border: 1px solid black; padding: 10px; text-align: center; }
        .auth-table th { background-color: #e5e7eb; }
        .auth-box { height: 80px; vertical-align: bottom; color: #9ca3af; font-style: italic; }
    </style>
</head>
<body>

    <div class="bg-white shadow-sm py-4 px-6 mb-4">
        <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar Tiket</a>
    </div>

    @if (session('success'))
        <div class="max-w-3xl mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="document-container">
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex justify-between items-end header-line pb-4">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-jtekt.png') }}" alt="JTEKT Logo" class="h-12 mr-4">
                    
                </div>
                <div class="text-center flex-grow self-center">
                    <h2 class="text-2xl font-bold underline uppercase">IT REQUEST FORM</h2>
                </div>
                <div class="text-right">
                    <p class="font-bold">Date : <span class="font-normal border-b border-black px-2">{{ date('d M Y') }}</span></p>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Requester Name :</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full bg-gray-100 border-b border-black px-2 py-1 outline-none cursor-not-allowed font-bold">
                    </div>

                    <div>
                        <label class="form-label">Department : <span class="text-red-500">*</span></label>
                        <select name="department" class="form-input bg-white" required>
                            <option value="">-- Select Department --</option>
                            <option value="HRD/GA">HRD / GA</option>
                            <option value="Finance/Accounting">Finance / Accounting</option>
                            <option value="Production">Production</option>
                            <option value="Engineering">Engineering</option>
                            <option value="PPIC/Logistics">PPIC / Logistics</option>
                            <option value="Quality">Quality</option>
                            <option value="Purchasing/exim">Purchasing/Exim</option>
                            <option value="Sales">Sales</option>
                        </select>
                    </div>
                </div>

                <div class="border border-gray-400 p-4 bg-gray-50">
                    <label class="form-label mb-3">Request Type : <span class="text-red-500">*</span></label>
                    <div class="space-y-2 pl-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="Technical Support" class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>Technical Support</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="New Device" class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>New Device</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="Others" class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>Others</span>
                        </label>
                        <label class="form-label mb-3">Request Source : <span class="text-red-500">*</span></label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="Email" class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>Email</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="By Phone" class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>By Phone</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="In Person" class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>In Person</span>
                        </label>
                    </div>
                </div>
            </div>


            <div class="mb-6">
                <label class="form-label">Description / Details of Request : <span class="text-red-500">*</span></label>
                <textarea name="description" rows="6" class="form-input" placeholder="Please describe your request or problem details here..." required></textarea>
            </div>

            <div class="mb-8">
                <label class="form-label">Attachment (Optional) :</label>
                <input type="file" name="attachment" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100"/>
                <p class="text-xs text-gray-500 mt-1">Supported: JPG, PNG, PDF. Max 2MB.</p>
            </div>


            <div class="mt-12">
                <h3 class="font-bold mb-2">Authorization</h3>
                <table class="w-full auth-table border-collapse">
                    <thead>
                        <tr>
                            <th style="width: 33%;">Requester</th>
                            <th style="width: 33%;">Function Head (Approved By)</th>
                            <th style="width: 33%;">IT Dept Head (Processed By)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="auth-box bg-gray-50">
                                <span class="font-bold text-black">{{ Auth::user()->name }}</span><br>
                                <span class="text-xs">(Signed Digitally)</span>
                            </td>
                            <td class="auth-box">Ofline Approval Need</td>
                            <td class="auth-box">Ofline Approval Need</td>
                        </tr>
                        <tr>
                             <td class="text-xs text-left border-t-0">Date: {{ date('d/m/Y') }}</td>
                             <td class="text-xs text-left border-t-0">Date:</td>
                             <td class="text-xs text-left border-t-0">Date:</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end items-center gap-4">
                <button type="reset" class="text-gray-600 hover:text-gray-800 px-4 py-2">Reset Form</button>
                <button type="submit" class="bg-blue-800 text-white font-bold py-3 px-8 shadow-md hover:bg-blue-900 transition">
                    SUBMIT IT REQUEST
                </button>
            </div>

        </form>
    </div>

    <div class="max-w-[900px] mx-auto text-right text-xs text-gray-500 mt-2 font-mono">
        No. Dokumen: FR-IT-GNP-011-00 | Revisi: 00
    </div>

</body>
</html>