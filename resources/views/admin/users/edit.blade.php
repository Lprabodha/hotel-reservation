@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="bi bi-person-gear"></i> Edit User</h5>
        </div>
        <div class="card-body">
            <form>
                <!-- Dummy user data - replace with real data later -->
                @php
                    $user = [
                        'id' => 1,
                        'name' => 'john_doe',
                        'email' => 'john@example.com',
                        'role' => 'Hotel Manager',
                        'hotel_id' => 2
                    ];
                @endphp

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="{{ old('username', $user['name']) }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ old('email', $user['email']) }}" required>
                </div>

                <!-- Password (Optional) -->
                <div class="mb-3">
                    <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <!-- Role Selection -->
                <div class="mb-3">
                    <label for="role" class="form-label">User Role</label>
                    <select class="form-select" id="role" name="role" required>
                        {{-- @foreach($roles as $value => $label)
                            <option value="{{ $value }}" 
                                {{ (old('role', $user['role']) == $value) ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach --}}
                    </select>
                </div>

                <!-- Hotel Selection -->
                <div class="mb-3">
                    <label for="hotel" class="form-label">Assigned Hotel</label>
                    <select class="form-select" id="hotel" name="hotel_id">
                        {{-- @foreach($hotels as $id => $name)
                            <option value="{{ $id }}" 
                                {{ (old('hotel_id', $user['hotel_id']) == $id) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach --}}
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection