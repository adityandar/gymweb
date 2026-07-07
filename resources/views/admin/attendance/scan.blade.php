@extends('layouts.admin')
@section('title', 'Scan QR - GymFlow')

@section('content')
<h1 class="text-2xl font-bold mb-6">Scan Attendance QR</h1>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Scan via Camera</h2>
        <div id="reader" class="w-full"></div>
        <p id="scan-result" class="mt-2 text-sm text-green-600 hidden">QR scanned!</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Manual Input</h2>
        <form method="POST" action="{{ route('admin.attendance.scan') }}">
            @csrf
            <textarea name="token" rows="4" placeholder="Paste QR token here..."
                      class="w-full border border-gray-300 rounded px-3 py-2 mb-3"></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
        </form>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const scanner = new Html5Qrcode("reader");
    scanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        (decodedText) => {
            scanner.stop();
            document.getElementById('scan-result').classList.remove('hidden');
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.attendance.scan') }}';
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = 'token';
            token.value = decodedText;
            form.appendChild(csrf);
            form.appendChild(token);
            document.body.appendChild(form);
            form.submit();
        },
        () => {}
    );
</script>
@endsection
