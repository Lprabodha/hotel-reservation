@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Add New Hotel</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    <!-- Hotel Name -->
                    <div class="col-md-6">
                        <label class="form-label">Hotel Name <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="material-symbols:hotel"></iconify-icon>
                            </span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Hotel Name" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-md-6">
                        <label class="form-label">Location <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:location"></iconify-icon>
                            </span>
                            <input type="text" name="location"
                                class="form-control @error('location') is-invalid @enderror" placeholder="Enter Location"
                                value="{{ old('location') }}" required>
                        </div>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mage:email"></iconify-icon>
                            </span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter Email" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="solar:phone-calling-linear"></iconify-icon>
                            </span>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                placeholder="+1 (555) 000-0000" value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hotel Type -->
                    <div class="col-md-6">
                        <label class="form-label">Hotel Type <span class="text-danger">*</span></label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="material-symbols:business"></iconify-icon>
                            </span>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Select Hotel Type</option>
                                <option value="luxury" {{ old('type') == 'luxury' ? 'selected' : '' }}>Luxury</option>
                                <option value="boutique" {{ old('type') == 'boutique' ? 'selected' : '' }}>Boutique
                                </option>
                                <option value="budget" {{ old('type') == 'budget' ? 'selected' : '' }}>Budget</option>
                                <option value="business" {{ old('type') == 'business' ? 'selected' : '' }}>Business
                                </option>
                                <option value="resort" {{ old('type') == 'resort' ? 'selected' : '' }}>Resort</option>
                            </select>
                        </div>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Star Rating -->
                    <div class="col-md-6">
                        <label class="form-label">Star Rating</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="material-symbols:star"></iconify-icon>
                            </span>
                            <select name="star_rating" class="form-control @error('star_rating') is-invalid @enderror">
                                <option value="0" {{ old('star_rating') == '0' ? 'selected' : '' }}>No Rating</option>
                                <option value="1" {{ old('star_rating') == '1' ? 'selected' : '' }}>1 Star</option>
                                <option value="2" {{ old('star_rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                                <option value="3" {{ old('star_rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                                <option value="4" {{ old('star_rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                                <option value="5" {{ old('star_rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                            </select>
                        </div>
                        @error('star_rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="col-md-6">
                        <label class="form-label">Website</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:web"></iconify-icon>
                            </span>
                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                                placeholder="https://example.com" value="{{ old('website') }}">
                        </div>
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:flag"></iconify-icon>
                            </span>
                            <input type="text" name="country"
                                class="form-control @error('country') is-invalid @enderror" placeholder="Enter Country"
                                value="{{ old('country') }}">
                        </div>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:map-marker"></iconify-icon>
                            </span>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3"
                                placeholder="Enter Full Address">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="material-symbols:description"></iconify-icon>
                            </span>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                placeholder="Enter Hotel Description">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Images -->
                    <div class="col-12">
                        <label class="form-label">Hotel Images</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="material-symbols:image"></iconify-icon>
                            </span>
                            <input type="file" name="images[]"
                                class="form-control @error('images') is-invalid @enderror" multiple accept="image/*">
                        </div>
                        <small class="text-muted">You can select multiple images</small>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="active" value="1"
                                id="active" {{ old('active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">
                                Active Hotel
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-600">
                                <iconify-icon icon="material-symbols:save"></iconify-icon>
                                Save Hotel
                            </button>
                            <a href="{{ route('admin.hotels') }}" class="btn btn-secondary-600">
                                <iconify-icon icon="material-symbols:cancel"></iconify-icon>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
