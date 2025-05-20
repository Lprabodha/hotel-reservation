@extends('layouts.admin')

@section('title', 'Manage Rooms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h3>Room Management</h3>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Room
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Room Number</th>
                            <th>Type</th>
                            <th>Hotel</th>
                            <th>Price/Night</th>
                            <th>Occupancy</th>
                            <th>Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rooms = [
                                [
                                    'id' => 1,
                                    'room_number' => '101',
                                    'room_type' => 'double',
                                    'hotel' => 'Grand Plaza Hotel',
                                    'price_per_night' => 150.00,
                                    'occupancy' => 2,
                                    'is_available' => true
                                ],
                                [
                                    'id' => 2,
                                    'room_number' => '201',
                                    'room_type' => 'suite',
                                    'hotel' => 'Mountain View Resort',
                                    'price_per_night' => 300.00,
                                    'occupancy' => 4,
                                    'is_available' => false
                                ],
                            ];
                        @endphp

                        @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $room['room_number'] }}</td>
                            <td><span class="badge bg-primary text-capitalize">{{ $room['room_type'] }}</span></td>
                            <td>{{ $room['hotel'] }}</td>
                            <td>${{ number_format($room['price_per_night'], 2) }}</td>
                            <td>{{ $room['occupancy'] }} <i class="bi bi-people"></i></td>
                            <td>
                                @if($room['is_available'])
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Occupied</span>
                                @endif
                            </td>
                            <td>
                                {{-- <a href="{{ route('admin.rooms.edit', ['room' => $room['id']]) }}" class="btn btn-sm btn-warning" title="Edit"> --}}
                                <a href="{{ route('admin.rooms.edit', ['room' => 1]) }}" class="btn btn-sm btn-warning" title="Edit">
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