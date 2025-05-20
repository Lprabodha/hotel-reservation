@extends('layouts.admin')

@section('title', 'Create Reservation')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-plus"></i> Create Reservation</h5>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Guest Selection -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Guest</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">Select Guest</option>
                                {{-- @foreach($users as $user)
                                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <!-- Dates -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="check_in_date" class="form-label">Check-In</label>
                                <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out_date" class="form-label">Check-Out</label>
                                <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                            </div>
                        </div>

                        <!-- Room Selection -->
                        <div class="mb-3">
                            <label for="room_id" class="form-label">Select Room</label>
                            <select class="form-select" id="room_id" name="room_id" required>
                                <option value="">Available Rooms</option>
                                {{-- @foreach($rooms as $room)
                                    <option value="{{ $room['id'] }}">
                                        {{ $room['hotel'] }} - Room {{ $room['room_number'] }} 
                                        (${{ number_format($room['price_per_night'], 2) }}/night)
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Payment Info -->
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white">
                                Payment Information
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="cash">Cash</option>
                                        <option value="online">Online Payment</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="total_price" class="form-label">Total Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="total_price" 
                                               name="total_price" step="0.01" readonly>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="payment_status" name="payment_status">
                                    <label class="form-check-label" for="payment_status">
                                        Mark as Paid
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="number_of_guests" class="form-label">Number of Guests</label>
                            <input type="number" class="form-control" id="number_of_guests" 
                                   name="number_of_guests" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Reservation Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="confirmed">Confirmed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="special_requests" class="form-label">Special Requests</label>
                    <textarea class="form-control" id="special_requests" name="special_requests" rows="2"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Create Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection