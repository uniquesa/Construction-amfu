@extends('/master')
@section('title', 'User-Management')

@section('content')
<div class="container">
    <h2>User Management</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Role</th>
                <th>Assign Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.assignRole', $user->id) }}">
                        @csrf
                        <select name="role" class="form-control">
                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Assign</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
