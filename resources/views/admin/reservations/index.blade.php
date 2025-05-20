@extends('layouts.admin')

@section('title', 'Manage Reservations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h3>Reservation Management</h3>
        <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Create Reservation
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Guest</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $reservations = [
                                [
                                    'id' => 1,
                                    'user' => 'John Doe',
                                    'check_in' => '2023-10-01',
                                    'check_out' => '2023-10-05',
                                    'status' => 'confirmed',
                                    'payment_status' => 'paid',
                                    'total_price' => 1200.00
                                ],
                                [
                                    'id' => 2,
                                    'user' => 'Jane Smith',
                                    'check_in' => '2023-10-10',
                                    'check_out' => '2023-10-15',
                                    'status' => 'pending',
                                    'payment_status' => 'pending',
                                    'total_price' => 800.00
                                ],
                            ];
                        @endphp

                        @foreach ($reservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation['user'] }}</td>
                            <td>{{ date('M d, Y', strtotime($reservation['check_in'])) }}</td>
                            <td>{{ date('M d, Y', strtotime($reservation['check_out'])) }}</td>
                            <td>
                                <span class="badge 
                                    @if($reservation['status'] == 'confirmed') bg-success
                                    @elseif($reservation['status'] == 'pending') bg-warning
                                    @else bg-secondary @endif">
                                    {{ ucfirst($reservation['status']) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($reservation['payment_status'] == 'paid') bg-success
                                    @elseif($reservation['payment_status'] == 'pending') bg-warning
                                    @else bg-danger @endif">
                                    {{ ucfirst($reservation['payment_status']) }}
                                </span>
                            </td>
                            <td>${{ number_format($reservation['total_price'], 2) }}</td>
                            <td>
                                {{-- <a href="{{ route('admin.reservations.edit', ['reservation' => $reservation['id']]) }}" class="btn btn-sm btn-warning" title="Edit"> --}}
                                <a href="{{ route('admin.reservations.edit', ['reservation' => 1]) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection