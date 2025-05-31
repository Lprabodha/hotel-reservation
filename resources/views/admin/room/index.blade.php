@extends('layouts.admin.app')

@section('content')
    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title mb-0">Manage Rooms</h5>
            <a href="{{ route('admin.rooms.create') }}" class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">Add New Room</a>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th>
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">#</label>
                            </div>
                        </th>
                        <th>Hotel</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Occupancy</th>
                        <th>Price/Night</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $index => $room)
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">{{ $index + 1 }}</label>
                                </div>
                            </td>
                            <td>{{ $room->hotel->name ?? 'N/A' }}</td>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ ucfirst($room->room_type) }}</td>
                            <td>{{ $room->occupancy }}</td>
                            <td>${{ number_format($room->price_per_night, 2) }}</td>
                            <td>
                                <span class="px-24 py-4 rounded-pill fw-medium text-sm 
                                    {{ $room->is_available ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">
                                    {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td class="d-flex gap-2 items-center">
                                <a href="#"
                                   class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                </a>
                                <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center border-0"
                                            onclick="return confirm('Are you sure you want to delete this room?')">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Rooms Stored Yet To Display.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
