@extends('layouts.admin.app')


@section('content')
    <style>
        .room-checkbox {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .card {
            position: relative;
            /* to position checkbox inside */
        }
    </style>

    <div class="dashboard-main-body">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Reservation</h5>
            </div>
            <div class="card-body">

                <div class="form-wizard">
                    <form action="#" method="post">
                        <div class="form-wizard-header overflow-x-auto scroll-sm pb-8 my-32">
                            <ul class="list-unstyled form-wizard-list style-three">
                                <li class="form-wizard-list__item d-flex align-items-center gap-8 active">
                                    <div class="form-wizard-list__line">
                                        <span class="count">1</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Order Details </span>
                                </li>
                                <li class="form-wizard-list__item d-flex align-items-center gap-8">
                                    <div class="form-wizard-list__line">
                                        <span class="count">2</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Manufactures</span>
                                </li>
                                <li class="form-wizard-list__item d-flex align-items-center gap-8">
                                    <div class="form-wizard-list__line">
                                        <span class="count">3</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Order Plan</span>
                                </li>
                                <li class="form-wizard-list__item d-flex align-items-center gap-8">
                                    <div class="form-wizard-list__line">
                                        <span class="count">4</span>
                                    </div>
                                    <span class="text text-xs fw-semibold">Completed</span>
                                </li>
                            </ul>
                        </div>

                        <fieldset class="wizard-fieldset show">
                            <!-- Filter Form -->
                            <div class="row gy-4 align-items-end">
                                <div class="col-md-3">
                                    <label for="checkin" class="form-label">Check-In Date</label>
                                    <input type="date" id="checkin" class="form-control wizard-required" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="checkout" class="form-label">Check-Out Date</label>
                                    <input type="date" id="checkout" class="form-control wizard-required" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="guests" class="form-label">Guests</label>
                                    <input type="number" id="guests" class="form-control wizard-required"
                                        placeholder="Number of Guests" required min="1">
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>

                            <div class="mb-40 mt-5">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card radius-12 h-60">
                                            <div class="card-body py-16 px-24">
                                                <div class="d-flex align-items-center gap-2 mb-12">
                                                    <iconify-icon icon="typcn:user-add" class="text-xxl"></iconify-icon>
                                                    <h6 class="text-lg mb-0">Heritance Kandalama
                                                    </h6>

                                                    <div class="room-checkbox">
                                                        <input type="checkbox" id="room1" name="rooms[]" value="101"
                                                            class="form-check-input">
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mb-2">Room Number: #101</p>
                                                <p class="card-text text-muted mb-2">Max Guests: 2</p>
                                                <p class="card-text text-muted mb-3">Location: Dambulla</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card radius-12 h-60">
                                            <div class="card-body py-16 px-24">
                                                <div class="d-flex align-items-center gap-2 mb-12">
                                                    <iconify-icon icon="typcn:user-add" class="text-xxl"></iconify-icon>
                                                    <h6 class="text-lg mb-0">Heritance Kandalama
                                                    </h6>

                                                    <div class="room-checkbox">
                                                        <input type="checkbox" id="room1" name="rooms[]" value="101"
                                                            class="form-check-input">
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mb-2">Room Number: #101</p>
                                                <p class="card-text text-muted mb-2">Max Guests: 2</p>
                                                <p class="card-text text-muted mb-3">Location: Dambulla</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card radius-12 h-60">
                                            <div class="card-body py-16 px-24">
                                                <div class="d-flex align-items-center gap-2 mb-12">
                                                    <iconify-icon icon="typcn:user-add" class="text-xxl"></iconify-icon>
                                                    <h6 class="text-lg mb-0">Heritance Kandalama
                                                    </h6>

                                                    <div class="room-checkbox">
                                                        <input type="checkbox" id="room1" name="rooms[]"
                                                            value="101" class="form-check-input">
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mb-2">Room Number: #101</p>
                                                <p class="card-text text-muted mb-2">Max Guests: 2</p>
                                                <p class="card-text text-muted mb-3">Location: Dambulla</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card radius-12 h-60">
                                            <div class="card-body py-16 px-24">
                                                <div class="d-flex align-items-center gap-2 mb-12">
                                                    <iconify-icon icon="typcn:user-add" class="text-xxl"></iconify-icon>
                                                    <h6 class="text-lg mb-0">Heritance Kandalama
                                                    </h6>

                                                    <div class="room-checkbox">
                                                        <input type="checkbox" id="room1" name="rooms[]"
                                                            value="101" class="form-check-input">
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mb-2">Room Number: #101</p>
                                                <p class="card-text text-muted mb-2">Max Guests: 2</p>
                                                <p class="card-text text-muted mb-3">Location: Dambulla</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card radius-12 h-60">
                                            <div class="card-body py-16 px-24">
                                                <div class="d-flex align-items-center gap-2 mb-12">
                                                    <iconify-icon icon="typcn:user-add" class="text-xxl"></iconify-icon>
                                                    <h6 class="text-lg mb-0">Heritance Kandalama
                                                    </h6>

                                                    <div class="room-checkbox">
                                                        <input type="checkbox" id="room1" name="rooms[]"
                                                            value="101" class="form-check-input">
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mb-2">Room Number: #101</p>
                                                <p class="card-text text-muted mb-2">Max Guests: 2</p>
                                                <p class="card-text text-muted mb-3">Location: Dambulla</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card radius-12 h-60">
                                            <div class="card-body py-16 px-24">
                                                <div class="d-flex align-items-center gap-2 mb-12">
                                                    <iconify-icon icon="typcn:user-add" class="text-xxl"></iconify-icon>
                                                    <h6 class="text-lg mb-0">Heritance Kandalama
                                                    </h6>

                                                    <div class="room-checkbox">
                                                        <input type="checkbox" id="room1" name="rooms[]"
                                                            value="101" class="form-check-input">
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mb-2">Room Number: #101</p>
                                                <p class="card-text text-muted mb-2">Max Guests: 2</p>
                                                <p class="card-text text-muted mb-3">Location: Dambulla</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card radius-12 h-60">
                                            <div class="card-body py-16 px-24">
                                                <div class="d-flex align-items-center gap-2 mb-12">
                                                    <iconify-icon icon="typcn:user-add" class="text-xxl"></iconify-icon>
                                                    <h6 class="text-lg mb-0">Heritance Kandalama
                                                    </h6>

                                                    <div class="room-checkbox">
                                                        <input type="checkbox" id="room1" name="rooms[]"
                                                            value="101" class="form-check-input">
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mb-2">Room Number: #101</p>
                                                <p class="card-text text-muted mb-2">Max Guests: 2</p>
                                                <p class="card-text text-muted mb-3">Location: Dambulla</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>



                        <fieldset class="wizard-fieldset">
                            <h6 class="text-md text-neutral-500">Account Information</h6>
                            <div class="row gy-3">
                                <div class="col-12">
                                    <label class="form-label">User Name*</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control wizard-required"
                                            placeholder="Enter User Name" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label">Card Number*</label>
                                    <div class="position-relative">
                                        <input type="number" class="form-control wizard-required"
                                            placeholder="Enter Card Number " required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label">Card Expiration(MM/YY)*</label>
                                    <div class="position-relative">
                                        <input type="number" class="form-control wizard-required"
                                            placeholder="Enter Card Expiration" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label">CVV Number*</label>
                                    <div class="position-relative">
                                        <input type="number" class="form-control wizard-required"
                                            placeholder="CVV Number" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Password*</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control wizard-required"
                                            placeholder="Enter Password" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8">
                                    <button type="button"
                                        class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button"
                                        class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="wizard-fieldset">
                            <h6 class="text-md text-neutral-500">Bank Information</h6>
                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <label class="form-label">Bank Name*</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control wizard-required"
                                            placeholder="Enter Bank Name" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Branch Name*</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control wizard-required"
                                            placeholder="Enter Branch Name" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Account Name*</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control wizard-required"
                                            placeholder="Enter Account Name" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Account Number*</label>
                                    <div class="position-relative">
                                        <input type="number" class="form-control wizard-required"
                                            placeholder="Enter Account Number" required>
                                        <div class="wizard-form-error"></div>
                                    </div>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-end gap-8">
                                    <button type="button"
                                        class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                    <button type="button"
                                        class="form-wizard-next-btn btn btn-primary-600 px-32">Next</button>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="wizard-fieldset">
                            <div class="text-center mb-40">
                                <img src="assets/images/gif/success-img3.gif" alt="" class="gif-image mb-24">
                                <h6 class="text-md text-neutral-600">Congratulations </h6>
                                <p class="text-neutral-400 text-sm mb-0">Well done! You have successfully completed.</p>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-end gap-8">
                                <button type="button"
                                    class="form-wizard-previous-btn btn btn-neutral-500 border-neutral-100 px-32">Back</button>
                                <button type="button"
                                    class="form-wizard-submit btn btn-primary-600 px-32">Publish</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!-- Form Wizard End -->

                {{-- <div class="mb-40">
                <h6 class="mb-24">Horizontal Card</h6>
                <div class="row gy-4">
                    <div class="col-xl-6">
                        <div class="card radius-12 overflow-hidden h-100 d-flex align-items-center flex-nowrap flex-row">
                            <div class="d-flex flex-shrink-0 w-170-px h-100">
                                <img src="assets/images/admin/card-component/horizontal-card-img1.png" class="h-100 w-100 object-fit-cover" alt="">
                            </div>
                            <div class="card-body p-16 flex-grow-1">
                                <h5 class="card-title text-lg text-primary-light mb-6">This is Card title</h5>
                                <p class="card-text text-neutral-600 mb-16">We quickly learn to fear and thus automatically avo id potentially stressful situations of all kinds, including the most common of all .</p>
                                <a href="javascript:void(0)" class="btn text-primary-600 hover-text-primary p-0 d-inline-flex align-items-center gap-2">
                                    Read More <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card radius-12 overflow-hidden h-100 d-flex align-items-center flex-nowrap flex-row flex-row-reverse">
                            <div class="d-flex flex-shrink-0 w-170-px h-100">
                                <img src="images/card-component/horizontal-card-img2.png" class="h-100 w-100 object-fit-cover" alt="">
                            </div>
                            <div class="card-body p-16 flex-grow-1">
                                <h5 class="card-title text-lg text-primary-light mb-6">This is Card title</h5>
                                <p class="card-text text-neutral-600 mb-16">We quickly learn to fear and thus automatically avo id potentially stressful situations of all kinds, including the most common of all .</p>
                                <a href="javascript:void(0)" class="btn text-primary-600 hover-text-primary p-0 d-inline-flex align-items-center gap-2">
                                    Read More <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card radius-12 overflow-hidden h-100 d-flex align-items-center flex-nowrap flex-row">
                            <div class="d-flex flex-shrink-0 w-170-px h-100">
                                <img src="images/card-component/horizontal-card-img3.png" class="h-100 w-100 object-fit-cover" alt="">
                            </div>
                            <div class="card-body p-16 flex-grow-1">
                                <h5 class="card-title text-lg text-primary-light mb-6">This is Card title</h5>
                                <p class="card-text text-neutral-600 mb-16">We quickly learn to fear and thus automatically avo id potentially stressful situations of all kinds, including the most common of all .</p>
                                <a href="javascript:void(0)" class="btn text-primary-600 hover-text-primary p-0 d-inline-flex align-items-center gap-2">
                                    Read More <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card radius-12 overflow-hidden h-100 d-flex align-items-center flex-nowrap flex-row flex-row-reverse">
                            <div class="d-flex flex-shrink-0 w-170-px h-100">
                                <img src="images/card-component/horizontal-card-img4.png" class="h-100 w-100 object-fit-cover" alt="">
                            </div>
                            <div class="card-body p-16 flex-grow-1">
                                <h5 class="card-title text-lg text-primary-light mb-6">This is Card title</h5>
                                <p class="card-text text-neutral-600 mb-16">We quickly learn to fear and thus automatically avo id potentially stressful situations of all kinds, including the most common of all .</p>
                                <a href="javascript:void(0)" class="btn text-primary-600 hover-text-primary p-0 d-inline-flex align-items-center gap-2">
                                    Read More <iconify-icon icon="iconamoon:arrow-right-2" class="text-xl"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            </div>
        </div>
    </div>
@endsection
