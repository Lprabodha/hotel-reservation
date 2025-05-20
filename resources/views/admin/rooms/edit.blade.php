@extends('layouts.admin')

@section('title', 'Edit Room')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="bi bi-door-closed"></i> Edit Room</h5>
        </div>
        <div class="card-body">
            <form>
                @php
                    $room = [
                        'id' => 1,
                        'hotel_id' => 1,
                        'room_number' => '101',
                        'room_type' => 'double',
                        'price_per_night' => 150.00,
                        'occupancy' => 2,
                        'is_available' => true,
                        'description' => 'Spacious double room with sea view'
                    ];
                    $hotels = [1 => 'Grand Plaza Hotel', 2 => 'Mountain View Resort'];
                @endphp

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="hotel_id" class="form-label">Hotel</label>
                            <select class="form-select" id="hotel_id" name="hotel_id" required>
                                @foreach($hotels as $id => $name)
                                    <option value="{{ $id }}" {{ $id == $room['hotel_id'] ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="room_number" class="form-label">Room Number</label>
                            <input type="text" class="form-control" id="room_number" 
                                   name="room_number" value="{{ $room['room_number'] }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="room_type" class="form-label">Room Type</label>
                            <select class="form-select" id="room_type" name="room_type" required>
                                <option value="single" {{ $room['room_type'] == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="double" {{ $room['room_type'] == 'double' ? 'selected' : '' }}>Double</option>
                                <option value="suite" {{ $room['room_type'] == 'suite' ? 'selected' : '' }}>Suite</option>
                                <option value="residential" {{ $room['room_type'] == 'residential' ? 'selected' : '' }}>Residential</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Price Per Night</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price_per_night" 
                                       name="price_per_night" value="{{ $room['price_per_night'] }}" step="0.01" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="occupancy" class="form-label">Max Occupancy</label>
                            <input type="number" class="form-control" id="occupancy" 
                                   name="occupancy" value="{{ $room['occupancy'] }}" min="1" required>
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_available" 
                                   name="is_available" {{ $room['is_available'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">Available</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" 
                              name="description" rows="3">{{ $room['description'] }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Room</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection