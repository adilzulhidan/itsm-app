<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit / Process Ticket - JTEKT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
    </style>
</head>
<body>

    <div class="bg-white shadow-sm py-4 px-6 mb-4">
        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline">&larr; Batal & Kembali ke Detail</a>
    </div>

    <div class="document-container">
        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="flex justify-between items-end header-line pb-4">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-jtekt.png') }}" alt="JTEKT Logo" class="h-10 mr-4">
                    <div>
                        <h1 class="text-lg font-extrabold tracking-wider">JTEKT</h1>
                        <p class="text-xs font-bold">PT. JTEKT INDONESIA</p>
                    </div>
                </div>
                <div class="text-center flex-grow self-center">
                    <h2 class="text-xl font-bold underline uppercase">IT REQUEST UPDATE FORM</h2>
                    <p class="text-xs font-mono mt-1 text-gray-500">Ref: {{ $ticket->ticket_code }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-sm">Date : <span class="font-normal">{{ $ticket->created_at->format('d M Y') }}</span></p>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-300 p-4 rounded mb-8">
                <h3 class="font-bold text-yellow-800 border-b border-yellow-300 mb-3 pb-1 uppercase text-sm">Technician / Admin Area</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="form-label text-sm">Update Status :</label>
                        <select name="status" class="form-input bg-white font-bold text-gray-800">
                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>OPEN (Baru Masuk)</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>IN PROGRESS (Sedang Dikerjakan)</option>
                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>RESOLVED (Selesai Dikerjakan)</option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>CLOSED (Tutup Tiket)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-sm">Priority Level :</label>
                        <select name="priority" class="form-input bg-white">
                            <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High (Urgent)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Requester Name :</label>
                        <input type="text" value="{{ $ticket->user->name }}" readonly class="w-full bg-gray-100 border-b border-black px-2 py-1 outline-none text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="form-label">Department :</label>
                        <select name="department" class="form-input bg-white">
                            <option value="HRD/GA" {{ $ticket->department == 'HRD/GA' ? 'selected' : '' }}>HRD / GA</option>
                            <option value="Finance/Accounting" {{ $ticket->department == 'Finance/Accounting' ? 'selected' : '' }}>Finance / Accounting</option>
                            <option value="Production" {{ $ticket->department == 'Production' ? 'selected' : '' }}>Production</option>
                            <option value="Engineering" {{ $ticket->department == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="PPIC/Logistics" {{ $ticket->department == 'PPIC/Logistics' ? 'selected' : '' }}>PPIC / Logistics</option>
                            <option value="Quality" {{ $ticket->department == 'Quality' ? 'selected' : '' }}>Quality</option>
                        </select>
                    </div>
                </div>

                <div class="border border-gray-400 p-4 bg-gray-50">
                    <label class="form-label mb-3">Request Type :</label>
                    <div class="space-y-2 pl-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="Technical Support" {{ $ticket->category == 'Technical Support' ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>Technical Support</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="New Device" {{ $ticket->category == 'New Device' ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>New Device</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="Others" {{ $ticket->category == 'Others' ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>Others</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="Others" {{ $ticket->category == 'Email' ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>Email</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="category" value="Others" {{ $ticket->category == 'Helpdesk' ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600 mr-2">
                            <span>Helpdesk</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="form-label">Subject / Title :</label>
                <input type="text" name="subject" value="{{ $ticket->subject }}" class="form-input">
            </div>

            <div class="mb-6">
                <label class="form-label">Description / Details :</label>
                <textarea name="description" rows="6" class="form-input">{{ $ticket->description }}</textarea>
            </div>

            <div class="mt-8 flex justify-end items-center gap-4 pt-4 border-t border-gray-300">
                <a href="{{ route('tickets.show', $ticket->id) }}" class="text-gray-600 hover:text-gray-800 px-4">Cancel</a>
                <button type="submit" class="bg-blue-800 text-white font-bold py-3 px-8 shadow-md hover:bg-blue-900 transition rounded">
                    UPDATE DATA
                </button>
            </div>

        </form>
    </div>

</body>
</html>