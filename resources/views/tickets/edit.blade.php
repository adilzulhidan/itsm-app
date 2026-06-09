<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit / Update Ticket - JTEKT ITSM</title>
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
            border-top: 5px solid #eab308; /* Warna kuning penanda form Update/Edit */
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
        .form-input:focus { border-color: #ca8a04; outline: none; ring: 2px solid #fef08a; box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.2); }
        
        .radio-group label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
        }
        .radio-group input[type="radio"] { margin-right: 12px; transform: scale(1.2); }
    </style>
</head>
<body>

    <div class="bg-white shadow-sm py-4 px-6 mb-4 border-b border-gray-200">
        <div class="max-w-[900px] mx-auto">
            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-700 hover:text-blue-900 font-bold flex items-center gap-2 transition">
                <i class="fas fa-arrow-left"></i> Batal & Kembali ke Detail
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="max-w-[900px] mx-auto bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-4 rounded shadow-sm">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
                <div>
                    <p class="font-bold">Gagal Memperbarui Data</p>
                    <ul class="list-disc pl-5 text-sm mt-1">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="document-container">
        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="flex justify-between items-end header-line">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-jtekt.png') }}" alt="JTEKT Logo" class="h-10 mr-4 opacity-90">
                </div>
                <div class="text-center flex-grow self-center px-4">
                    <h2 class="text-2xl font-bold uppercase tracking-wide text-gray-800" style="text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 4px;">
                        IT REQUEST UPDATE FORM
                    </h2>
                    <p class="text-[10px] font-mono mt-2 text-gray-500">TICKET REF: {{ $ticket->ticket_code }}</p>
                </div>
                <div class="text-right text-sm">
                    <p class="font-bold text-gray-500 uppercase tracking-wider text-xs mb-1">Created Date</p>
                    <p class="border-b border-black min-w-[130px] font-mono text-center pb-1 font-bold">{{ $ticket->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-xl mb-8 shadow-inner">
                <h3 class="font-bold text-yellow-900 border-b border-yellow-200 mb-4 pb-2 uppercase text-xs tracking-widest flex items-center gap-2">
                    <i class="fas fa-user-cog"></i> Technician / Administrator Control Area
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label text-yellow-800">Update Current Status :</label>
                        <select name="status" class="form-input bg-white border-yellow-400 font-bold text-gray-800 cursor-pointer">
                            <option value="Menunggu Persetujuan Manager" {{ $ticket->status == 'Menunggu Persetujuan Manager' ? 'selected' : '' }}>WAITING MANAGER APPROVAL</option>
                            <option value="Menunggu Persetujuan IT Head" {{ $ticket->status == 'Menunggu Persetujuan IT Head' ? 'selected' : '' }}>WAITING IT HEAD APPROVAL</option>
                            <option value="In Progress" {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>IN PROGRESS (ON WORK)</option>
                            <option value="Resolved" {{ $ticket->status == 'Resolved' ? 'selected' : '' }}>RESOLVED (FIXED)</option>
                            <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>CLOSED (FINISHED)</option>
                            <option value="Rejected" {{ $ticket->status == 'Rejected' ? 'selected' : '' }}>REJECTED</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-yellow-800">Priority Level :</label>
                        <select name="priority" class="form-input bg-white border-yellow-400 font-bold cursor-pointer">
                            <option value="low" {{ strtolower($ticket->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ strtolower($ticket->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ strtolower($ticket->priority) == 'high' ? 'selected' : '' }}>High (Urgent)</option>
                            <option value="critical" {{ strtolower($ticket->priority) == 'critical' ? 'selected' : '' }}>CRITICAL</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-6">
                
                <div class="md:col-span-7 space-y-5">
                    <div>
                        <label class="form-label">Requester Name :</label>
                        <input type="text" value="{{ $ticket->user->name }}" readonly 
                               class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 outline-none font-bold text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="form-label">Department :</label>
                        <select name="department" class="form-input bg-white cursor-pointer" {{ Auth::user()->role != 'admin' ? 'disabled' : '' }}>
                            @php
                                $depts = ['HRGA', 'Finance & Accounting', 'Production', 'Engineering', 'PPIC', 'QC', 'Purchasing/Exim', 'Sales', 'IT'];
                            @endphp
                            @foreach($depts as $dept)
                                <option value="{{ $dept }}" {{ $ticket->department == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Subject / Title :</label>
                        <input type="text" name="subject" value="{{ $ticket->subject }}" class="form-input" required>
                    </div>
                </div>

                <div class="md:col-span-5">
                    <div class="border border-gray-300 p-5 bg-gray-50 h-full rounded-xl shadow-sm">
                        <label class="form-label mb-3 text-base border-b border-gray-200 pb-2 flex items-center gap-2">
                            <i class="fas fa-th-large text-gray-600"></i> Category :
                        </label>
                        <div class="radio-group pl-1 text-sm text-gray-700 font-medium">
                            @php
                                $categories = [
                                    'Hardware' => 'Hardware (PC, Laptop, Mouse)',
                                    'Software' => 'Software (Office, Windows, Apps)',
                                    'Network' => 'Network (Internet, Wifi)',
                                    'Printer' => 'Printer & Scanner',
                                    'Account' => 'User Account & Email',
                                    'Other' => 'Other Request'
                                ];
                            @endphp
                            @foreach($categories as $val => $label)
                                <label>
                                    <input type="radio" name="category" value="{{ $val }}" {{ $ticket->category == $val ? 'checked' : '' }} required>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Detailed Description :</label>
                <textarea name="description" rows="6" class="form-input font-mono text-sm" required>{{ $ticket->description }}</textarea>
            </div>

            <div class="mt-10 flex justify-end items-center gap-4 pt-6 border-t border-gray-200">
                <button type="reset" class="text-gray-500 hover:text-red-600 px-4 py-2 font-bold transition text-sm">
                    Revert Changes
                </button>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-10 shadow-md rounded-lg flex items-center gap-2 transition transform hover:scale-[1.02]">
                    <i class="fas fa-save"></i> UPDATE DATA TICKET
                </button>
            </div>

        </form>
    </div>

    <div class="max-w-[900px] mx-auto text-right text-[10px] text-gray-400 mt-2 font-mono mb-10 uppercase tracking-widest">
        JTEKT ITSM System v1.0 | Authorized Personnel Only
    </div>

</body>
</html>