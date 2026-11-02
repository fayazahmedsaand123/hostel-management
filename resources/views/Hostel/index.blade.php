<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Hostel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/hostel.css') }}">
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
                <a class="nav-link fw-bold" href="{{ route('hostel') }}">Hostel</a>
                <a class="nav-link" href="{{ route('room') }}">Room</a>
                <a class="nav-link" href="{{ route('student') }}">Student</a>
                <a class="nav-link" href="{{ route('allocation') }}">Allocation</a>
                <a class="nav-link" href="{{ route('fee') }}">Fee</a>
                <a class="nav-link" href="{{ route('visitor') }}">Visitor</a>
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
                <i class="bi bi-building me-2"></i>Hostel Management
            </h2>
        </div>
        <div class="select-section">
            <div class="row g-3">
                <div class="col-md-4">
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
            </div>
        </div>

        <div class="card mb-4" id="hosteltable" style="display:none;">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Hostel List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hostel Name</th>
                                <th>Type</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="hostelbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-section" id="addform" style="display:none;">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Hostel
            </h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Hostel Name</label>
                    <input type="text" id="hostel_name" class="form-control" placeholder="Hostel Name">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Hostel Type</label>
                    <select id="hostel_type" class="form-select">
                        <option value="">Select Type</option>
                        <option value="Boys">Boys</option>
                        <option value="Girls">Girls</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="addbtn" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i>Add Hostel</button>
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

            // Warden Dropdown
            $('#warden').on('change', function() {
                var warden_id = $(this).val();
                $('#hostelbody').html('');
                $('#hosteltable, #addform').hide();
                if(warden_id == '') return;

                $.ajax({
                    url: '/get_hostels/' + warden_id,
                    type: 'get',
                    success: function(data) {
                        if(data.hostels.length == 0) {
                            $('#hostelbody').html('<tr><td colspan="5" class="text-center text-danger py-3"><i class="bi bi-exclamation-circle me-1"></i>No hostels found for this warden.</td></tr>');
                            $('#hosteltable').show();
                            $('#addform').show();
                            return;
                        }
                        var rows = '';
                        $.each(data.hostels, function(i, hostel) {
                            rows +=
                                '<tr>' +
                                '<td>' + hostel.hostel_id + '</td>' +
                                '<td><input type="text" class="form-control form-control-sm" id="hostel_name' + hostel.hostel_id + '" value="' + hostel.hostel_name + '"></td>' +
                                '<td><input type="text" class="form-control form-control-sm" id="hostel_type' + hostel.hostel_id + '" value="' + hostel.hostel_type + '"></td>' +
                                '<td><button class="btn-update updatebtn" data-id="' + hostel.hostel_id + '">Update</button></td>' +
                                '<td><button class="btn-delete deletebtn" data-id="' + hostel.hostel_id + '">Delete</button></td>' +
                                '</tr>';
                        });
                        $('#hostelbody').html(rows);
                        $('#hosteltable').show();
                        $('#addform').show();
                    }
                });
            });

            // Add Hostel
            $('#addbtn').on('click', function() {
                var warden_id   = $('#warden').val();
                var hostel_name = $('#hostel_name').val();
                var hostel_type = $('#hostel_type').val();

                if(warden_id == '') { 
                    alert('Please select warden first!');
                    return;
                }
                else if(hostel_name == '') { 
                    alert('Please enter hostel name!');
                    return;
                }
                else if(hostel_type == '') { 
                    alert('Please select hostel type!');
                    return;
                }

                $.ajax({
                    url: '{{ route("hostel_add") }}',
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}', 
                        warden_id: warden_id, 
                        hostel_name: hostel_name, 
                        hostel_type: hostel_type 
                    },
                    success: function(data) {
                        alert('Added successfully');
                        $('#hostelbody tr td[colspan]').closest('tr').remove();
                        $('#hostelbody').append(
                            '<tr>' +
                            '<td>' + data.hostel.hostel_id + '</td>' +
                            '<td><input type="text" class="form-control form-control-sm" id="hostel_name' + data.hostel.hostel_id + '" value="' + data.hostel.hostel_name + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" id="hostel_type' + data.hostel.hostel_id + '" value="' + data.hostel.hostel_type + '"></td>' +
                            '<td><button class="btn-update updatebtn" data-id="' + data.hostel.hostel_id + '">Update</button></td>' +
                            '<td><button class="btn-delete deletebtn" data-id="' + data.hostel.hostel_id + '">Delete</button></td>' +
                            '</tr>'
                        );
                        $('#hostel_name').val(''); 
                        $('#hostel_type').val('');
                    }
                });
            });

            // Update Hostel
            $(document).on('click', '.updatebtn', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/hostel_update/' + id,
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}', 
                        hostel_name: $('#hostel_name' + id).val(), 
                        hostel_type: $('#hostel_type' + id).val() 
                    },
                    success: function(data) { 
                        alert('Updated successfully'); 
                    },
                    error: function(xhr) { 
                        alert('Update failed!'); 
                    }
                });
            });

            // Delete Hostel
            $(document).on('click', '.deletebtn', function() {
                var id  = $(this).attr('data-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: '/hostel_delete/' + id,
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(data) { 
                        alert('Deleted successfully'); 
                        row.remove(); 
                        if($('#hostelbody tr').length == 0) {
                            $('#hostelbody').html('<tr><td colspan="5" class="text-center text-danger py-3"><i class="bi bi-exclamation-circle me-1"></i>No hostels found for this warden.</td></tr');
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