@extends('admin.layout', ['title' => 'Pages'])

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h6 class="text-muted mb-0">All pages</h6>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> New page</a>
</div>
<div class="card p-0">
    <table class="table mb-0 align-middle">
        <thead class="table-light">
            <tr><th>Title</th><th>Slug</th><th>Status</th><th>Sections</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($pages as $p)
            <tr>
                <td>
                    <a href="{{ route('admin.pages.edit', $p) }}" class="text-decoration-none fw-semibold">{{ $p->title }}</a>
                    @if($p->is_home)<span class="badge bg-info ms-1">Home</span>@endif
                </td>
                <td><code>/{{ $p->slug }}</code></td>
                <td>
                    @if($p->is_published)<span class="badge bg-success">Published</span>@else<span class="badge bg-secondary">Draft</span>@endif
                </td>
                <td>{{ $p->sections()->count() }}</td>
                <td class="text-end">
                    <a href="{{ $p->is_home ? url('/') : url($p->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="POST" action="{{ route('admin.pages.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Delete this page?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No pages yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $pages->links() }}</div>
@endsection
