@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<style>
    html, body {
        overflow: hidden !important;
    }
    .activity-log-page {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: hidden;
    }
    #activity-log-scroll {
        max-height: calc(100vh - 220px);
        overflow-y: auto;
    }
    .pagination {
        display: none !important;
    }
</style>
<div class="activity-log-page">
    <div class="card" style="height: fit-content; margin: 0; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0;">
        <div class="card-body p-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Log Aktivitas</h5>
            <div class="btn-group btn-group-sm" role="group" aria-label="Scroll tabel">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="scrollActivityLog(-240)" title="Geser kiri">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="scrollActivityLog(240)" title="Geser kanan">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="activity-log-scroll" class="table-responsive">
            <table class="table table-sm table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 150px;">Waktu</th>
                        <th style="width: 120px;">User</th>
                        <th style="width: 150px;">Aktivitas</th>
                        <th>Keterangan</th>
                    </tr>
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
        </div>

        <div class="mt-2" style="margin-bottom: 0;">
            {{ $logs->links() }}
        </div>
    </div>
    </div>
</div>

<script>
function scrollActivityLog(amount) {
    const container = document.getElementById('activity-log-scroll');
    if (container) {
        container.scrollBy({ left: amount, behavior: 'smooth' });
    }
}
</script>
@endsection
