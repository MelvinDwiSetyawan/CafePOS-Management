<div class="sidebar-cafe" style="width: 250px; min-height: 100vh;">
    <div class="p-3 brand">
        <h5 class="mb-0"><i class="bi bi-cup-hot"></i> CafePOS Pro</h5>
    </div>
    <nav class="nav flex-column p-2">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
            <a href="{{ route('admin.menus.index') }}" class="nav-link text-white {{ request()->routeIs('admin.menus.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-egg-fried"></i> Menu
            </a>
            <a href="{{ route('admin.tables.index') }}" class="nav-link text-white {{ request()->routeIs('admin.tables.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i> Meja
            </a>
            <a href="{{ route('admin.stocks.index') }}" class="nav-link text-white {{ request()->routeIs('admin.stocks.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-box-seam"></i> Stok
            </a>
            <a href="{{ route('admin.reports.index') }}" class="nav-link text-white {{ request()->routeIs('admin.reports.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" class="nav-link text-white {{ request()->routeIs('admin.activity-logs.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-clock-history"></i> Log Aktivitas
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-link text-white {{ request()->routeIs('admin.settings.*') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
        @elseif(auth()->user()->isKasir())
            <a href="{{ route('kasir.dashboard') }}" class="nav-link text-white {{ request()->routeIs('kasir.dashboard') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('kasir.transactions.create') }}" class="nav-link text-white {{ request()->routeIs('kasir.transactions.create') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-cart-plus"></i> Transaksi Baru
            </a>
            <a href="{{ route('kasir.transactions.index') }}" class="nav-link text-white {{ request()->routeIs('kasir.transactions.index') ? 'active bg-primary rounded' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Transaksi
            </a>
        @endif
    </nav>
</div>