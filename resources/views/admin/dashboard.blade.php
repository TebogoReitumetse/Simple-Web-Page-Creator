@extends('admin.layout', ['title' => 'Dashboard'])

@section('content')
<div class="row g-3 mb-4">
    @foreach([
        ['Pages', $stats['pages'], 'file-earmark-text', 'admin.pages.index'],
        ['Sections', $stats['sections'], 'layout-three-columns', null],
        ['Nav Items', $stats['nav_items'], 'list', 'admin.nav.index'],
        ['Footer Items', $stats['footer_items'], 'layout-text-window-reverse', 'admin.footer.index'],
        ['Users', $stats['users'], 'people', 'admin.users.index'],
    ] as [$label, $count, $icon, $route])
        <div class="col-md-4 col-lg">
            <div class="card p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">{{ $label }}</div>
                        <div class="h3 mb-0">{{ $count }}</div>
                    </div>
                    <i class="bi bi-{{ $icon }} text-secondary" style="font-size:1.6rem;"></i>
                </div>
                @if($route)
                    <a href="{{ route($route) }}" class="stretched-link"></a>
                @endif
            </div>
        </div>
    @endforeach
</div>

<div class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Daily page visits</h6>
        <span class="text-muted small">Last 30 days</span>
    </div>
    <canvas id="visitsChart" height="90"></canvas>
</div>

<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Recent pages</h6>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> New page</a>
    </div>
    <table class="table table-sm mb-0">
        <thead><tr><th>Title</th><th>Slug</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($recentPages as $p)
            <tr>
                <td>{{ $p->title }} @if($p->is_home)<span class="badge bg-info ms-1">Home</span>@endif</td>
                <td><code>{{ $p->slug }}</code></td>
                <td>
                    @if($p->is_published)<span class="badge bg-success">Published</span>@else<span class="badge bg-secondary">Draft</span>@endif
                </td>
                <td class="text-end"><a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm btn-outline-secondary">Edit</a></td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted py-3">No pages yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('visitsChart'), {
        type: 'line',
        data: {
            labels: @json($visitLabels),
            datasets: [{
                label: 'Visits',
                data: @json($visitData),
                borderColor: '#65fe08',
                backgroundColor: 'rgba(101,254,8,.12)',
                fill: true,
                tension: .35,
                pointRadius: 3,
                pointBackgroundColor: '#65fe08',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
</script>
@endpush
