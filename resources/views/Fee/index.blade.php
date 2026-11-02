<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Fee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/fee.css') }}">
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-house-door-fill me-2"></i>HMS Portal
            </a>
            <div class="navbar-nav flex-row gap-3">
                <a class="nav-link" href="{{ route('warden') }}">Warden</a>
                <a class="nav-link" href="{{ route('hostel') }}">Hostel</a>
                <a class="nav-link" href="{{ route('room') }}">Room</a>
                <a class="nav-link" href="{{ route('student') }}">Student</a>
                <a class="nav-link" href="{{ route('allocation') }}">Allocation</a>
                <a class="nav-link fw-bold" href="{{ route('fee') }}">Fee</a>
                <a class="nav-link" href="{{ route('visitor') }}">Visitor</a>
                <a class="nav-link" href="{{ route('complaint') }}">Complaint</a>
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        style="background:rgba(255,255,255,0.2); color:white; border:none; padding:6px 14px; border-radius:20px;">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <div class="px-3 py-2 border-bottom">
                                <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                                <div class="text-muted" style="font-size:12px;">{{ Auth::user()->email }}</div>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-key-fill me-2 text-primary"></i>Change Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="text-center page-title">
            <h2><i class="bi bi-cash-stack me-2"></i>Fee Management</h2>
        </div>
        {{-- 4 Step Cascade Dropdowns --}}
        <div class="select-section">
            <div class="row g-3">
                {{-- Step 1: Warden --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <span class="badge bg-primary me-1">1</span>Select Warden
                    </label>
                    <select id="warden" class="form-select">
                        <option value="">-- Select Warden --</option>
                        @forelse ($wardens as $warden)
                            <option value="{{ $warden->warden_id }}">{{ $warden->warden_name }}</option>
                        @empty
                            <option disabled>No wardens found</option>
                        @endforelse
                    </select>
                </div>
                {{-- Step 2: Hostel --}}
                <div class="col-md-3" id="hostel_div" style="display:none;">
                    <label class="form-label fw-bold">
                        <span class="badge bg-primary me-1">2</span>Select Hostel
                    </label>
                    <select id="hostel" class="form-select">
                        <option value="">-- Select Hostel --</option>
                    </select>
                </div>
                {{-- Step 3: Room --}}
                <div class="col-md-3" id="room_div" style="display:none;">
                    <label class="form-label fw-bold">
                        <span class="badge bg-primary me-1">3</span>Select Room
                    </label>
                    <select id="room" class="form-select">
                        <option value="">-- Select Room --</option>
                    </select>
                </div>
                {{-- Step 4: Student --}}
                <div class="col-md-3" id="student_div" style="display:none;">
                    <label class="form-label fw-bold">
                        <span class="badge bg-primary me-1">4</span>Select Student
                    </label>
                    <select id="student" class="form-select">
                        <option value="">-- Select Student --</option>
                    </select>
                </div>
            </div>
            {{-- Amount Per Month Input — shows after student selected --}}
            <div class="row g-3 mt-3" id="amount_per_month_div" style="display:none;">
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="bi bi-calendar-month me-1 text-primary"></i>
                        Amount Per Month
                    </label>
                    <div class="input-group">
                        <span class="input-group-text fw-bold text-primary">Rs.</span>
                        <input type="number" id="amount_per_month" class="form-control fw-bold"
                            placeholder="e.g. 1000" style="font-size:16px;">
                    </div>
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>Edit to recalculate remaining
                    </small>
                </div>
            </div>
            {{-- END Amount Per Month --}}
        </div>
        {{-- END Cascade --}}

        {{--3 Summary Cards --}}
        <div id="feeSummary" style="display:none;" class="mt-4 mb-3">
            <div class="row g-3">
                {{-- Amount Per Month Card --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm"
                        style="border-left:5px solid #0d6efd !important; border-radius:12px;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="background:#e8f0fe; border-radius:50%; width:55px; height:55px;
                                display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="bi bi-calendar-month" style="font-size:26px; color:#0d6efd;"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size:13px;">Amount Per Month</div>
                                <div class="fw-bold text-primary" style="font-size:22px;">
                                    Rs. <span id="rent_per_month_val">0</span>
                                </div>
                                <div class="text-muted" style="font-size:11px;">
                                    <i class="bi bi-house me-1"></i>Room rent per month
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Paid Fees Card --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm"
                        style="border-left:5px solid #198754 !important; border-radius:12px;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="background:#d1e7dd; border-radius:50%; width:55px; height:55px;
                                display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="bi bi-check-circle-fill" style="font-size:26px; color:#198754;"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size:13px;">Paid Fees</div>
                                <div class="fw-bold text-success" style="font-size:22px;">
                                    Rs. <span id="paid_fees_val">0</span>
                                </div>
                                <div class="text-muted" style="font-size:11px;">
                                    <i class="bi bi-receipt me-1"></i>Total amount paid
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Remaining Fees Card --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm"
                        style="border-left:5px solid #dc3545 !important; border-radius:12px;">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div style="background:#f8d7da; border-radius:50%; width:55px; height:55px;
                                display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="bi bi-exclamation-circle-fill" style="font-size:26px; color:#dc3545;"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size:13px;">Remaining Fees</div>
                                <div class="fw-bold text-danger" style="font-size:22px;">
                                    Rs. <span id="remaining_fees_val">0</span>
                                </div>
                                <div class="text-muted" style="font-size:11px;">
                                    <i class="bi bi-clock me-1"></i>Still to be paid
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- END Summary Cards --}}

        {{-- Fee Table --}}
        <div class="card mb-4" id="feetable" style="display:none;">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Fee List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Pay Date</th>
                                <th>Month For</th>
                                <th>Payment Mode</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody id="feebody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Add Fee Form --}}
        <div class="form-section" id="addform" style="display:none;">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-plus-circle-fill me-2"></i>Add New Fee
            </h5>
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-bold">Amount</label>
                    <input type="number" id="amount" class="form-control" placeholder="Amount">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Pay Date</label>
                    <input type="date" id="pay_date" class="form-control">
                </div>
                {{-- <div class="col-md-2">
                    <label class="form-label fw-bold">Month For</label>
                    <input type="text" id="month_for" class="form-control" placeholder="e.g. October">
                </div> --}}
                <div class="col-md-2">
                    <label class="form-label fw-bold">Month For</label>
                    <select id="month_for" class="form-select">
                        <option value="">-- Select Month --</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Payment Mode</label>
                    <select id="payment_mode" class="form-select">
                        <option value="Cash">Cash</option>
                        <option value="Online">Online</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="addbtn" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i>Add Fee
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Fee Receipt Modal --}}
    <div class="modal fade" id="feeReceiptModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="receiptContent">
                <div class="modal-header" style="background-color:#0d6efd; color:white;">
                    <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Hostel Fee Receipt</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-building" style="font-size:40px; color:#0d6efd;"></i>
                        <h4 class="fw-bold">HMS Portal</h4>
                        <p class="text-muted mb-0">Hostel Management System</p>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p><strong><i class="bi bi-hash me-1"></i>Receipt No: </strong><span id="r_fee_id"></span></p>
                            <p><strong><i class="bi bi-person-fill me-1"></i>Student: </strong><span id="r_student_name"></span></p>
                            <p><strong><i class="bi bi-calendar-month me-1"></i>Month For: </strong><span id="r_month_for"></span></p>
                        </div>
                        <div class="col-6 text-end">
                            <p><strong><i class="bi bi-calendar-date me-1"></i>Pay Date: </strong><span id="r_pay_date"></span></p>
                            <p><strong><i class="bi bi-credit-card me-1"></i>Payment Mode: </strong><span id="r_payment_mode"></span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h4 class="fw-bold text-success">
                            <i class="bi bi-cash-stack me-2"></i>Amount Paid: Rs. <span id="r_amount"></span>
                        </h4>
                    </div>
                    {{-- ===== Extra Paid Alert in Receipt ===== --}}
                    <div id="r_extra_section" style="display:none;" class="text-center mt-2">
                        <div class="alert alert-warning py-2">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Extra Paid: Rs. <span id="r_extra_amount"></span></strong>
                            — Will adjust in next month automatically!
                        </div>
                    </div>
                    <hr>
                    {{-- 3 Summary inside Receipt --}}
                    <div class="row text-center">
                        <div class="col-4">
                            <div style="background:#e8f0fe; border-radius:8px; padding:10px;">
                                <div style="font-size:11px; color:#555;">Amount/Month</div>
                                <div class="fw-bold text-primary" style="font-size:15px;">
                                    Rs. <span id="r_rent"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div style="background:#d1e7dd; border-radius:8px; padding:10px;">
                                <div style="font-size:11px; color:#555;">Paid Fees</div>
                                <div class="fw-bold text-success" style="font-size:15px;">
                                    Rs. <span id="r_paid_fees"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div style="background:#f8d7da; border-radius:8px; padding:10px;">
                                <div style="font-size:11px; color:#555;">Remaining</div>
                                <div class="fw-bold text-danger" style="font-size:15px;">
                                    Rs. <span id="r_remaining_fees"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center text-muted">
                        <small><i class="bi bi-check-circle-fill text-success me-1"></i>Thank you! Fee paid successfully.</small><br>
                        <small><i class="bi bi-clock me-1"></i>Generated: <span id="r_date"></span></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="printReceipt()">
                        <i class="bi bi-printer-fill me-2"></i>Print Receipt
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password Modal --}}
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#0d6efd; color:white;">
                    <h5 class="modal-title"><i class="bi bi-key-fill me-2"></i>Change Password</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="pwSuccess" class="alert alert-success" style="display:none;">
                        <i class="bi bi-check-circle-fill me-2"></i>Changed password successfully
                        <span id="pwSuccessMsg"></span>
                    </div>
                    <div id="pwError" class="alert alert-danger" style="display:none;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <span id="pwErrorMsg"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill text-primary"></i></span>
                            <input type="password" id="current_password" class="form-control" placeholder="Enter current password">
                            <span class="input-group-text" onclick="togglePassword('current_password','eyeCurrent')" style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="eyeCurrent"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill text-primary"></i></span>
                            <input type="password" id="new_password" class="form-control" placeholder="Min 6 characters">
                            <span class="input-group-text" onclick="togglePassword('new_password','eyeNew')" style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="eyeNew"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill text-primary"></i></span>
                            <input type="password" id="confirm_password" class="form-control" placeholder="Repeat new password">
                            <span class="input-group-text" onclick="togglePassword('confirm_password','eyeConfirm')" style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="eyeConfirm"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="changePasswordBtn" class="btn btn-primary">
                        <i class="bi bi-check-circle-fill me-2"></i>Update Password
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        // Pay Date default TODAY 
        document.getElementById('pay_date').value = new Date().toISOString().split('T')[0];

        $(document).ready(function() {

            // Step 1 — Warden
            $('#warden').on('change', function() {
                var warden_id = $(this).val();
                $('#hostel').html('<option value="">-- Select Hostel --</option>');
                $('#room').html('<option value="">-- Select Room --</option>');
                $('#student').html('<option value="">-- Select Student --</option>');
                $('#hostel_div, #room_div, #student_div').hide();
                $('#amount_per_month_div').hide();
                $('#amount_per_month').val('');
                $('#feeSummary, #feetable, #addform').hide();
                if(warden_id == '') return;

                $.ajax({
                    url: '/get_hostels_for_fee/' + warden_id,
                    type: 'get',
                    success: function(data) {
                        if(data.hostels.length == 0) { 
                            alert('No hostels found!'); 
                            return; 
                        }
                        $.each(data.hostels, function(i, h) {
                            $('#hostel').append('<option value="' + h.hostel_id + '">' + h.hostel_name + '</option>');
                        });
                        $('#hostel_div').show();
                    }
                });
            });

            // Step 2 — Hostel
            $('#hostel').on('change', function() {
                var hostel_id = $(this).val();
                $('#room').html('<option value="">-- Select Room --</option>');
                $('#student').html('<option value="">-- Select Student --</option>');
                $('#room_div, #student_div').hide();
                $('#amount_per_month_div').hide();
                $('#amount_per_month').val('');
                $('#feeSummary, #feetable, #addform').hide();
                if(hostel_id == '') return;

                $.ajax({
                    url: '/get_rooms_for_fee/' + hostel_id,
                    type: 'get',
                    success: function(data) {
                        if(data.rooms.length == 0) { 
                            alert('No rooms found!'); 
                            return; 
                        }
                        $.each(data.rooms, function(i, r) {
                            $('#room').append(
                                '<option value="' + r.room_id + '">Room ' + r.room_no +
                                ' (Rs. ' + r.rent_per_month + '/month)</option>'
                            );
                        });
                        $('#room_div').show();
                    }
                });
            });

            // Step 3 — Room
            $('#room').on('change', function() {
                var room_id = $(this).val();
                $('#student').html('<option value="">-- Select Student --</option>');
                $('#student_div').hide();
                $('#amount_per_month_div').hide();
                $('#amount_per_month').val('');
                $('#feeSummary, #feetable, #addform').hide();
                if(room_id == '') return;

                $.ajax({
                    url: '/get_students_for_fee/' + room_id,
                    type: 'get',
                    success: function(data) {
                        if(data.students.length == 0) { 
                            alert('No students allocated to this room!'); 
                            return; 
                        }
                        $.each(data.students, function(i, s) {
                            $('#student').append('<option value="' + s.student_id + '">' + s.name + '</option>');
                        });
                        $('#student_div').show();
                    }
                });
            });

            // Step 4 — Student — Load Fees
            $('#student').on('change', function() {
                var student_id = $(this).val();
                $('#feebody').html('');
                $('#feeSummary, #feetable, #addform').hide();
                $('#amount_per_month_div').hide();
                $('#amount_per_month').val('');
                if(student_id == '') return;

                $.ajax({
                    url: '/get_fees/' + student_id,
                    type: 'get',
                    success: function(data) {

                        // Show Amount Per Month input 
                        var rent = parseFloat(data.rent_per_month.replace(/,/g,''));
                        var paid = parseFloat(data.paid_fees.replace(/,/g,''));
                        var remain = (paid == 0 || rent == 0) ? 0 : (rent - paid);

                        $('#amount_per_month').val(rent.toFixed(2));
                        $('#amount_per_month_div').show();

                        // Show Summary Cards
                        $('#rent_per_month_val').text(rent.toFixed(2));
                        $('#paid_fees_val').text(paid.toFixed(2));
                        $('#remaining_fees_val').text(remain.toFixed(2));
                        $('#feeSummary').show();

                        if(data.fees.length == 0) {
                            $('#feebody').html(
                                '<tr><td colspan="8" class="text-center text-danger py-3">' +
                                '<i class="bi bi-exclamation-circle me-1"></i>No fees found for this student.' +
                                '</td></tr>'
                            );
                            $('#feetable').show();
                            $('#addform').show();
                            $('#amount').val($('#amount_per_month').val());
                            return;
                        }

                        var rows = '';
                        $.each(data.fees, function(i, f) {
                            rows +=
                                '<tr>' +
                                '<td>' + f.fee_id + '</td>' +
                                '<td><input type="number" class="form-control form-control-sm" style="width:90px;" id="amount' + f.fee_id + '" value="' + parseFloat(f.amount).toFixed(2) + '"></td>' +
                                '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="pay_date' + f.fee_id + '" value="' + f.pay_date + '"></td>' +
                                '<td><select class="form-select form-select-sm" style="width:120px;" id="month_for' + f.fee_id + '">' +
                                    '<option value="January"'   + (f.month_for == "January"   ? " selected" : "") + '>January</option>' +
                                    '<option value="February"'  + (f.month_for == "February"  ? " selected" : "") + '>February</option>' +
                                    '<option value="March"'     + (f.month_for == "March"     ? " selected" : "") + '>March</option>' +
                                    '<option value="April"'     + (f.month_for == "April"     ? " selected" : "") + '>April</option>' +
                                    '<option value="May"'       + (f.month_for == "May"       ? " selected" : "") + '>May</option>' +
                                    '<option value="June"'      + (f.month_for == "June"      ? " selected" : "") + '>June</option>' +
                                    '<option value="July"'      + (f.month_for == "July"      ? " selected" : "") + '>July</option>' +
                                    '<option value="August"'    + (f.month_for == "August"    ? " selected" : "") + '>August</option>' +
                                    '<option value="September"' + (f.month_for == "September" ? " selected" : "") + '>September</option>' +
                                    '<option value="October"'   + (f.month_for == "October"   ? " selected" : "") + '>October</option>' +
                                    '<option value="November"'  + (f.month_for == "November"  ? " selected" : "") + '>November</option>' +
                                    '<option value="December"'  + (f.month_for == "December"  ? " selected" : "") + '>December</option>' +
                                '</select></td>' +
                                '<td><select class="form-select form-select-sm" style="width:130px;" id="payment_mode' + f.fee_id + '">' +
                                    '<option value="Cash"'          + (f.payment_mode == "Cash"          ? " selected" : "") + '>Cash</option>' +
                                    '<option value="Online"'        + (f.payment_mode == "Online"        ? " selected" : "") + '>Online</option>' +
                                    '<option value="Bank Transfer"' + (f.payment_mode == "Bank Transfer" ? " selected" : "") + '>Bank Transfer</option>' +
                                '</select></td>' +
                                '<td><button class="btn-update updatebtn" data-id="' + f.fee_id + '">Update</button></td>' +
                                '<td><button class="btn-delete deletebtn" data-id="' + f.fee_id + '">Delete</button></td>' +
                                '<td><button class="btn-receipt receiptbtn" ' +
                                    'data-id="' + f.fee_id + '" ' +
                                    'data-amount="' + f.amount + '" ' +
                                    'data-date="' + f.pay_date + '" ' +
                                    'data-month="' + f.month_for + '" ' +
                                    'data-mode="' + f.payment_mode + '">' +
                                    '<i class="bi bi-receipt me-1"></i>Receipt' +
                                '</button></td>' +
                                '</tr>';
                        });
                        $('#feebody').html(rows);
                        $('#feetable').show();
                        $('#addform').show();
                    }
                });
            });

            // Live recalculate when Amount Per Month input changes
            $('#amount_per_month').on('input', function() {
                var rent   = parseFloat($(this).val()) || 0;
                var paid   = parseFloat($('#paid_fees_val').text().replace(/,/g,'')) || 0;
                var remain = (paid == 0 || rent == 0) ? 0 : (rent - paid);
                $('#rent_per_month_val').text(rent.toFixed(2));
                $('#remaining_fees_val').text(remain.toFixed(2));
                $('#amount').val($(this).val()); 
            });

            // Add Fee
            $('#addbtn').on('click', function() {
                var student_id   = $('#student').val();
                var amount       = $('#amount').val();
                var pay_date     = $('#pay_date').val();
                var month_for    = $('#month_for').val();
                var payment_mode = $('#payment_mode').val();
                var student_name = $('#student option:selected').text();

                if(student_id == '')  { 
                    alert('Please select student!');    
                    return; 
                }
                else if(amount == '' || parseFloat(amount) <= 0) { 
                    alert('Amount must be greater than 0!');       
                    return; 
                }
                else if(pay_date == '') { 
                    alert('Please enter pay date!');   
                    return; 
                }
                else if(month_for == '') { 
                    alert('Please select month!');     
                    return; 
                }

                $.ajax({
                    url: '{{ route("fee_add") }}',
                    type: 'post',
                    data: {
                        _token:       '{{ csrf_token() }}',
                        student_id:   student_id,
                        amount:       amount,
                        pay_date:     pay_date,
                        month_for:    month_for,
                        payment_mode: payment_mode,
                        amount_per_month: $('#amount_per_month').val()
                    },
                    success: function(data) {
                    
                        // ===== Show message (normal OR extra paid) =====
                        if(data.extra > 0) {
                            alert('✅ ' + data.message);
                        } else {
                            alert('Added successfully');
                        }

                        // Update Summary Cards
                        var newPaid      = parseFloat($('#paid_fees_val').text().replace(/,/g,'')) + parseFloat(amount);
                        var rent         = parseFloat($('#rent_per_month_val').text().replace(/,/g,''));
                        var newRemaining = (newPaid == 0 || rent == 0) ? 0 : (rent - newPaid);
                        $('#paid_fees_val').text(newPaid.toFixed(2));
                        $('#remaining_fees_val').text(newRemaining.toFixed(2));

                        // Show Receipt
                        var f = data.fee;
                        $('#r_fee_id').text(f.fee_id);
                        $('#r_student_name').text(student_name);
                        $('#r_amount').text(parseFloat(f.amount).toFixed(2));
                        $('#r_pay_date').text(f.pay_date);
                        $('#r_month_for').text(f.month_for);
                        $('#r_payment_mode').text(f.payment_mode);
                        $('#r_rent').text(rent.toFixed(2));
                        $('#r_paid_fees').text(newPaid.toFixed(2));
                        $('#r_remaining_fees').text(newRemaining.toFixed(2));
                        $('#r_date').text(new Date().toLocaleString());

                        // ===== Show Extra in Receipt if applicable =====
                        if(data.extra > 0) {
                            $('#r_extra_section').show();
                            $('#r_extra_amount').text(data.extra);
                        } else {
                            $('#r_extra_section').hide();
                        }
                        // ===============================================

                        var modal = new bootstrap.Modal(document.getElementById('feeReceiptModal'));
                        modal.show();

                        // Add row to table
                        $('#feebody tr td[colspan]').closest('tr').remove();
                        $('#feebody').append(
                            '<tr>' +
                            '<td>' + f.fee_id + '</td>' +
                            '<td><input type="number" class="form-control form-control-sm" style="width:90px;" id="amount' + f.fee_id + '" value="' + parseFloat(f.amount).toFixed(2) + '"></td>' +
                            '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="pay_date' + f.fee_id + '" value="' + f.pay_date + '"></td>' +
                            '<td><select class="form-select form-select-sm" style="width:120px;" id="month_for' + f.fee_id + '">' +
                                '<option value="January"'   + (f.month_for == "January"   ? " selected" : "") + '>January</option>' +
                                '<option value="February"'  + (f.month_for == "February"  ? " selected" : "") + '>February</option>' +
                                '<option value="March"'     + (f.month_for == "March"     ? " selected" : "") + '>March</option>' +
                                '<option value="April"'     + (f.month_for == "April"     ? " selected" : "") + '>April</option>' +
                                '<option value="May"'       + (f.month_for == "May"       ? " selected" : "") + '>May</option>' +
                                '<option value="June"'      + (f.month_for == "June"      ? " selected" : "") + '>June</option>' +
                                '<option value="July"'      + (f.month_for == "July"      ? " selected" : "") + '>July</option>' +
                                '<option value="August"'    + (f.month_for == "August"    ? " selected" : "") + '>August</option>' +
                                '<option value="September"' + (f.month_for == "September" ? " selected" : "") + '>September</option>' +
                                '<option value="October"'   + (f.month_for == "October"   ? " selected" : "") + '>October</option>' +
                                '<option value="November"'  + (f.month_for == "November"  ? " selected" : "") + '>November</option>' +
                                '<option value="December"'  + (f.month_for == "December"  ? " selected" : "") + '>December</option>' +
                            '</select></td>' +
                            '<td><select class="form-select form-select-sm" style="width:130px;" id="payment_mode' + f.fee_id + '">' +
                                '<option value="Cash"'          + (f.payment_mode == "Cash"          ? " selected" : "") + '>Cash</option>' +
                                '<option value="Online"'        + (f.payment_mode == "Online"        ? " selected" : "") + '>Online</option>' +
                                '<option value="Bank Transfer"' + (f.payment_mode == "Bank Transfer" ? " selected" : "") + '>Bank Transfer</option>' +
                            '</select></td>' +
                            '<td><button class="btn-update updatebtn" data-id="' + f.fee_id + '">Update</button></td>' +
                            '<td><button class="btn-delete deletebtn" data-id="' + f.fee_id + '">Delete</button></td>' +
                            '<td><button class="btn-receipt receiptbtn" data-id="' + f.fee_id + '" data-amount="' + f.amount + '" data-date="' + f.pay_date + '" data-month="' + f.month_for + '" data-mode="' + f.payment_mode + '"><i class="bi bi-receipt me-1"></i>Receipt</button></td>' +
                            '</tr>'
                        );
                        $('#amount').val($('#amount_per_month').val());
                        $('#month_for').val('');
                        $('#pay_date').val(new Date().toISOString().split('T')[0]);
                    },
                    error: function(xhr) {
                        var r = JSON.parse(xhr.responseText);
                        alert(r.message);
                    }
                });
            });

            // // Receipt Button
            // $(document).on('click', '.receiptbtn', function() {
            //     var id           = $(this).attr('data-id');
            //     var amount       = $(this).attr('data-amount');
            //     var pay_date     = $(this).attr('data-date');
            //     var month_for    = $(this).attr('data-month');
            //     var payment_mode = $(this).attr('data-mode');
            //     var student_name = $('#student option:selected').text();

            //     $('#r_fee_id').text(id);
            //     $('#r_student_name').text(student_name);
            //     $('#r_amount').text(parseFloat(amount).toFixed(2));
            //     $('#r_pay_date').text(pay_date);
            //     $('#r_month_for').text(month_for);
            //     $('#r_payment_mode').text(payment_mode);
            //     $('#r_rent').text($('#rent_per_month_val').text());
            //     $('#r_paid_fees').text($('#paid_fees_val').text());
            //     $('#r_remaining_fees').text($('#remaining_fees_val').text());
            //     $('#r_date').text(new Date().toLocaleString());

            //     var modal = new bootstrap.Modal(document.getElementById('feeReceiptModal'));
            //     modal.show();
            // });
            // Receipt Button
            $(document).on('click', '.receiptbtn', function() {
                var id           = $(this).attr('data-id');

                // ===== Read from INPUT FIELDS (always current value) =====
                var amount       = $('#amount'       + id).val();
                var pay_date     = $('#pay_date'     + id).val();
                var month_for    = $('#month_for'    + id).val();
                var payment_mode = $('#payment_mode' + id).val();
                // =========================================================

                var student_name = $('#student option:selected').text();

                $('#r_fee_id').text(id);
                $('#r_student_name').text(student_name);
                $('#r_amount').text(parseFloat(amount || 0).toFixed(2));
                $('#r_pay_date').text(pay_date);
                $('#r_month_for').text(month_for);
                $('#r_payment_mode').text(payment_mode);
                $('#r_rent').text($('#rent_per_month_val').text());
                $('#r_paid_fees').text($('#paid_fees_val').text());
                $('#r_remaining_fees').text($('#remaining_fees_val').text());
                $('#r_date').text(new Date().toLocaleString());
                $('#r_extra_section').hide();

                var modal = new bootstrap.Modal(document.getElementById('feeReceiptModal'));
                modal.show();
            });

            // Update Fee
            $(document).on('click', '.updatebtn', function() {
                var id = $(this).attr('data-id');
                var newAmount = parseFloat($('#amount' + id).val());

                $.ajax({
                    url: '/fee_update/' + id,
                    type: 'post',
                    data: {
                        _token:       '{{ csrf_token() }}',
                        amount:       $('#amount' + id).val(),
                        pay_date:     $('#pay_date' + id).val(),
                        month_for:    $('#month_for' + id).val(),
                        payment_mode: $('#payment_mode' + id).val()
                    },
                    success: function(data) {
                        alert('Updated successfully');

                        // Recalculate Paid from ALL rows
                        var totalPaid = 0;
                        $('#feebody tr').each(function() {
                            var rowId     = $(this).find('.updatebtn').attr('data-id');
                            var rowAmount = parseFloat($('#amount' + rowId).val()) || 0;
                            totalPaid    += rowAmount;
                        });

                        var rent         = parseFloat($('#rent_per_month_val').text().replace(/,/g,''));
                        var newRemaining = (totalPaid == 0 || rent == 0) ? 0 : (rent - totalPaid);

                        $('#paid_fees_val').text(totalPaid.toFixed(2));
                        $('#remaining_fees_val').text(newRemaining.toFixed(2));
                    },
                    error: function(xhr) {
                        alert('Update failed!');
                    }
                });
            });

            // Delete Fee
            $(document).on('click', '.deletebtn', function() {
                var id        = $(this).attr('data-id');
                var row       = $(this).closest('tr');
                var rowAmount = parseFloat($('#amount' + id).val());

                $.ajax({
                    url: '/fee_delete/' + id,
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(data) {
                        alert('Deleted successfully');
                        row.remove();

                        var curPaid      = parseFloat($('#paid_fees_val').text().replace(/,/g,''));
                        var rent         = parseFloat($('#rent_per_month_val').text().replace(/,/g,''));
                        var newPaid      = Math.max(0, curPaid - rowAmount);
                        var newRemaining = (newPaid == 0 || rent == 0) ? 0 : (rent - newPaid);
                        $('#paid_fees_val').text(newPaid.toFixed(2));
                        $('#remaining_fees_val').text(newRemaining.toFixed(2));

                        if($('#feebody tr').length == 0) {
                            $('#feebody').html(
                                '<tr><td colspan="8" class="text-center text-danger py-3">' +
                                '<i class="bi bi-exclamation-circle me-1"></i>No fees found for this student.' +
                                '</td></tr>'
                            );
                        }
                    },
                    error: function(xhr) {
                        var r = JSON.parse(xhr.responseText);
                        alert(r.message);
                    }
                });
            });

            // Change Password
            $('#changePasswordBtn').on('click', function() {
                var current_password = $('#current_password').val();
                var new_password     = $('#new_password').val();
                var confirm_password = $('#confirm_password').val();
                $('#pwSuccess, #pwError').hide();
                if(current_password == '') { 
                    $('#pwError').show(); $('#pwErrorMsg').text('Please enter current password!'); 
                    return; 
                }
                else if(new_password == '') { 
                    $('#pwError').show(); $('#pwErrorMsg').text('Please enter new password!'); 
                    return; 
                }
                else if(new_password.length < 6) { 
                    $('#pwError').show(); $('#pwErrorMsg').text('Min 6 characters!'); 
                    return; 
                }
                else if(confirm_password == '') { $('#pwError').show(); $('#pwErrorMsg').text('Please confirm password!'); 
                    return; 
                }
                else if(new_password !== confirm_password) { 
                    $('#pwError').show(); $('#pwErrorMsg').text('Passwords do not match!'); 
                    return; 
                }
                $.ajax({
                    url: '{{ route("change_password") }}',
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}', 
                        current_password: current_password, 
                        new_password: new_password, 
                        confirm_password: confirm_password 
                    },
                    success: function(data) {
                        $('#pwSuccess').show();
                        $('#pwSuccessMsg').text(data.message || 'Password changed successfully!');
                        $('#current_password, #new_password, #confirm_password').val('');
                        setTimeout(function() { 
                            $('#changePasswordModal').modal('hide'); $('#pwSuccess').hide(); 
                        }, 2000);
                    },
                    error: function(xhr) {
                        var r = JSON.parse(xhr.responseText);
                        $('#pwError').show();
                        $('#pwErrorMsg').text(r.message || 'Something went wrong!');
                    }
                });
            });

            $('#changePasswordModal').on('hidden.bs.modal', function() {
                $('#current_password, #new_password, #confirm_password').val('');
                $('#pwSuccess, #pwError').hide();
                ['current_password','new_password','confirm_password'].forEach(function(id) {
                    document.getElementById(id).type = 'password';
                });
                document.getElementById('eyeCurrent').className = 'bi bi-eye-slash';
                document.getElementById('eyeNew').className     = 'bi bi-eye-slash';
                document.getElementById('eyeConfirm').className = 'bi bi-eye-slash';
            });
        });

        // Eye Toggle
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon  = document.getElementById(iconId);
            if(input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }

        // Print Receipt
        function printReceipt() {
            var content     = document.getElementById('receiptContent').innerHTML;
            var printWindow = window.open('', '', 'width=700,height=700');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Fee Receipt</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                    <style>
                        body { padding:30px; font-family:Arial, sans-serif; }
                        .modal-header { background-color:#0d6efd !important; color:white; padding:15px; border-radius:8px 8px 0 0; -webkit-print-color-adjust:exact; }
                        .modal-footer { display:none !important; }
                        .btn-close    { display:none !important; }
                        .text-success { color:#198754 !important; -webkit-print-color-adjust:exact; }
                    </style>
                </head>
                <body>
                    ${content}
                    <script>window.onload = function() { window.print(); window.close(); }<\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
</body>
</html>