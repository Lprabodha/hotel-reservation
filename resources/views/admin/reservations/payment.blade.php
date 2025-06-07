@extends('layouts.admin.app')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reservation Payment</h6>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <button type="button" id="addRow"
                    class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1" data-bs-toggle="modal"
                    data-bs-target="#addServiceModal">
                    <iconify-icon icon="simple-line-icons:plus" class="text-xl"></iconify-icon>
                    Add Extra Services
                </button>
            </div>

            <div class="card-body py-40">
                <div class="row justify-content-center" id="invoice">
                    <div class="col-lg-8">
                        <div class="shadow-4 border radius-8">
                            <div class="p-20 d-flex justify-content-between border-bottom">
                                <div>
                                    <h3 class="text-xl">Invoice: {{ $reservation->confirmation_number }}</h3>
                                    <p class="text-sm">Date Issued: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm">Galle Road, Colombo, SL</p>
                                    <p class="text-sm">info@click2checkin.com</p>
                                </div>
                            </div>

                            <div class="py-28 px-20">
                                <div class="table-responsive scroll-sm">
                                    <table class="table bordered-table text-sm">
                                        <thead>
                                            <tr>
                                                <th>Room ID</th>
                                                <th>Guests</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reservationRooms as $room)
                                                <tr>
                                                    <td>{{ $room['id'] }}</td>
                                                    <td>{{ $room['occupancy'] }}</td>
                                                    <td>{{ $room['room_type'] }}</td>
                                                    <td>LKR: {{ number_format($room['price'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <h6 class="mt-4">Extra Services</h6>
                                    <table class="table bordered-table text-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service Name</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="extraServicesTableBody"></tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <table class="text-sm">
                                        <tbody>
                                            <tr>
                                                <td>Subtotal:</td>
                                                <td>LKR: {{ number_format($reservation->total_price, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total:</td>
                                                <td id="totalAmount">LKR: {{ number_format($reservation->total_price, 2) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">
                                    <h5 class="mb-3 fw-semibold">Payment Method</h5>
                                    <div class="d-flex flex-column gap-3">

                                        <label
                                            class="payment-option p-3 border rounded d-flex align-items-center gap-3 cursor-pointer"
                                            for="cashPayment">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                id="cashPayment" value="cash" checked>
                                            <div>
                                                <div class="fw-bold mb-1">Cash Payment</div>
                                                <div class="text-muted small">Pay with cash at the front desk.</div>
                                            </div>
                                        </label>

                                        <label
                                            class="payment-option p-3 border rounded d-flex align-items-center gap-3 cursor-pointer"
                                            for="cardPayment">
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                id="cardPayment" value="card">
                                            <div>
                                                <div class="fw-bold mb-1">Card Payment (Stripe)</div>
                                                <div class="text-muted small">Secure payment with Visa, MasterCard via
                                                    Stripe.</div>
                                            </div>
                                        </label>

                                    </div>

                                    <button class="btn btn-success w-100 mt-4" onclick="proceedToPayment()">Proceed to
                                        Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Service Modal -->
        <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="extraServiceForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Extra Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Service Name</label>
                                <input type="text" class="form-control" id="serviceName" required>
                            </div>
                            <div class="mb-3">
                                <label>Service Price (LKR)</label>
                                <input type="number" class="form-control" id="servicePrice" required min="0">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Service</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        let extraServices = [];

        const extraServiceForm = document.getElementById('extraServiceForm');

        extraServiceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('serviceName').value;
            const price = parseFloat(document.getElementById('servicePrice').value);

            if (name && price >= 0) {
                extraServices.push({
                    name,
                    price
                });
                updateServiceTable();
                $('#addServiceModal').modal('hide');
                this.reset();
            }
        });

        function updateServiceTable() {
            const tableBody = document.getElementById('extraServicesTableBody');
            tableBody.innerHTML = '';

            let totalExtra = 0;
            extraServices.forEach((service, index) => {
                totalExtra += service.price;
                tableBody.innerHTML += `
        <tr>
            <td>${index + 1}</td>
            <td>${service.name}</td>
            <td>LKR: ${service.price.toFixed(2)}</td>
        </tr>
    `;
            });

            const subtotal = {{ $reservation->total_price }};
            const total = subtotal + totalExtra;
            document.getElementById('totalAmount').innerText = `LKR: ${total.toFixed(2)}`;
        }

        function proceedToPayment() {
            const method = document.querySelector('input[name="paymentMethod"]:checked').value;

            if (method === 'cash') {
                fetch("{{ route('admin.reservation.cashPayment', $reservation->id) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            services: extraServices
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert('Payment successful (Cash).');
                        window.location.href = "{{ route('admin.reservation.index') }}";
                    });
            } else {
                fetch("{{ route('admin.reservation.stripePayment', $reservation->id) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            services: extraServices
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.url) {
                            window.location.href = data.url;
                        } else {
                            alert('Stripe Session creation failed.');
                        }
                    });
            }
        }
    </script>
@endsection

@section('style')
    <style>
        .payment-option {
            transition: all 0.3s ease-in-out;
        }

        .payment-option:hover {
            background-color: #f8f9fa;
            border-color: #0d6efd;
        }

        .payment-option input[type="radio"] {
            transform: scale(1.3);
        }

        .form-check-input:checked+div {
            color: #0d6efd;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection
