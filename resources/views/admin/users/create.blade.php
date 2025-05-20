@extends('layouts.admin')

@section('title', 'Create New User')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-person-plus"></i> Create New User</h5>
        </div>
        <div class="card-body">
            <form>
                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="{{ old('username') }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ old('email') }}" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Password Confirmation -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" 
                           name="password_confirmation" required>
                </div>

                <!-- Role Selection -->
                <div class="mb-3">
                    <label for="role" class="form-label">User Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">Select Role</option>
                        @php
                            // Dummy roles - replace with real data later
                            $roles = [
                                'Administrator' => 'Administrator',
                                'Hotel Manager' => 'Hotel Manager',
                                'Clerk' => 'Clerk',
                                'Travel Company' => 'Travel Company'
                            ];
                        @endphp
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hotel Selection -->
                <div class="mb-3">
                    <label for="hotel" class="form-label">Assigned Hotel</label>
                    <select class="form-select" id="hotel" name="hotel_id">
                        <option value="">Select Hotel</option>
                        @php
                            // Dummy hotels - replace with real data later
                            $hotels = [
                                1 => 'Grand Plaza Hotel',
                                2 => 'Mountain View Resort',
                                3 => 'City Center Inn',
                                4 => 'Beachside Villas'
                            ];
                        @endphp
                        @foreach($hotels as $id => $name)
                            <option value="{{ $id }}" {{ old('hotel_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection