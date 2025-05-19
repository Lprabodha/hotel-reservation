@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Reservations</h5>
                <h2 class="card-text">1,234</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Active Users</h5>
                <h2 class="card-text">567</h2>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Recent Reservations</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Dates</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample Data -->
                        <tr>
                            <td>John Doe</td>
                            <td>Deluxe Suite</td>
                            <td>2023-10-01 to 2023-10-05</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection