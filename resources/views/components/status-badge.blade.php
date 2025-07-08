@php
    $record = $getRecord();
    $status = strtolower($record?->status->nama_status ?? 'Belum ada');
    $color = match ($status) {
        'diajukan' => 'bg-gray-100 text-gray-800',
        'direkap' => 'bg-yellow-100 text-yellow-800',
        'disetujui' => 'bg-green-100 text-green-800',
        'ditolak' => 'bg-red-100 text-red-800',
        default => 'bg-gray-300 text-gray-900',
    };
@endphp

@if ($record)
    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
        {{ ucfirst($status) }}
    </span>
@else
    <span class="text-gray-500 text-sm">Status belum tersedia</span>
@endif