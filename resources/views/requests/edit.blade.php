@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Request</h2>

    <form action="{{ route('requests.update', $requestEntry->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Request Title</label>
            <input type="text" name="title" class="form-control" value="{{ $requestEntry->title }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $requestEntry->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('requests.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
