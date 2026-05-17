@extends('admin.layout', ['title' => $user ? 'Edit User' : 'New User'])

@section('content')
<div class="card p-4" style="max-width: 560px;">
    <h6 class="text-muted mb-3">{{ $user ? 'Edit user' : 'New user' }}</h6>
    <form method="POST" action="{{ $user ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if($user) @method('PUT') @endif
        <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required></div>
        <div class="mb-3"><label class="form-label">Password {{ $user ? '(leave blank to keep)' : '' }}</label><input type="password" name="password" class="form-control" {{ $user ? '' : 'required' }}></div>
        <div class="mb-3 form-check"><input type="checkbox" id="is_admin" name="is_admin" value="1" class="form-check-input" {{ old('is_admin', $user->is_admin ?? false) ? 'checked' : '' }}><label for="is_admin" class="form-check-label">Admin (can access dashboard)</label></div>
        <button class="btn btn-primary">{{ $user ? 'Save' : 'Create' }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
