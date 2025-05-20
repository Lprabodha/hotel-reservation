@extends('layouts.admin')

@section('title', 'Edit Hotel')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="bi bi-building-gear"></i> Edit Hotel</h5>
        </div>
        <div class="card-body">
            <form>
                <!-- Dummy hotel data - replace with real data later -->
                @php
                    $hotel = [
                        'id' => 1,
                        'name' => 'Grand Plaza Hotel',
                        'location' => 'New York',
                        'phone' => '+1 234 567 890',
                        'email' => 'info@grandplaza.com',
                        'star_rating' => 5,
                        'website' => 'https://grandplaza.com',
                        'description' => 'Luxury 5-star hotel in the heart of Manhattan',
                        'active' => true
                    ];
                @endphp

                <!-- Hotel Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Hotel Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ old('name', $hotel['name']) }}" required>
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" 
                           value="{{ old('location', $hotel['location']) }}" required>
                </div>

                <!-- Contact Information -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                               value="{{ old('phone', $hotel['phone']) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email', $hotel['email']) }}" required>
                    </div>
                </div>

                <!-- Star Rating -->
                <div class="mb-3">
                    <label for="star_rating" class="form-label">Star Rating</label>
                    <select class="form-select" id="star_rating" name="star_rating" required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" 
                                {{ old('star_rating', $hotel['star_rating']) == $i ? 'selected' : '' }}>
                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Website -->
                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control" id="website" name="website"
                           value="{{ old('website', $hotel['website']) }}">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="3">{{ old('description', $hotel['description']) }}</textarea>
                </div>

                <!-- Status -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="active" name="active"
                        {{ old('active', $hotel['active']) ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Active</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Hotel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection