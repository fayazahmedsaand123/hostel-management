<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/complaint.css') }}">
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
                <a class="nav-link" href="{{ route('visitor') }}">Visitor</a>
                <a class="nav-link fw-bold" href="{{ route('complaint') }}">Complaint</a>
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
                <i class="bi bi-chat-left-text-fill me-2"></i>Complaint Management
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
        <div class="card mb-4" id="complainttable" style="display:none;">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Complaint List
                </h5>
             </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="complaintbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-section" id="addform" style="display:none;">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Complaint
            </h5>
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-bold">Type</label>
                    <select id="complaint_type" class="form-select">
                        <option value="">Select Type</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Electricity">Electricity</option>
                        <option value="Water">Water</option>
                        <option value="Mess">Mess</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Description</label>
                    <input type="text" id="description" class="form-control" placeholder="Description">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" id="complaint_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Status</label>
                    <select id="status" class="form-select">
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="addbtn" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i>Add Complaint
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
                $('#complaintbody').html('');
                $('#complainttable, #addform').hide();
                if(student_id == '') return;

                $.ajax({
                    url: '/get_complaints/' + student_id,
                    type: 'get',
                    success: function(data) {
                        if(data.complaints.length == 0) {
                            $('#complaintbody').html('<tr><td colspan="7" class="text-center text-danger py-3"><i class="bi bi-exclamation-circle me-1"></i>No complaints found for this student.</td></tr>');
                            $('#complainttable').show();
                            $('#addform').show();
                            return;
                        }
                        var rows = '';
                        $.each(data.complaints, function(i, c) {
                            rows +=
                                '<tr>' +
                                '<td>' + c.complaint_id + '</td>' +
                                '<td><input type="text" class="form-control form-control-sm" style="width:100px;" id="complaint_type' + c.complaint_id + '" value="' + c.complaint_type + '"></td>' +
                                '<td><input type="text" class="form-control form-control-sm" style="width:200px;" id="description' + c.complaint_id + '" value="' + c.description + '"></td>' +
                                '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="complaint_date' + c.complaint_id + '" value="' + c.complaint_date + '"></td>' +
                                '<td><input type="text" class="form-control form-control-sm" style="width:90px;" id="status' + c.complaint_id + '" value="' + c.status + '"></td>' +
                                '<td><button class="btn-update updatebtn" data-id="' + c.complaint_id + '">Update</button></td>' +
                                '<td><button class="btn-delete deletebtn" data-id="' + c.complaint_id + '">Delete</button></td>' +
                                '</tr>';
                        });
                        $('#complaintbody').html(rows);
                        $('#complainttable').show();
                        $('#addform').show();
                    }
                });
            });

            // Add Complaint
            $('#addbtn').on('click', function() {
                var student_id      = $('#student').val();
                var complaint_type  = $('#complaint_type').val();
                var description     = $('#description').val();
                var complaint_date  = $('#complaint_date').val();
                var status          = $('#status').val();

                if(student_id == '') { 
                    alert('Please select student!'); 
                    return;
                }
                else if(complaint_date == '') {
                    alert('Please enter date!');
                    return;
                }

                $.ajax({
                    url: '{{ route("complaint_add") }}',
                    type: 'post',
                    data: { _token: '{{ csrf_token() }}', student_id: student_id, complaint_type: complaint_type, description: description, complaint_date: complaint_date, status: status },
                    success: function(data) {
                        alert('Added successfully');
                        $('#complaintbody tr td[colspan]').closest('tr').remove();
                        var c = data.complaint;
                        $('#complaintbody').append(
                            '<tr>' +
                            '<td>' + c.complaint_id + '</td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:100px;" id="complaint_type' + c.complaint_id + '" value="' + c.complaint_type + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:150px;" id="description' + c.complaint_id + '" value="' + c.description + '"></td>' +
                            '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="complaint_date' + c.complaint_id + '" value="' + c.complaint_date + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:90px;" id="status' + c.complaint_id + '" value="' + c.status + '"></td>' +
                            '<td><button class="btn-update updatebtn" data-id="' + c.complaint_id + '">Update</button></td>' +
                            '<td><button class="btn-delete deletebtn" data-id="' + c.complaint_id + '">Delete</button></td>' +
                            '</tr>'
                        );
                        $('#complaint_type').val('');
                        $('#description').val('');
                        $('#complaint_date').val('');
                    }
                });
            });

            // Update Complaint
            $(document).on('click', '.updatebtn', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/complaint_update/' + id,
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}', 
                        complaint_type: $('#complaint_type' + id).val(), 
                        description: $('#description' + id).val(), 
                        complaint_date: $('#complaint_date' + id).val(), 
                        status: $('#status' + id).val()
                    },
                    success: function(data) { 
                        alert('Updated successfully');
                    },
                    error: function(xhr) { 
                        alert('Update failed!');
                    }
                });
            });

            // Delete Complaint
            $(document).on('click', '.deletebtn', function() {
                var id  = $(this).attr('data-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: '/complaint_delete/' + id,
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) { 
                        alert('Deleted successfully');
                        row.remove();
                        if($('#complaintbody tr').length == 0) {
                            $('#complaintbody').html('<tr><td colspan="7" class="text-danger text-muted py-3"><i class="bi bi-exclamation-circle me-1"></i>No complaints found for this student.</td></tr>');
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
    </script>
</body>
</html>