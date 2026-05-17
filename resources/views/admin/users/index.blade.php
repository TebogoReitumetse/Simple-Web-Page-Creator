@extends('admin.layout', ['title' => 'Users'])

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h6 class="text-muted mb-0">All users</h6>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> New user</a>
</div>
<div class="card p-0">
    <table class="table mb-0 align-middle">
        <thead class="table-light"><tr><th>Name</th><th>Email</th><th>Admin</th><th>Created</th><th></th></tr></thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>@if($u->is_admin)<span class="badge bg-success">Yes</span>@else<span class="badge bg-secondary">No</span>@endif</td>
                <td class="text-muted small">{{ $u->created_at->diffForHumans() }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="d-inline" onsubmit="return confirm('Delete this user?');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
