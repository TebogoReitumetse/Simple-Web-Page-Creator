<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} · {{ \App\Models\Setting::get('site_name', 'CMS') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --ink:#111111;
            --muted:#6b7280;
            --line:#ececec;
            --surface:#ffffff;
            --bg:#fafafa;
            --hover:#f4f4f5;
        }
        body { background: var(--bg); color: var(--ink); font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        h1,h2,h3,h4,h5,h6 { color: var(--ink); }
        .text-muted { color: var(--muted) !important; }

        /* Sidebar — light, clean */
        .sidebar { background: var(--surface); min-height:100vh; border-right:1px solid var(--line); }
        .sidebar .brand { color:var(--ink); font-weight:700; padding:.5rem .75rem 1rem; font-size:1.05rem; display:flex; align-items:center; gap:.5rem; }
        .sidebar a {
            color:#4b5563; text-decoration:none; display:flex; align-items:center;
            padding:.55rem .75rem; border-radius:10px; font-size:.92rem; font-weight:500;
            transition: background .12s, color .12s;
        }
        .sidebar a:hover { background:var(--hover); color:var(--ink); }
        .sidebar a.active { background:var(--hover); color:var(--ink); font-weight:600; }
        .sidebar .nav-label { font-size:.72rem; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af; padding:.5rem .75rem .25rem; }
        .sidebar hr { border-color:var(--line); opacity:1; }

        /* Topbar */
        .topbar { background:var(--surface); border-bottom:1px solid var(--line); }
        .topbar h5 { font-weight:600; }

        /* Cards & surfaces */
        .card, .section-card {
            background:var(--surface); border:1px solid var(--line);
            border-radius:16px; box-shadow:0 1px 2px rgba(0,0,0,.03);
        }
        .table { --bs-table-bg: transparent; }
        .table-light, .table > thead { --bs-table-bg:#fafafa; }
        code { color:var(--ink); background:var(--hover); padding:.1rem .35rem; border-radius:6px; }

        /* Buttons — black & white */
        .btn { border-radius:10px; font-weight:500; }
        .btn-success, .btn-dark {
            background-color:var(--ink); border-color:var(--ink); color:#fff;
        }
        .btn-success:hover, .btn-dark:hover,
        .btn-success:focus, .btn-dark:focus,
        .btn-success:active, .btn-dark:active {
            background-color:#000; border-color:#000; color:#fff;
        }
        /* Save / submit buttons — brand green with black text */
        .btn-primary {
            background-color:#65fe08; border-color:#65fe08; color:#111;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color:#4fcc06; border-color:#4fcc06; color:#111;
        }
        .btn-outline-secondary, .btn-outline-primary, .btn-outline-dark {
            border-color:#d4d4d8; color:#3f3f46;
        }
        .btn-outline-secondary:hover, .btn-outline-primary:hover, .btn-outline-dark:hover {
            background-color:var(--ink); border-color:var(--ink); color:#fff;
        }
        .btn-outline-danger { border-color:#e4b4b4; color:#b42318; }
        .btn-outline-danger:hover { background-color:#b42318; border-color:#b42318; color:#fff; }
        .btn-link { color:var(--ink); }

        /* Content links — brand green */
        .content-area a:not(.btn) { color:#65fe08; }
        .content-area a:not(.btn):hover { color:#4fcc06; }

        /* Forms */
        .form-control, .form-select {
            border-radius:10px; border-color:#e4e4e7;
        }
        .form-control:focus, .form-select:focus {
            border-color:#9ca3af; box-shadow:0 0 0 .2rem rgba(17,17,17,.06);
        }
        .form-check-input:checked { background-color:var(--ink); border-color:var(--ink); }

        /* Badges — quiet, monochrome-ish */
        .badge.bg-success { background-color:#111 !important; }
        .badge.bg-secondary { background-color:#9ca3af !important; }
        .badge.bg-info { background-color:#374151 !important; }

        .alert { border-radius:12px; border:1px solid var(--line); }

        /* Admin footer */
        .admin-footer {
            border-top:1px solid var(--line);
            background:var(--surface);
            color:var(--muted);
            font-size:.82rem;
        }
        .admin-footer a { color:#65fe08; text-decoration:none; font-weight:600; }
        .admin-footer a:hover { color:#4fcc06; text-decoration:underline; }
    </style>
</head>
<body>
<div class="d-flex">
    <aside class="sidebar p-3 d-flex flex-column" style="width: 248px;">
        <div class="brand">
            <i class="bi bi-grid-3x3-gap-fill"></i> {{ \App\Models\Setting::get('site_name', 'CMS') }}
        </div>
        <div class="nav-label">Menu</div>
        <nav class="nav flex-column gap-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text me-2"></i>Pages</a>
            <a href="{{ route('admin.nav.index') }}" class="{{ request()->routeIs('admin.nav.*') ? 'active' : '' }}"><i class="bi bi-list me-2"></i>Navigation</a>
            <a href="{{ route('admin.footer.index') }}" class="{{ request()->routeIs('admin.footer.*') ? 'active' : '' }}"><i class="bi bi-layout-text-window-reverse me-2"></i>Footer</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i>Users</a>
            <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="bi bi-gear me-2"></i>Settings</a>
        </nav>
        <div class="mt-auto pt-3">
            <hr>
            <a href="{{ url('/') }}" target="_blank" class="mb-2"><i class="bi bi-box-arrow-up-right me-2"></i>View site</a>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf
                <button class="btn btn-sm btn-outline-secondary w-100"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
            </form>
        </div>
    </aside>
    <div class="flex-grow-1 d-flex flex-column min-vh-100">
        <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@yield('page_title', $title ?? 'Admin')</h5>
            <div class="d-flex align-items-center gap-2 small text-muted">
                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
            </div>
        </div>
        <div class="p-4 content-area flex-grow-1">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
        <footer class="admin-footer px-4 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'CMS') }}. All rights reserved.</span>
            <span>
                Created by
                <a href="https://desire2cr8.co.za" target="_blank" rel="noopener">desire2cr8</a>
            </span>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
