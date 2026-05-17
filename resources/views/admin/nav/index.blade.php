@extends('admin.layout', ['title' => 'Navigation'])

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="text-muted mb-3">Add nav item</h6>
            <form method="POST" action="{{ route('admin.nav.store') }}">
                @csrf
                <div class="mb-2"><label class="form-label small">Label</label><input name="label" class="form-control form-control-sm" required></div>
                <div class="mb-2"><label class="form-label small">URL</label><input name="url" class="form-control form-control-sm" placeholder="/about or https://..." required></div>
                <div class="mb-3 form-check"><input type="checkbox" id="active1" name="is_active" value="1" class="form-check-input" checked><label for="active1" class="form-check-label small">Active</label></div>
                <button class="btn btn-primary btn-sm">Add</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light"><tr><th>Label</th><th>URL</th><th>Active</th><th>Order</th><th></th></tr></thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <form method="POST" action="{{ route('admin.nav.update', $item) }}" id="navform-{{ $item->id }}">@csrf @method('PUT')</form>
                        <td><input form="navform-{{ $item->id }}" name="label" class="form-control form-control-sm" value="{{ $item->label }}"></td>
                        <td><input form="navform-{{ $item->id }}" name="url" class="form-control form-control-sm" value="{{ $item->url }}"></td>
                        <td><input form="navform-{{ $item->id }}" type="checkbox" name="is_active" value="1" class="form-check-input" {{ $item->is_active ? 'checked' : '' }}></td>
                        <td class="text-nowrap">
                            <form method="POST" action="{{ route('admin.nav.move', $item) }}" class="d-inline">@csrf <input type="hidden" name="direction" value="up"><button class="btn btn-sm btn-outline-secondary" {{ $loop->first ? 'disabled' : '' }}><i class="bi bi-arrow-up"></i></button></form>
                            <form method="POST" action="{{ route('admin.nav.move', $item) }}" class="d-inline">@csrf <input type="hidden" name="direction" value="down"><button class="btn btn-sm btn-outline-secondary" {{ $loop->last ? 'disabled' : '' }}><i class="bi bi-arrow-down"></i></button></form>
                        </td>
                        <td class="text-end text-nowrap">
                            <button form="navform-{{ $item->id }}" class="btn btn-sm btn-primary">Save</button>
                            <form method="POST" action="{{ route('admin.nav.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No nav items yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
