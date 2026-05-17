@extends('admin.layout', ['title' => 'Footer'])

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="text-muted mb-3">Add footer item</h6>
            <form method="POST" action="{{ route('admin.footer.store') }}">
                @csrf
                <div class="mb-2"><label class="form-label small">Column #</label><input type="number" name="column_index" class="form-control form-control-sm" min="1" max="6" value="1" required></div>
                <div class="mb-2"><label class="form-label small">Column title (first item in column)</label><input name="column_title" class="form-control form-control-sm"></div>
                <div class="mb-2"><label class="form-label small">Label</label><input name="label" class="form-control form-control-sm" required></div>
                <div class="mb-2"><label class="form-label small">URL (optional)</label><input name="url" class="form-control form-control-sm"></div>
                <div class="mb-3 form-check"><input type="checkbox" id="active1" name="is_active" value="1" class="form-check-input" checked><label for="active1" class="form-check-label small">Active</label></div>
                <button class="btn btn-primary btn-sm">Add</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light"><tr><th>Col</th><th>Title</th><th>Label</th><th>URL</th><th>Active</th><th></th></tr></thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <form method="POST" action="{{ route('admin.footer.update', $item) }}" id="ftrform-{{ $item->id }}">@csrf @method('PUT')</form>
                        <td style="width:70px;"><input form="ftrform-{{ $item->id }}" type="number" name="column_index" class="form-control form-control-sm" value="{{ $item->column_index }}" min="1" max="6"></td>
                        <td><input form="ftrform-{{ $item->id }}" name="column_title" class="form-control form-control-sm" value="{{ $item->column_title }}"></td>
                        <td><input form="ftrform-{{ $item->id }}" name="label" class="form-control form-control-sm" value="{{ $item->label }}"></td>
                        <td><input form="ftrform-{{ $item->id }}" name="url" class="form-control form-control-sm" value="{{ $item->url }}"></td>
                        <td><input form="ftrform-{{ $item->id }}" type="checkbox" name="is_active" value="1" class="form-check-input" {{ $item->is_active ? 'checked' : '' }}></td>
                        <td class="text-end text-nowrap">
                            <button form="ftrform-{{ $item->id }}" class="btn btn-sm btn-primary">Save</button>
                            <form method="POST" action="{{ route('admin.footer.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No footer items yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
