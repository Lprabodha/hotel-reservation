@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Hotel</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row gy-3">
                    <!-- Hotel Name -->
                    <div class="col-md-6">
                        <label class="form-label">Hotel Name <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="material-symbols:hotel"></iconify-icon></span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $hotel->name) }}" required>
                        </div>
                        @error('name')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-md-6">
                        <label class="form-label">Location <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:location"></iconify-icon></span>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', $hotel->location) }}" required>
                        </div>
                        @error('location')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mage:email"></iconify-icon></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $hotel->email) }}" required>
                        </div>
                        @error('email')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="solar:phone-calling-linear"></iconify-icon></span>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $hotel->phone) }}">
                        </div>
                        @error('phone')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hotel Type -->
                    <div class="col-md-6">
                        <label class="form-label">Hotel Type <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="material-symbols:business"></iconify-icon></span>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Select Hotel Type</option>
                                @foreach(['luxury', 'boutique', 'budget', 'business', 'resort'] as $type)
                                    <option value="{{ $type }}" {{ old('type', $hotel->type->value) === $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('type')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Star Rating -->
                    <div class="col-md-6">
                        <label class="form-label">Star Rating</label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="material-symbols:star"></iconify-icon></span>
                            <select name="star_rating" class="form-control @error('star_rating') is-invalid @enderror">
                                @for ($i = 0; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('star_rating', $hotel->star_rating) == $i ? 'selected' : '' }}>
                                        {{ $i == 0 ? 'No Rating' : $i . ' Star' . ($i > 1 ? 's' : '') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        @error('star_rating')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="col-md-6">
                        <label class="form-label">Website</label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:web"></iconify-icon></span>
                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                                   value="{{ old('website', $hotel->website) }}">
                        </div>
                        @error('website')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:flag"></iconify-icon></span>
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                   value="{{ old('country', $hotel->country) }}">
                        </div>
                        @error('country')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-6">
                        <label class="form-label">Address</label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="mdi:map-marker"></iconify-icon></span>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                      rows="2">{{ old('address', $hotel->address) }}</textarea>
                        </div>
                        @error('address')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-6">
                        <label class="form-label">Description</label>
                        <div class="icon-field">
                            <span class="icon"><iconify-icon icon="material-symbols:description"></iconify-icon></span>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="2">{{ old('description', $hotel->description) }}</textarea>
                        </div>
                        @error('description')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Services -->
                    <div class="col-12">
                        <label class="form-label">Services</label>
                        <div class="row">
                            @foreach($services as $service)
                                @php
                                    $assigned = $hotel->services->firstWhere('id', $service->id);
                                @endphp
                                <div class="col-md-4 mb-3">
                                    <div class="form-check d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input me-2"
                                                type="checkbox"
                                                name="services[{{ $service->id }}][id]"
                                                value="{{ $service->id }}"
                                                {{ $assigned ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2">
                                                {{ $service->name }}
                                            </label>
                                        </div>
                                        <input type="number"
                                            step="0.01"
                                            name="services[{{ $service->id }}][charge]"
                                            class="form-control me-5"
                                            style="width: 150px"
                                            placeholder="Charge"
                                            value="{{ old("services.{$service->id}.charge", $assigned ? $assigned->pivot->charge : '') }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- Current Images -->
                    @if ($hotel->images && is_array($hotel->images))
                        <div class="col-12">
                            <label class="form-label">Current Images</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($hotel->images as $image)
                                    <img src="{{ Storage::disk('s3')->url($image) }}" width="100" height="100" class="rounded">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upload New Images -->
                    <div class="col-12">
                        <label class="form-label">Upload New Images (Optional)</label>
                        <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror"
                               multiple accept="image/*">
                        <small class="text-muted">This will replace existing images</small>
                        @error('images')
                        <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="col-12">
                        <div class="form-check d-flex align-items-center gap-3">
                            <input class="form-check-input" type="checkbox" name="active" value="1"
                                   id="active" {{ old('active', $hotel->active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active Hotel</label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
                                Update Hotel
                            </button>
                            <a href="{{ route('admin.hotels') }}" class="btn rounded-pill btn-light-100 text-dark radius-8 px-20 py-11">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
