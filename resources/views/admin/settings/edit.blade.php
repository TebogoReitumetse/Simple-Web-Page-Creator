@extends('admin.layout', ['title' => 'Settings'])

@section('content')
<div class="card p-4" style="max-width: 640px;">
    <h6 class="text-muted mb-3">Site settings</h6>
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Site name</label><input name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name']) }}" required></div>
        <div class="mb-3"><label class="form-label">Footer tagline</label><textarea name="footer_tagline" class="form-control" rows="2">{{ old('footer_tagline', $settings['footer_tagline']) }}</textarea></div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
