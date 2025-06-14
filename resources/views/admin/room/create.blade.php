@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Add New Room</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">

                    <!-- Hotel Selection -->
                    <div class="col-md-6">
                        <label class="form-label">Select Hotel <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:hotel"></iconify-icon>
                            </span>
                            <select name="hotel_id" class="form-control @error('hotel_id') is-invalid @enderror" required>
                                <option value="">Choose Hotel</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('hotel_id')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Room Number -->
                    <div class="col-md-6">
                        <label class="form-label">Room Number <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:numeric"></iconify-icon>
                            </span>
                            <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror"
                                placeholder="Enter Room Number" value="{{ old('room_number') }}" required>
                        </div>
                        @error('room_number')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Room Type -->
                    <div class="col-md-6">
                        <label class="form-label">Room Type <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:bed"></iconify-icon>
                            </span>
                            <select name="room_type" class="form-control @error('room_type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="single" {{ old('room_type') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="double" {{ old('room_type') == 'double' ? 'selected' : '' }}>Double</option>
                                <option value="triple" {{ old('room_type') == 'triple' ? 'selected' : '' }}>Triple</option>
                                <option value="quad" {{ old('room_type') == 'quad' ? 'selected' : '' }}>Quad</option>
                                <option value="suite" {{ old('room_type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                <option value="family" {{ old('room_type') == 'family' ? 'selected' : '' }}>Family</option>
                            </select>
                        </div>
                        @error('room_type')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Occupancy -->
                    <div class="col-md-6">
                        <label class="form-label">Occupancy <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:account-group"></iconify-icon>
                            </span>
                            <input type="number" name="occupancy" class="form-control @error('occupancy') is-invalid @enderror"
                                placeholder="Enter Max Occupancy" value="{{ old('occupancy') }}" required>
                        </div>
                        @error('occupancy')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price Per Night -->
                    <div class="col-md-12">
                        <label class="form-label">Price Per Night ($) <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:currency-usd"></iconify-icon>
                            </span>
                            <input type="number" step="0.01" name="price_per_night"
                                class="form-control @error('price_per_night') is-invalid @enderror"
                                placeholder="e.g. 120.50" value="{{ old('price_per_night') }}" required>
                        </div>
                        @error('price_per_night')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Daily Rate -->
                    <div class="col-md-4">
                        <label class="form-label">Daily Rate ($)</label>
                        <input type="number" step="0.01" name="rate[daily]" class="form-control" placeholder="e.g. 100.00" value="{{ old('rate.daily') }}">
                    </div>

                    <!-- Weekly Rate -->
                    <div class="col-md-4">
                        <label class="form-label">Weekly Rate ($)</label>
                        <input type="number" step="0.01" name="rate[weekly]" class="form-control" placeholder="e.g. 600.00" value="{{ old('rate.weekly') }}">
                    </div>

                    <!-- Monthly Rate -->
                    <div class="col-md-4">
                        <label class="form-label">Monthly Rate ($)</label>
                        <input type="number" step="0.01" name="rate[monthly]" class="form-control" placeholder="e.g. 2200.00" value="{{ old('rate.monthly') }}">
                    </div>

                    <!-- Images -->
                    <div class="col-12">
                        <label class="form-label">Room Images</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="material-symbols:image"></iconify-icon>
                            </span>
                            <input type="file" name="images[]" multiple accept="image/*"
                                class="form-control @error('images') is-invalid @enderror">
                        </div>
                        <small class="text-muted">You can upload multiple images</small>
                        @error('images')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hidden input for set the Availability -->
                    <input type="hidden" name="is_available" value="1" id="is_available">

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
                                Save Room
                            </button>
                            <a href="{{ route('admin.rooms.index') }}" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
