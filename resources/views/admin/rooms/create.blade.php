@extends('layouts.admin')

@section('title', 'Create New Room')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-door-open"></i> Create New Room</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Hotel Selection -->
                        <div class="mb-3">
                            <label for="hotel_id" class="form-label">Hotel</label>
                            <select class="form-select" id="hotel_id" name="hotel_id" required>
                                <option value="">Select Hotel</option>
                                {{-- @foreach($hotels as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <!-- Room Number -->
                        <div class="mb-3">
                            <label for="room_number" class="form-label">Room Number</label>
                            <input type="text" class="form-control" id="room_number" name="room_number" required>
                        </div>

                        <!-- Room Type -->
                        <div class="mb-3">
                            <label for="room_type" class="form-label">Room Type</label>
                            <select class="form-select" id="room_type" name="room_type" required>
                                <option value="">Select Type</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                                <option value="residential">Residential</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Price Per Night</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price_per_night" 
                                       name="price_per_night" step="0.01" required>
                            </div>
                        </div>

                        <!-- Occupancy -->
                        <div class="mb-3">
                            <label for="occupancy" class="form-label">Max Occupancy</label>
                            <input type="number" class="form-control" id="occupancy" 
                                   name="occupancy" min="1" required>
                        </div>

                        <!-- Availability -->
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_available" name="is_available" checked>
                            <label class="form-check-label" for="is_available">Available</label>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Create Room</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection