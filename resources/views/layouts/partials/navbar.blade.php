<nav class="navbar navbar-cafe px-4">
    <div class="container-fluid px-0 d-flex justify-content-between align-items-center">
        <div class="text-end d-none d-md-block">
            <div class="fw-semibold">{{ auth()->user()->name }}</div>
            <small class="text-muted">{{ auth()->user()->role->name ?? 'Pengguna' }}</small>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</nav>