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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-6">
                        <label class="form-label">Address</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="mdi:map-marker"></iconify-icon>
                            </span>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2"
                                placeholder="Enter Full Address">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-6">
                        <label class="form-label">Description</label>
                        <div class="icon-field">
                            <span class="icon">
                                <iconify-icon icon="material-symbols:description"></iconify-icon>
                            </span>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2"
                                placeholder="Enter Hotel Description">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Services Selection and Charges -->
                    <div class="col-md-2">
                        <label class="form-label">Services</label>
                        <select id="service-select" class="form-control">
                            <option value="">Select a Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-10">
                        <label class="form-label">Selected Services with Charges</label>
                        <div id="selected-services" class="d-flex flex-wrap gap-2">
                            <!-- Service badges with charge input will appear here -->
                        </div>
                    </div>

                    <!-- Hidden input container for submitting -->
                    <div id="service-inputs"></div>


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
                            <div style="color: red; font-size: 10px; padding-top: 3px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status Active, hidden input -->
                    <input type="hidden" name="active" value="1">

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn rounded-pill btn-info-600 radius-8 px-20 py-11">
                                Save Hotel
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

    <script>
        const serviceSelect = document.getElementById('service-select');
        const selectedServicesDiv = document.getElementById('selected-services');
        const serviceInputsDiv = document.getElementById('service-inputs');
        const selectedServices = new Map(); // id => { name, charge }

        serviceSelect.addEventListener('change', function () {
            const selectedId = this.value;
            const selectedText = this.options[this.selectedIndex].text;

            if (selectedId && !selectedServices.has(selectedId)) {
                selectedServices.set(selectedId, { name: selectedText, charge: 0 });

                // Create badge with charge input
                const wrapper = document.createElement('div');
                wrapper.className = 'border rounded px-3 py-2 d-flex align-items-center gap-2 bg-light shadow-sm';
                wrapper.style.borderRadius = '12px';
                wrapper.id = 'service-wrapper-' + selectedId;

                wrapper.innerHTML = `
                    <strong>${selectedText}</strong>
                    <input type="number" step="0.01" min="0" placeholder="Charge"
                        class="form-control form-control-sm" style="width: 100px;"
                        oninput="document.getElementById('services-${selectedId}-charge').value = this.value">
                    <button type="button" class="btn btn-sm btn-danger" title="Remove">
                        &times;
                    </button>
                `;

                // Remove logic
                wrapper.querySelector('button').addEventListener('click', () => {
                    selectedServices.delete(selectedId);
                    wrapper.remove();
                    document.getElementById('services-' + selectedId + '-id')?.remove();
                    document.getElementById('services-' + selectedId + '-charge')?.remove();
                });

                selectedServicesDiv.appendChild(wrapper);

                // Hidden inputs
                const hiddenIdInput = document.createElement('input');
                hiddenIdInput.type = 'hidden';
                hiddenIdInput.name = `services[${selectedId}][id]`;
                hiddenIdInput.value = selectedId;
                hiddenIdInput.id = 'services-' + selectedId + '-id';

                const hiddenChargeInput = document.createElement('input');
                hiddenChargeInput.type = 'hidden';
                hiddenChargeInput.name = `services[${selectedId}][charge]`;
                hiddenChargeInput.value = '';
                hiddenChargeInput.id = 'services-' + selectedId + '-charge';

                serviceInputsDiv.appendChild(hiddenIdInput);
                serviceInputsDiv.appendChild(hiddenChargeInput);
            }

            this.value = ''; // reset select
        });
    </script>
@endsection
