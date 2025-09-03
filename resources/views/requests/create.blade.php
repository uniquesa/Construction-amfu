@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Request</h2>

    <form action="{{ route('requests.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Request Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save Request</button>
        <a href="{{ route('requests.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
