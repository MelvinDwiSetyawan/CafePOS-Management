<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CafePOS Pro')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --coffee-dark: #000000;
            --coffee-darker: #090909;
            --coffee-panel: #111111;
            --coffee-card: #1b1b1b;
            --coffee-border: #2a2a2a;
            --gold: #ffffff;
            --gold-soft: #f8f9fa;
            --text-light: #f8f9fa;
            --text-muted: #c2c2c2;
        }

        body {
            background-color: var(--coffee-darker);
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar */
        .sidebar-cafe {
            background: linear-gradient(180deg, var(--coffee-dark) 0%, var(--coffee-darker) 100%);
            border-right: 1px solid var(--coffee-border);
        }
        .sidebar-cafe .brand {
            color: var(--gold-soft);
            border-bottom: 1px solid var(--coffee-border);
        }
        .sidebar-cafe .nav-link {
            color: var(--text-light);
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all .2s ease;
        }
        .sidebar-cafe .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: #ffffff;
        }
        .sidebar-cafe .nav-link.active {
            background: #ffffff !important;
            color: #000000 !important;
            font-weight: 600;
        }

        /* Navbar */
        .navbar-cafe {
            background-color: var(--coffee-panel) !important;
            border-bottom: 1px solid var(--coffee-border) !important;
        }
        .navbar-cafe .navbar-text {
            color: var(--text-light) !important;
        }

        /* Cards */
        .card {
            background-color: var(--coffee-card);
            border: 1px solid var(--coffee-border);
            color: var(--text-light);
        }
        .card h5, .card h6, .card h3, .card h4 {
            color: var(--text-light);
        }

        /* Tables */
        .table {
            background-color: #1a1d27;
            color: var(--text-light);
        }
        .table thead {
            background-color: #222634;
            color: var(--text-light);
            border-bottom: 1px solid #2f3441;
        }
        .table th, .table td {
            border-color: #2f3441 !important;
        }
        .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: #191c26;
            color: var(--text-light);
        }
        .table-striped > tbody > tr:nth-of-type(even) > * {
            background-color: #1f2230;
            color: var(--text-light);
        }
        .table-hover tbody tr:hover > * {
            background-color: #2d3140;
        }
        .table-responsive {
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            background-color: #171a23;
        }
        .btn-pdf {
            background-color: #141926;
            border-color: rgba(255,255,255,0.12);
            color: var(--text-light);
        }
        .btn-pdf:hover {
            background-color: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.16);
            color: var(--text-light);
        }

        /* Forms */
        .form-control, .form-select {
            background-color: var(--coffee-panel);
            border: 1px solid var(--coffee-border);
            color: var(--text-light);
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--coffee-panel);
            border-color: var(--gold);
            color: var(--text-light);
            box-shadow: 0 0 0 0.25rem rgba(212, 166, 86, 0.15);
        }
        .form-label {
            color: var(--text-muted);
        }
        .form-control::placeholder {
            color: rgba(237, 228, 218, 0.75);
            opacity: 0.75;
        }
        .text-muted {
            color: rgba(237, 228, 218, 0.75) !important;
        }

        /* Buttons */
        .btn-primary {
            background-color: #ffffff;
            border-color: #ffffff;
            color: #000000;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #f1f1f1;
            border-color: #f1f1f1;
            color: #000000;
        }
        .btn-outline-secondary, .btn-secondary {
            background-color: transparent;
            border-color: #ffffff;
            color: #ffffff;
        }
        .btn-outline-secondary:hover {
            background-color: #ffffff;
            color: #000000;
        }

        /* Modal */
        .modal-content {
            background-color: var(--coffee-card);
            color: var(--text-light);
            border: 1px solid var(--coffee-border);
        }
        .modal-header, .modal-footer {
            border-color: var(--coffee-border);
        }

        /* Badges tetap warna asli Bootstrap (biar status jelas kebaca) */

        /* DataTables search box & pagination */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background-color: var(--coffee-panel);
            border: 1px solid var(--coffee-border);
            color: var(--text-light);
        }
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            color: #f8f9fa !important;
        }
        .page-link {
            background-color: var(--coffee-panel);
            border-color: var(--coffee-border);
            color: var(--gold-soft);
        }
        .page-item.active .page-link {
            background-color: var(--gold);
            border-color: var(--gold);
            color: #1a1310;
        }

        /* Alerts */
        .alert-success {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
            color: #f8f9fa;
        }

        a {
            text-decoration: none;
        }

        @stack('styles')
    </style>
</head>
<body>
    <div class="d-flex">
        @include('layouts.partials.sidebar')

        <div class="flex-grow-1">
            @include('layouts.partials.navbar')

            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>
