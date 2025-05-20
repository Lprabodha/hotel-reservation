@extends('layouts.admin')

@section('title', 'Manage Hotels')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h3>Hotel Management</h3>
        <a href="{{ route('admin.hotels.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Hotel
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Star Rating</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Dummy data - replace with real data later
                            $hotels = [
                                [
                                    'id' => 1,
                                    'name' => 'Grand Plaza Hotel',
                                    'location' => 'New York',
                                    'star_rating' => 5,
                                    'phone' => '+1 234 567 890',
                                    'email' => 'info@grandplaza.com',
                                    'active' => true
                                ],
                                [
                                    'id' => 2,
                                    'name' => 'Mountain View Resort',
                                    'location' => 'Switzerland',
                                    'star_rating' => 4,
                                    'phone' => '+41 123 456 789',
                                    'email' => 'contact@mountainview.ch',
                                    'active' => true
                                ],
                            ];
                        @endphp

                        @foreach ($hotels as $hotel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hotel['name'] }}</td>
                            <td>{{ $hotel['location'] }}</td>
                            <td>
                                @for($i = 0; $i < $hotel['star_rating']; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @endfor
                            </td>
                            <td>
                                <div>{{ $hotel['phone'] }}</div>
                                <div>{{ $hotel['email'] }}</div>
                            </td>
                            <td>
                                @if($hotel['active'])
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{-- <a href="{{ route('admin.hotels.edit', ['hotel' => $hotel['id']]) }}" class="btn btn-sm btn-warning" title="Edit"> --}}
                                <a href="{{ route('admin.hotels.edit', ['hotel' => 1]) }}" class="btn btn-sm btn-warning" title="Edit">
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