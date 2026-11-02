<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Visitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/visitor.css') }}">
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
                <a class="nav-link" href="{{ route('fee') }}">Fee</a>
                <a class="nav-link fw-bold" href="{{ route('visitor') }}">Visitor</a>
                <a class="nav-link" href="{{ route('complaint') }}">Complaint</a>
                {{-- User name + Logout --}}
                {{-- <div class="nav-link">
                    <span style="background:rgba(255,255,255,0.2); padding:4px 12px; border-radius:20px;">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" style="background:#dc3545; color:white; border:none; padding:6px 14px; border-radius:6px; transition:all 0.3s;">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>  --}}
                {{-- Replace old user span + logout form with this --}}
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        style="background:rgba(255,255,255,0.2); color:white; border:none; padding:6px 14px; border-radius:20px;">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        {{-- Profile Info --}}
                        <li>
                            <div class="px-3 py-2 border-bottom">
                                <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                                <div class="text-muted" style="font-size:12px;">{{ Auth::user()->email }}</div>
                            </div>
                        </li>
                        {{-- Change Password --}}
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-key-fill me-2 text-primary"></i>Change Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        {{-- Logout --}}
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
            <h2>
                <i class="bi bi-person-lines-fill me-2"></i>Visitor Management
            </h2>
        </div>
        <div class="select-section">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="bi bi-person-fill me-1"></i>Select Student
                    </label>
                    <select id="student" class="form-select">
                        <option value="">-- Select Student --</option>
                        @forelse ($students as $student)
                            <option value="{{ $student->student_id }}">{{ $student->name }}</option>
                        @empty
                            <option disabled>No students found</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        <div class="card mb-4" id="visitortable" style="display:none;">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Visitor List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Visitor Name</th>
                                <th>Relation</th>
                                <th>Visit Date</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Gate Pass</th>
                            </tr>
                        </thead>
                        <tbody id="visitorbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-section" id="addform" style="display:none;">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Visitor
            </h5>
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-bold">Visitor Name</label>
                    <input type="text" id="visitor_name" class="form-control" placeholder="Visitor Name">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Relation</label>
                    <input type="text" id="relation" class="form-control" placeholder="e.g. Father">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Visit Date</label>
                    <input type="date" id="visit_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">In Time</label>
                    <input type="time" id="in_time" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Out Time</label>
                    <input type="time" id="out_time" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="addbtn" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i>Add Visitor
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Visitor Gate Pass Modal OUTSIDE container --}}
    <div class="modal fade" id="visitorReceiptModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="visitorReceiptContent">
                <div class="modal-header" style="background-color:#0d6efd; color:white;">
                    <h5 class="modal-title">
                        <i class="bi bi-person-badge me-2"></i>Visitor Gate Pass
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-building" style="font-size:40px; color:#0d6efd;"></i>
                        <h4 class="fw-bold mt-2">HMS Portal</h4>
                        <p class="text-muted mb-0">Hostel Management System</p>
                        <hr>
                        <h5 class="text-primary fw-bold">
                            <i class="bi bi-card-text me-2"></i>VISITOR GATE PASS
                        </h5>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p><strong><i class="bi bi-hash me-1"></i>Pass No:</strong> <span id="vr_id"></span></p>
                            <p><strong><i class="bi bi-person-fill me-1"></i>Visitor Name:</strong> <span id="vr_name"></span></p>
                            <p><strong><i class="bi bi-heart-fill me-1"></i>Relation:</strong> <span id="vr_relation"></span></p>
                        </div>
                        <div class="col-6 text-end">
                            <p><strong><i class="bi bi-calendar-date me-1"></i>Visit Date:</strong> <span id="vr_date"></span></p>
                            <p><strong><i class="bi bi-box-arrow-in-right me-1"></i>In Time:</strong> <span id="vr_in"></span></p>
                            <p><strong><i class="bi bi-box-arrow-right me-1"></i>Out Time:</strong> <span id="vr_out"></span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="fw-bold">
                            <i class="bi bi-mortarboard-fill me-1 text-primary"></i>Visiting Student: <span id="vr_student"></span>
                        </p>
                    </div>
                    <hr>
                    <div class="text-center text-muted">
                        <small><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>This pass must be shown at the gate.</small><br>
                        <small><i class="bi bi-clock me-1"></i>Generated: <span id="vr_generated"></span></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="printVisitorReceipt()">
                        <i class="bi bi-printer-fill me-2"></i>Print Gate Pass
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
                    <h5 class="modal-title">
                        <i class="bi bi-key-fill me-2"></i>Change Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Success/Error messages --}}
                    <div id="pwSuccess" class="alert alert-success" style="display:none;">
                        <i class="bi bi-check-circle-fill me-2"></i> Changed password successfully
                        <span id="pwSuccessMsg"></span>
                    </div>
                    <div id="pwError" class="alert alert-danger" style="display:none;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <span id="pwErrorMsg"></span>
                    </div>
                    {{-- Current Password --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill text-primary"></i>
                            </span>
                            <input type="password" id="current_password" class="form-control"
                                placeholder="Enter current password">
                            <span class="input-group-text" onclick="togglePassword('current_password','eyeCurrent')"
                                style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="eyeCurrent"></i>
                            </span>
                        </div>
                    </div>
                    {{-- New Password --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill text-primary"></i>
                            </span>
                            <input type="password" id="new_password" class="form-control"
                                placeholder="Min 6 characters">
                            <span class="input-group-text" onclick="togglePassword('new_password','eyeNew')"
                                style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="eyeNew"></i>
                            </span>
                        </div>
                    </div>
                    {{-- Confirm New Password --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill text-primary"></i>
                            </span>
                            <input type="password" id="confirm_password" class="form-control"
                                placeholder="Repeat new password">
                            <span class="input-group-text" onclick="togglePassword('confirm_password','eyeConfirm')"
                                style="cursor:pointer;">
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
        $(document).ready(function() {

            // Student Dropdown
            $('#student').on('change', function() {
                var student_id = $(this).val();
                $('#visitorbody').html('');
                $('#visitortable, #addform').hide();
                if(student_id == '') return;

                $.ajax({
                    url: '/get_visitors/' + student_id,
                    type: 'get',
                    success: function(data) {
                        if(data.visitors.length == 0) {
                            $('#visitorbody').html('<tr><td colspan="9" class="text-center text-danger py-3"><i class="bi bi-exclamation-circle me-1"></i>No visitors found for this student.</td></tr>');
                            $('#visitortable').show();
                            $('#addform').show();
                            return;
                        }
                        var rows = '';
                        $.each(data.visitors, function(i, v) {
                            rows +=
                                '<tr>' +
                                '<td>' + v.visitor_id + '</td>' +
                                '<td><input type="text" class="form-control form-control-sm" style="width:100px;" id="visitor_name' + v.visitor_id + '" value="' + v.visitor_name + '"></td>' +
                                '<td><input type="text" class="form-control form-control-sm" style="width:80px;" id="relation' + v.visitor_id + '" value="' + v.relation + '"></td>' +
                                '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="visit_date' + v.visitor_id + '" value="' + v.visit_date + '"></td>' +
                                '<td><input type="time" class="form-control form-control-sm" style="width:110px;" id="in_time' + v.visitor_id + '" value="' + v.in_time + '"></td>' +
                                '<td><input type="time" class="form-control form-control-sm" style="width:110px;" id="out_time' + v.visitor_id + '" value="' + v.out_time + '"></td>' +
                                '<td><button class="btn-update updatebtn" data-id="' + v.visitor_id + '">Update</button></td>' +
                                '<td><button class="btn-delete deletebtn" data-id="' + v.visitor_id + '">Delete</button></td>' +
                                '<td><button class="btn btn-warning btn-sm gatepassbtn" data-id="' + v.visitor_id + '" data-name="' + v.visitor_name + '" data-relation="' + 
                                                                                                    v.relation + '" data-date="' + v.visit_date + '" data-in="' + 
                                                                                                    v.in_time + '" data-out="' + v.out_time + '"><i class="bi bi-person-badge me-1"></i>Gate Pass</button></td>' +
                                '</tr>';
                        });
                        $('#visitorbody').html(rows);
                        $('#visitortable').show();
                        $('#addform').show();
                    }
                });
            });

            // Add Visitor
            $('#addbtn').on('click', function() {
                var student_id   = $('#student').val();
                var visitor_name = $('#visitor_name').val();
                var relation     = $('#relation').val();
                var visit_date   = $('#visit_date').val();
                var in_time      = $('#in_time').val();
                var out_time     = $('#out_time').val();

                if(student_id == '') { 
                    alert('Please select student!');
                    return;
                }
                else if(visitor_name == '') { 
                    alert('Please enter visitor name!');
                    return;
                }
                else if(visit_date == '') { 
                    alert('Please enter visit date!');
                    return;
                }

                $.ajax({
                    url: '{{ route("visitor_add") }}',
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}', 
                        student_id: student_id, 
                        visitor_name: visitor_name, 
                        relation: relation, 
                        visit_date: visit_date, 
                        in_time: in_time, 
                        out_time: out_time 
                    },
                    success: function(data) {
                        alert('Added successfully');
                        $('#visitorbody tr td[colspan]').closest('tr').remove();    
                        var v = data.visitor;
                        $('#visitorbody').append(
                            '<tr>' +
                            '<td>' + v.visitor_id + '</td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:100px;" id="visitor_name' + v.visitor_id + '" value="' + v.visitor_name + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:80px;" id="relation' + v.visitor_id + '" value="' + v.relation + '"></td>' +
                            '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="visit_date' + v.visitor_id + '" value="' + v.visit_date + '"></td>' +
                            '<td><input type="time" class="form-control form-control-sm" style="width:110px;" id="in_time' + v.visitor_id + '" value="' + v.in_time + '"></td>' +
                            '<td><input type="time" class="form-control form-control-sm" style="width:110px;" id="out_time' + v.visitor_id + '" value="' + v.out_time + '"></td>' +
                            '<td><button class="btn-update updatebtn" data-id="' + v.visitor_id + '">Update</button></td>' +
                            '<td><button class="btn-delete deletebtn" data-id="' + v.visitor_id + '">Delete</button></td>' +
                            '<td><button class="btn btn-warning btn-sm gatepassbtn" data-id="' + v.visitor_id + '" data-name="' + v.visitor_name + '" data-relation="' + 
                                                                                                v.relation + '" data-date="' + v.visit_date + '" data-in="' + v.in_time + '" data-out="' + 
                                                                                                v.out_time + '"><i class="bi bi-person-badge me-1"></i>Gate Pass</button></td>' +
                            '</tr>'
                        );
                        $('#visitor_name').val('');
                        $('#relation').val(''); 
                        $('#visit_date').val(''); 
                        $('#in_time').val(''); 
                        $('#out_time').val('');
                    }
                });
            });

            // Gate Pass button
            $(document).on('click', '.gatepassbtn', function() {
                var id       = $(this).attr('data-id');
                var name     = $(this).attr('data-name');
                var relation = $(this).attr('data-relation');
                var date     = $(this).attr('data-date');
                var in_time  = $(this).attr('data-in');
                var out_time = $(this).attr('data-out');
                var student  = $('#student option:selected').text();

                $('#vr_id').text(id);
                $('#vr_name').text(name);
                $('#vr_relation').text(relation);
                $('#vr_date').text(date);
                $('#vr_in').text(in_time);
                $('#vr_out').text(out_time);
                $('#vr_student').text(student);
                $('#vr_generated').text(new Date().toLocaleString());

                var modal = new bootstrap.Modal(document.getElementById('visitorReceiptModal'));
                modal.show();
            });

            // Update Visitor
            $(document).on('click', '.updatebtn', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/visitor_update/' + id,
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}', 
                        visitor_name: $('#visitor_name' + id).val(), 
                        relation: $('#relation' + id).val(), 
                        visit_date: $('#visit_date' + id).val(), 
                        in_time: $('#in_time' + id).val(), 
                        out_time: $('#out_time' + id).val()
                    },
                    success: function(data) { 
                        alert('Updated successfully'); 
                    },
                    error: function(xhr) { 
                        alert('Update failed!'); 
                    }
                });
            });

            // Delete Visitor
            $(document).on('click', '.deletebtn', function() {
                var id  = $(this).attr('data-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: '/visitor_delete/' + id,
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(data) { 
                        alert('Deleted successfully'); 
                        row.remove(); 
                        if($('#visitorbody tr').length == 0) {
                            $('#visitorbody').html('<tr><td colspan="8" class="text-center text-muted py-3"><i class="bi bi-exclamation-circle me-1"></i>No visitors found for this student.</td></tr>');
                        }
                    },
                    error: function(xhr) { 
                        var r = JSON.parse(xhr.responseText); 
                        alert(r.message); 
                    }
                });
            });
        });

        // Eye Toggle Function
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

        // Change Password AJAX
        $(document).ready(function() {
            $('#changePasswordBtn').on('click', function() {
                var current_password = $('#current_password').val();
                var new_password     = $('#new_password').val();
                var confirm_password = $('#confirm_password').val();

                // Hide messages
                $('#pwSuccess, #pwError').hide();

                if(current_password == '') {
                    $('#pwError').show();
                    $('#pwErrorMsg').text('Please enter current password!');
                    return;
                }
                else if(new_password == '') {
                    $('#pwError').show();
                    $('#pwErrorMsg').text('Please enter new password!');
                    return;
                }
                else if(new_password.length < 6) {
                    $('#pwError').show();
                    $('#pwErrorMsg').text('New password must be at least 6 characters!');
                    return;
                }
                else if(confirm_password == '') {
                    $('#pwError').show();
                    $('#pwErrorMsg').text('Please confirm new password!');
                    return;
                }
                else if(new_password !== confirm_password) {
                    $('#pwError').show();
                    $('#pwErrorMsg').text('Passwords do not match!');
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
                        // Show success
                        $('#pwSuccess').show();
                        ('#pwSuccessMsg').text(data.message || 'Password changed successfully!');
                        $('#pwError').hide();
                        // Clear inputs
                        $('#current_password').val('');
                        $('#new_password').val('');
                        $('#confirm_password').val('');
                        // Auto close modal after 2 seconds
                        setTimeout(function() {
                            $('#changePasswordModal').modal('hide');
                            $('#pwSuccess').hide();
                        }, 2000);
                    },  
                    error: function(xhr) {
                        var r = JSON.parse(xhr.responseText);
                        $('#pwError').show();
                        $('#pwErrorMsg').text(r.message || 'Something went wrong!');
                        $('#pwSuccess').hide();
                    }
                });
            });

            // Clear form when modal closes
            $('#changePasswordModal').on('hidden.bs.modal', function() {
                $('#current_password, #new_password, #confirm_password').val('');
                $('#pwSuccess, #pwError').hide();
                // Reset all eyes to closed
                ['current_password','new_password','confirm_password'].forEach(function(id) {
                    document.getElementById(id).type = 'password';
                });
                document.getElementById('eyeCurrent').className = 'bi bi-eye-slash';
                document.getElementById('eyeNew').className     = 'bi bi-eye-slash';
                document.getElementById('eyeConfirm').className = 'bi bi-eye-slash';
            });
        });

        // Print Visitor Receipt
        function printVisitorReceipt() {
            var content = document.getElementById('visitorReceiptContent').innerHTML;
            var printWindow = window.open('', '', 'width=700,height=700');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Visitor Gate Pass</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                    <style>
                        body { padding: 30px; font-family: Arial, sans-serif; }
                        .modal-header { background-color: #0d6efd !important; color: white; padding: 15px; border-radius: 8px 8px 0 0; -webkit-print-color-adjust: exact; }
                        .modal-footer { display: none !important; }
                        .btn-close { display: none !important; }
                        .text-primary { color: #0d6efd !important; -webkit-print-color-adjust: exact; }
                        .text-warning { color: #ffc107 !important; -webkit-print-color-adjust: exact; }
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