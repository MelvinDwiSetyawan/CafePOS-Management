@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<h3 class="mb-3">Log Aktivitas</h3>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr><th>Waktu</th><th>User</th><th>Aktivitas</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->activity }}</td>
                    <td>{{ $log->description ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Belum ada aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</div>
@endsection
