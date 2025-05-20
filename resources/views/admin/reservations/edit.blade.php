@extends('layouts.admin')

@section('title', 'Edit Reservation')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Edit Reservation</h5>
        </div>
        <div class="card-body">
            <form>
                @php
                    $reservation = [
                        'id' => 1,
                        'user_id' => 1,
                        'check_in_date' => '2023-10-01',
                        'check_out_date' => '2023-10-05',
                        'status' => 'confirmed',
                        'number_of_guests' => 2,
                        'special_requests' => 'Need early check-in',
                        'total_price' => 600.00,
                        'payment_method' => 'credit_card',
                        'payment_status' => 'paid'
                    ];
                    $users = [1 => 'John Doe', 2 => 'Jane Smith'];
                    $rooms = [1 => 'Grand Plaza Hotel - Room 101 ($150/night)'];
                @endphp

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Guest</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}" {{ $id == $reservation['user_id'] ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="check_in_date" class="form-label">Check-In</label>
                                <input type="date" class="form-control" id="check_in_date" 
                                       name="check_in_date" value="{{ $reservation['check_in_date'] }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out_date" class="form-label">Check-Out</label>
                                <input type="date" class="form-control" id="check_out_date" 
                                       name="check_out_date" value="{{ $reservation['check_out_date'] }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="room_id" class="form-label">Room</label>
                            <select class="form-select" id="room_id" name="room_id" required>
                                @foreach($rooms as $id => $info)
                                    <option value="{{ $id }}" {{ $id == 1 ? 'selected' : '' }}>
                                        {{ $info }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white">
                                Payment Information
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="credit_card" {{ $reservation['payment_method'] == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="cash" {{ $reservation['payment_method'] == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="online" {{ $reservation['payment_method'] == 'online' ? 'selected' : '' }}>Online Payment</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="total_price" class="form-label">Total Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="total_price" 
                                               name="total_price" value="{{ $reservation['total_price'] }}" step="0.01" required>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="payment_status" 
                                           name="payment_status" {{ $reservation['payment_status'] == 'paid' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="payment_status">
                                        Payment Completed
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="number_of_guests" class="form-label">Number of Guests</label>
                            <input type="number" class="form-control" id="number_of_guests" 
                                   name="number_of_guests" value="{{ $reservation['number_of_guests'] }}" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="confirmed" {{ $reservation['status'] == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="pending" {{ $reservation['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="cancelled" {{ $reservation['status'] == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="special_requests" class="form-label">Special Requests</label>
                    <textarea class="form-control" id="special_requests" 
                              name="special_requests" rows="2">{{ $reservation['special_requests'] }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection