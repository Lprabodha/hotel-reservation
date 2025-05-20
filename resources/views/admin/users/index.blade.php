@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h3>User Management</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New User
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Hotel</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Dummy data - replace with real data later
                            $users = [
                                ['id' => 1, 'name' => 'admin_user', 'email' => 'admin@example.com', 'role' => 'Administrator', 'hotel_id' => 1],
                                ['id' => 2, 'name' => 'manager_john', 'email' => 'john@example.com', 'role' => 'Hotel Manager', 'hotel_id' => 2],
                                ['id' => 3, 'name' => 'clerk_emma', 'email' => 'emma@example.com', 'role' => 'Clerk', 'hotel_id' => 3],
                                ['id' => 4, 'name' => 'travel_co', 'email' => 'travel@example.com', 'role' => 'Travel Company', 'hotel_id' => 4],
                            ];
                        @endphp

                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $user['role'] }}
                                </span>
                            </td>
                            <td>{{ $user['hotel_id'] }}</td>
                            <td>
                                {{-- <a href="{{ route('admin.users.edit', ['user' => $user['id']]) }}" class="btn btn-sm btn-warning" title="Edit"> --}}
                                <a href="{{ route('admin.users.edit', ['user' => 1]) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection