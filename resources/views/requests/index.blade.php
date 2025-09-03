@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Requests</h2>

    <a href="{{ route('requests.create') }}" class="btn btn-primary mb-3">+ New Request</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Current Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($requests as $req)
            <tr>
                <td>{{ $req->id }}</td>
                <td>{{ $req->title }}</td>
                <td>{{ $req->status }}</td>
                <td>{{ $req->current_level }}</td>
                <td>
                    <a href="{{ route('requests.show', $req->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('requests.edit', $req->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('requests.destroy', $req->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this request?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No requests found</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
