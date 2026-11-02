<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Allocation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/allocation.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-building me-2"></i>HMS Portal
            </a>
            <div class="navbar-nav flex-row gap-3 align-items-center">
                <a class="nav-link" href="{{ route('warden') }}">Warden</a>
                <a class="nav-link" href="{{ route('hostel') }}">Hostel</a>
                <a class="nav-link" href="{{ route('room') }}">Room</a>
                <a class="nav-link" href="{{ route('student') }}">Student</a>
                <a class="nav-link fw-bold" href="{{ route('allocation') }}">Allocation</a>
                <a class="nav-link" href="{{ route('fee') }}">Fee</a>
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
            <h2><i class="bi bi-key-fill me-2"></i>Room Allocation</h2>
        </div>
        {{-- Step-by-Step Dropdowns --}}
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
                        <span class="badge bg-primary me-1">4</span>View Student Allocations
                    </label>
                    <select id="student_view" class="form-select">
                        <option value="">-- Select Student --</option>
                    </select>
                </div>
            </div>

            {{-- Capacity Info Box --}}
            <div id="capacityInfo" style="display:none;" class="mt-3">
                {{-- All Rooms Full Alert --}}
                <div id="allRoomsFullAlert" class="alert alert-danger mt-3" style="display:none;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>All Rooms Full!</strong> No capacity available in this hostel. Please add more rooms first.
                </div>
            </div>
        </div>

        {{-- Allocation Table --}}
        <div class="card mb-4" id="allocationtable" style="display:none;">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Allocation List for Selected Student</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room ID</th>
                                <th>Allot Date</th>
                                <th>Leave Date</th>
                                <th>Status</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="allocationbody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Add Allocation Form --}}
        <div class="form-section" id="addform" style="display:none;">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-plus-circle-fill me-2"></i>Add New Allocation
            </h5>

            {{-- Error/Success Alert --}}
            <div id="addSuccess" class="alert alert-success" style="display:none;"></div>
            <div id="addError"   class="alert alert-danger"  style="display:none;"></div>

            <div class="row g-3">
                {{-- Student Dropdown — only unallocated! --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="bi bi-person-fill me-1"></i>Select Student
                        <small class="text-muted">(unallocated only)</small>
                    </label>
                    <select id="student_id" class="form-select">
                        <option value="">-- Select Student --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Allot Date</label>
                    <input type="date" id="allot_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Leave Date</label>
                    <input type="date" id="leave_date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Status</label>
                    <select id="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Left">Left</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="addbtn" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i>Add
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
                        <i class="bi bi-check-circle-fill me-2"></i><span id="pwSuccessMsg"></span>
                    </div>
                    <div id="pwError" class="alert alert-danger" style="display:none;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i><span id="pwErrorMsg"></span>
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

        // Store selected room capacity globally
        var selectedRoomCapacity = 0;
        var selectedRoomId       = 0;

        $(document).ready(function() {

            // Step 1 — Warden Changed
            $('#warden').on('change', function() {
                var warden_id = $(this).val();

                // Reset all
                $('#hostel').html('<option value="">-- Select Hostel --</option>');
                $('#room').html('<option value="">-- Select Room --</option>');
                $('#student_id').html('<option value="">-- Select Student --</option>');
                $('#hostel_div, #room_div, #student_div, #addform, #allocationtable').hide();
                $('#capacityInfo, #allRoomsFullAlert').hide();
                $('#addSuccess, #addError').hide();

                if(warden_id == '') return;

                $.ajax({
                    url: '/get_hostels_for_allocation/' + warden_id,
                    type: 'get',
                    success: function(data) {
                        if(data.hostels.length == 0) {
                            alert('No hostels found for this warden!');
                            return;
                        }
                        $.each(data.hostels, function(i, hostel) {
                            $('#hostel').append(
                                '<option value="' + hostel.hostel_id + '">' + hostel.hostel_name + '</option>'
                            );
                        });
                        $('#hostel_div').show();
                    }
                });
            });

            // Step 2 — Hostel Changed
            $('#hostel').on('change', function() {
                var hostel_id = $(this).val();

                $('#room').html('<option value="">-- Select Room --</option>');
                $('#student_id').html('<option value="">-- Select Student --</option>');
                $('#room_div, #student_div, #addform, #allocationtable').hide();
                $('#capacityInfo, #allRoomsFullAlert').hide();
                $('#addSuccess, #addError').hide();

                if(hostel_id == '') return;

                $.ajax({
                    url: '/get_rooms_for_allocation/' + hostel_id,
                    type: 'get',
                    success: function(data) {

                        // Check if ALL rooms full
                        if(data.allFull) {
                            $('#allRoomsFullAlert').show();
                            $('#room_div').show();
                        }

                        $.each(data.rooms, function(i, room) {
                            var label = room.is_full
                                ? 'Room ' + room.room_no + ' — FULL (' + room.allocated + '/' + room.capacity + ')'
                                : 'Room ' + room.room_no + ' — ' + room.vacant + ' Vacant (' + room.allocated + '/' + room.capacity + ')';

                            $('#room').append(
                                '<option value="' + room.room_id + '"'
                                + (room.is_full ? ' disabled style="color:red;"' : '')
                                + ' data-capacity="' + room.capacity + '"'
                                + ' data-allocated="' + room.allocated + '"'
                                + ' data-vacant="' + room.vacant + '"'
                                + ' data-full="' + (room.is_full ? '1' : '0') + '">'
                                + label
                                + '</option>'
                            );
                        });
                        $('#room_div').show();
                    }
                });
            });

            // Step 3 — Room Changed
            $('#room').on('change', function() {
                var room_id    = $(this).val();
                var isFull     = $(this).find(':selected').data('full');
                var capacity   = $(this).find(':selected').data('capacity');
                var allocated  = $(this).find(':selected').data('allocated');
                var vacant     = $(this).find(':selected').data('vacant');

                selectedRoomId       = room_id;
                selectedRoomCapacity = capacity;

                $('#student_div, #addform, #allocationtable').hide();
                $('#capacityInfo').hide();
                $('#addSuccess, #addError').hide();

                if(room_id == '') return;

                // Show Capacity Info
                if(isFull == 1) {
                    $('#capacityInfo')
                        .removeClass('available')
                        .addClass('full capacity-info')
                        .html(
                            '<i class="bi bi-x-circle-fill text-danger me-2"></i>' +
                            '<strong class="text-danger">Room Full!</strong> ' +
                            'Capacity: ' + capacity + ' | Allocated: ' + allocated + ' | Vacant: 0'
                        )
                        .show();
                    // Don't show add form — room is full!
                    return;
                } else {
                    $('#capacityInfo')
                        .removeClass('full')
                        .addClass('available capacity-info')
                        .html(
                            '<i class="bi bi-check-circle-fill text-success me-2"></i>' +
                            '<strong class="text-success">Room Available!</strong> ' +
                            'Capacity: ' + capacity + ' | Allocated: ' + allocated + ' | ' +
                            '<strong>' + vacant + ' Slot(s) Remaining</strong>'
                        )
                        .show();
                }

                // Load unallocated students
                $.ajax({
                    url: '/get_available_students',
                    type: 'get',
                    success: function(data) {
                        $('#student_id').html('<option value="">-- Select Student --</option>');

                        if(data.students.length == 0) {
                            $('#student_id').append('<option disabled>All students are already allocated!</option>');
                        } else {
                            $.each(data.students, function(i, student) {
                                $('#student_id').append(
                                    '<option value="' + student.student_id + '">' + student.name + '</option>'
                                );
                            });
                        }
                        $('#addform').show();
                    }
                });

                // Also show student view dropdown for existing allocations
                $.ajax({
                    url: '/get_available_students',
                    type: 'get',
                    success: function(data) {
                        // Already handled above
                    }
                });
            });

            // Student View — load their allocations
            $('#student_view').on('change', function() {
                var student_id = $(this).val();
                $('#allocationbody').html('');
                $('#allocationtable').hide();
                if(student_id == '') return;

                $.ajax({
                    url: '/get_allocations/' + student_id,
                    type: 'get',
                    success: function(data) {
                        if(data.allocations.length == 0) {
                            $('#allocationbody').html('<tr><td colspan="7" class="text-center text-danger py-3"><i class="bi bi-exclamation-circle me-1"></i>No allocations found.</td></tr>');
                            $('#allocationtable').show();
                            return;
                        }
                        var rows = '';
                        $.each(data.allocations, function(i, a) {
                            rows +=
                                '<tr>' +
                                '<td>' + a.allocation_id + '</td>' +
                                '<td><input type="number" class="form-control form-control-sm" style="width:70px;" id="room_id_row' + a.allocation_id + '" value="' + a.room_id + '"></td>' +
                                '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="allot_date' + a.allocation_id + '" value="' + a.allot_date + '"></td>' +
                                '<td><input type="date" class="form-control form-control-sm" style="width:130px;" id="leave_date' + a.allocation_id + '" value="' + (a.leave_date || '') + '"></td>' +
                                '<td><select class="form-select form-select-sm" style="width:100px;" id="status' + a.allocation_id + '">' +
                                    '<option value="Active"'  + (a.status == 'Active' ? ' selected' : '') + '>Active</option>' +
                                    '<option value="Left"'    + (a.status == 'Left'   ? ' selected' : '') + '>Left</option>' +
                                '</select></td>' +
                                '<td><button class="btn-update updatebtn" data-id="' + a.allocation_id + '">Update</button></td>' +
                                '<td><button class="btn-delete deletebtn" data-id="' + a.allocation_id + '">Delete</button></td>' +
                                '</tr>';
                        });
                        $('#allocationbody').html(rows);
                        $('#allocationtable').show();
                    }
                });
            });

            // Add Allocation
            $('#addbtn').on('click', function() {
                var room_id    = selectedRoomId;
                var student_id = $('#student_id').val();
                var allot_date = $('#allot_date').val();
                var leave_date = $('#leave_date').val();
                var status     = $('#status').val();

                $('#addSuccess, #addError').hide();

                if(student_id == '') { 
                    alert('Please select student!'); 
                    return;
                }
                else if(room_id == '') { 
                    alert('Please select room!'); 
                    return;
                }
                else if(allot_date == '') { 
                    alert('Please enter allot date!'); 
                    return;
                }

                $.ajax({
                    url: '{{ route("allocation_add") }}',
                    type: 'post',
                    data: {
                        _token:     '{{ csrf_token() }}',
                        room_id:    room_id,
                        student_id: student_id,
                        allot_date: allot_date,
                        leave_date: leave_date,
                        status:     status
                    },
                    success: function(data) {
                        // Show success message
                        $('#addSuccess').show().html(
                            '<i class="bi bi-check-circle-fill me-2"></i>' + data.message
                        );
                        $('#addError').hide();

                        // Remove student from dropdown — already allocated!
                        $('#student_id option[value="' + student_id + '"]').remove();

                        // Update capacity info
                        if(data.vacant == 0) {
                            $('#capacityInfo')
                                .removeClass('available')
                                .addClass('full capacity-info')
                                .html(
                                    '<i class="bi bi-x-circle-fill text-danger me-2"></i>' +
                                    '<strong class="text-danger">Room is now FULL!</strong>'
                                );
                            // Hide add form — no more slots!
                            setTimeout(function() { $('#addform').hide(); }, 2000);
                        } else {
                            $('#capacityInfo').html(
                                '<i class="bi bi-check-circle-fill text-success me-2"></i>' +
                                '<strong class="text-success">Room Available!</strong> ' +
                                '<strong>' + data.vacant + ' Slot(s) Remaining</strong>'
                            );
                        }

                        // Clear inputs
                        $('#student_id').val('');
                        $('#allot_date').val('');
                        $('#leave_date').val('');
                        $('#status').val('Active');
                    },
                    error: function(xhr) {
                        var r = JSON.parse(xhr.responseText);
                        $('#addError').show().html(
                            '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + r.message
                        );
                    }
                });
            });

            // Update Allocation
            $(document).on('click', '.updatebtn', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/allocation_update/' + id,
                    type: 'post',
                    data: {
                        _token:     '{{ csrf_token() }}',
                        room_id:    $('#room_id_row' + id).val(),
                        allot_date: $('#allot_date' + id).val(),
                        leave_date: $('#leave_date' + id).val(),
                        status:     $('#status' + id).val()
                    },
                    success: function(data) { alert('Updated successfully'); },
                    error:   function(xhr)  { alert('Update failed!'); }
                });
            });

            // Delete Allocation
            $(document).on('click', '.deletebtn', function() {
                var id  = $(this).attr('data-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: '/allocation_delete/' + id,
                    type: 'post',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(data) {
                        alert('Deleted successfully');
                        row.remove();
                        if($('#allocationbody tr').length == 0) {
                            $('#allocationbody').html('<tr><td colspan="7" class="text-center text-danger py-3">No allocations found.</td></tr>');
                        }
                    },
                    error: function(xhr) { var r = JSON.parse(xhr.responseText); alert(r.message); }
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
                if(new_password == '') { 
                    $('#pwError').show(); $('#pwErrorMsg').text('Please enter new password!'); 
                    return;
                 }
                if(new_password.length < 6){ 
                    $('#pwError').show(); $('#pwErrorMsg').text('Min 6 characters!'); return; 
                }
                else if(confirm_password == '') { 
                    $('#pwError').show(); $('#pwErrorMsg').text('Please confirm password!'); 
                    return; 
                }
                if(new_password !== confirm_password) { 
                    $('#pwError').show(); $('#pwErrorMsg').text('Passwords do not match!'); 
                    return;
                }
                $.ajax({
                    url: '{{ route("change_password") }}',
                    type: 'post',
                    data: { _token: '{{ csrf_token() }}', current_password: current_password, new_password: new_password, confirm_password: confirm_password },
                    success: function(data) {
                        $('#pwSuccess').show(); $('#pwSuccessMsg').text(data.message || 'Password changed!');
                        $('#current_password, #new_password, #confirm_password').val('');
                        setTimeout(function() { $('#changePasswordModal').modal('hide'); $('#pwSuccess').hide(); }, 2000);
                    },
                    error: function(xhr) {
                        var r = JSON.parse(xhr.responseText);
                        $('#pwError').show(); $('#pwErrorMsg').text(r.message || 'Error!');
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
    </script>
</body>
</html>