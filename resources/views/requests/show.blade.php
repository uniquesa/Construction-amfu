@can('act', $approval)
    <form action="{{ route('approvals.approve', $requestEntry) }}" method="POST">
        @csrf
        <textarea name="comments" class="form-control" placeholder="Comments"></textarea>
        <button type="submit" class="btn btn-success">Approve</button>
    </form>

    <form action="{{ route('approvals.reject', $requestEntry) }}" method="POST" class="mt-2">
        @csrf
        <textarea name="comments" class="form-control" placeholder="Comments"></textarea>
        <button type="submit" class="btn btn-danger">Reject</button>
    </form>
@endcan
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Request Details</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $requestEntry->title }}</h4>
            <p><strong>Description:</strong> {{ $requestEntry->description }}</p>
            <p><strong>Status:</strong> {{ $requestEntry->status }}</p>
            <p><strong>Current Level:</strong> {{ $requestEntry->current_level }}</p>
        </div>
    </div>

    <a href="{{ route('requests.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
