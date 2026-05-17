@extends('admin.layout', ['title' => 'New Page'])

@section('content')
<div class="card p-4" style="max-width: 720px;">
    <h6 class="text-muted mb-3">Create a new page</h6>
    <form method="POST" action="{{ route('admin.pages.store') }}">
        @csrf
        @include('admin.pages._form', ['page' => null])
        <div class="d-flex gap-2">
            <button class="btn btn-primary">Create page</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-link">Cancel</a>
        </div>
    </form>
</div>
@endsection
