@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Room</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row gy-3">

                    <!-- Hotel Selection -->
                    <div class="col-md-6">
                        <label class="form-label">Select Hotel <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:hotel"></iconify-icon></span>
                            <select name="hotel_id" class="form-control @error('hotel_id') is-invalid @enderror" required>
                                <option value="">Choose Hotel</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}"
                                        {{ $room->hotel_id == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('hotel_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Room Number -->
                    <div class="col-md-6">
                        <label class="form-label">Room Number <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:numeric"></iconify-icon></span>
                            <input type="text" name="room_number"
                                class="form-control @error('room_number') is-invalid @enderror"
                                value="{{ old('room_number', $room->room_number) }}" required>
                        </div>
                        @error('room_number')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Room Type -->
                    <div class="col-md-6">
                        <label class="form-label">Room Type <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:bed"></iconify-icon></span>
                            <select name="room_type" class="form-control @error('room_type') is-invalid @enderror" required>
                                @foreach (['single', 'double', 'triple', 'quad', 'suite', 'family'] as $type)
                                    <option value="{{ $type }}" {{ $room->room_type == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('room_type')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Occupancy -->
                    <div class="col-md-6">
                        <label class="form-label">Occupancy <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:account-group"></iconify-icon></span>
                            <input type="number" name="occupancy"
                                class="form-control @error('occupancy') is-invalid @enderror"
                                value="{{ old('occupancy', $room->occupancy) }}" required>
                        </div>
                        @error('occupancy')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price Per Night -->
                    <div class="col-md-6">
                        <label class="form-label">Price Per Night ($) <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:currency-usd"></iconify-icon></span>
                            <input type="number" step="0.01" name="price_per_night"
                                class="form-control @error('price_per_night') is-invalid @enderror"
                                value="{{ old('price_per_night', $room->price_per_night) }}" required>
                        </div>
                        @error('price_per_night')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($room->images && is_array($room->images))
                        <div class="col-12">
                            <label class="form-label">Current Images</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($room->images as $image)
                                    <img src="{{ Storage::disk('s3')->url($image) }}" width="100" height="100"
                                        class="rounded">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Room Images -->
                    <div class="col-12">
                        <label class="form-label">Upload More Images</label>
                        <input type="file" name="images[]" multiple class="form-control">
                        <small class="text-muted">Existing images will remain. New ones will be added.</small>
                    </div>

                    <input type="hidden" name="is_available" value="1">

                    <!-- Submit -->
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">Update
                                Room</button>
                            <a href="{{ route('admin.rooms') }}"
                                class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
