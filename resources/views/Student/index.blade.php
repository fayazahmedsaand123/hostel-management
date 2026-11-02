<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/student.css') }}">
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
                <a class="nav-link fw-bold" href="{{ route('student') }}">Student</a>
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
                <i class="bi bi-mortarboard-fill me-2"></i>Student Management
            </h2>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Student List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>DOB</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Dept</th>
                                <th>City</th>
                                <th>Join Date</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>ID Card</th>
                            </tr>
                        </thead>
                        <tbody id="studentbody">
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->student_id }}</td>
                                    <td><input type="text" class="form-control form-control-sm" style="width:110px;" id="name{{ $student->student_id }}" value="{{ $student->name }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" style="width:50px;" id="gender{{ $student->student_id }}" value="{{ $student->gender }}"></td>
                                    <td><input type="date" class="form-control form-control-sm" style="width:120px;" id="dob{{ $student->student_id }}" value="{{ $student->dob }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" style="width:110px;" id="phone{{ $student->student_id }}" value="{{ $student->phone }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" style="width:160px;" id="email{{ $student->student_id }}" value="{{ $student->email }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" style="width:60px;" id="department{{ $student->student_id }}" value="{{ $student->department }}"></td>
                                    <td><input type="text" class="form-control form-control-sm" style="width:100px;" id="city{{ $student->student_id }}" value="{{ $student->city }}"></td>
                                    <td><input type="date" class="form-control form-control-sm" style="width:120px;" id="join_date{{ $student->student_id }}" value="{{ $student->join_date }}"></td>
                                    <td><button class="btn-update updatebtn" data-id="{{ $student->student_id }}">Update</button></td>
                                    <td><button class="btn-delete deletebtn" data-id="{{ $student->student_id }}">Delete</button></td>
                                    <td>
                                        <button class="btn-idcard idcardbtn" data-id="{{ $student->student_id }}"
                                            data-name="{{ $student->name }}"
                                            data-gender="{{ $student->gender }}"
                                            data-dob="{{ $student->dob }}"
                                            data-dept="{{ $student->department }}"
                                            data-city="{{ $student->city }}"
                                            data-join="{{ $student->join_date }}">
                                            <i class="bi bi-person-badge-fill me-1"></i>ID Card
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-danger py-3">
                                        <i class="bi bi-exclamation-circle me-1"></i>No students found. Please add a student below.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-section">
            <h5 class="fw-bold text-primary mb-3">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Student
            </h5>
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" id="name" class="form-control" placeholder="Full Name">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Gender</label>
                    <select id="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Date of Birth</label>
                    <input type="date" id="dob" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Phone</label>
                    <input type="text" id="phone" class="form-control" placeholder="Phone">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Email</label>
                    <input type="text" id="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Department</label>
                    <input type="text" id="department" class="form-control" placeholder="Dept">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">City</label>
                    <input type="text" id="city" class="form-control" placeholder="City">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Join Date</label>
                    <input type="date" id="join_date" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="addbtn" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i>Add Student
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- ID Card Modal OUTSIDE container --}}
    <div class="modal fade" id="idCardModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#0d6efd; color:white;">
                    <h5 class="modal-title">
                        <i class="bi bi-person-badge-fill me-2"></i>Student ID Card
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="idCardContent" style="width:700px; margin:auto; font-family:Arial, sans-serif;">

                        {{-- Card Header --}}
                        <div style="background:linear-gradient(135deg,#1a237e 0%,#0d6efd 60%,#ffc107 100%); padding:20px 25px; display:flex; align-items:center; gap:15px;">
                            <div style="background:white; border-radius:50%; width:55px; height:55px; display:flex; align-items:center; justify-content:center;">
                                <i class="bi bi-building" style="font-size:28px; color:#1a237e;"></i>
                            </div>
                            <div>
                                <div style="color:white; font-size:20px; font-weight:bold;">HMS Portal</div>
                                <div style="color:#ffc107; font-size:13px;">Hostel Management System — Hyderabad</div>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div style="background:white; padding:25px; display:flex; gap:25px; align-items:center; position:relative; overflow:hidden;">
                            {{-- Watermark --}}
                            <div style="position:absolute; right:-20px; bottom:-20px; opacity:0.05; font-size:150px;">
                                <i class="bi bi-building"></i>
                            </div>

                            {{-- Photo Section --}}
                            <div style="flex-shrink:0; text-align:center;">
                                <div style="width:120px; height:120px; border-radius:50%; border:4px solid #0d6efd; overflow:hidden; background:#e8f0fe; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-person-fill" style="font-size:70px; color:#0d6efd;"></i>
                                </div>
                                <div style="margin-top:8px;">
                                    <span id="card_student_id_badge" style="background:#0d6efd; color:white; padding:3px 12px; border-radius:20px; font-size:12px; font-weight:bold;"></span>
                                </div>
                            </div>

                            {{-- Info Section --}}
                            <div style="flex:1;">
                                <div style="background:#ffc107; padding:8px 15px; border-radius:6px; margin-bottom:15px;">
                                    <span id="card_name" style="font-size:20px; font-weight:bold; color:#1a237e;"></span>
                                </div>
                                <table style="width:100%; border-collapse:collapse; font-size:14px;">
                                    <tr>
                                        <td style="padding:5px 0; font-weight:bold; width:130px; color:#333;">
                                            <i class="bi bi-hash me-1" style="color:#0d6efd;"></i>Student ID
                                        </td>
                                        <td style="color:#555;">: <span id="card_id"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0; font-weight:bold; color:#333;">
                                            <i class="bi bi-gender-ambiguous me-1" style="color:#0d6efd;"></i>Gender
                                        </td>
                                        <td style="color:#555;">: <span id="card_gender"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0; font-weight:bold; color:#333;">
                                            <i class="bi bi-calendar-date me-1" style="color:#0d6efd;"></i>Date of Birth
                                        </td>
                                        <td style="color:#555;">: <span id="card_dob"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0; font-weight:bold; color:#333;">
                                            <i class="bi bi-building me-1" style="color:#0d6efd;"></i>Department
                                        </td>
                                        <td style="color:#555;">: <span id="card_dept"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0; font-weight:bold; color:#333;">
                                            <i class="bi bi-geo-alt-fill me-1" style="color:#0d6efd;"></i>City
                                        </td>
                                        <td style="color:#555;">: <span id="card_city"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0; font-weight:bold; color:#333;">
                                            <i class="bi bi-calendar-check me-1" style="color:#0d6efd;"></i>Join Date
                                        </td>
                                        <td style="color:#555;">: <span id="card_join"></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div style="background:#1a237e; padding:10px 25px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#ffc107; font-size:12px; font-weight:bold;">
                                <i class="bi bi-shield-check me-1"></i>Official Hostel ID Card
                            </span>
                            <span style="color:white; font-size:11px;">
                                <i class="bi bi-calendar me-1"></i>Issued: <span id="card_issued"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="printIDCard()">
                        <i class="bi bi-printer-fill me-2"></i>Print ID Card
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
        var currentStudentName = '';
        $(document).ready(function() {

            // Add Student
            $('#addbtn').on('click', function() {
                var name       = $('#name').val();
                var gender     = $('#gender').val();
                var dob        = $('#dob').val();
                var phone      = $('#phone').val();
                var email      = $('#email').val();
                var department = $('#department').val();
                var city       = $('#city').val();
                var join_date  = $('#join_date').val();

                if(name.trim() == '') { 
                    alert('Please enter name!'); 
                    return; 
                }
                else if(gender == '') { 
                    alert('Please select gender!'); 
                    return;
                }

                $.ajax({
                    url: '{{ route("student_add") }}',
                    type: 'post',
                    data: { 
                        _token: '{{ csrf_token() }}', 
                        name: name, 
                        gender: gender, 
                        dob: dob, 
                        phone: phone, 
                        email: email, 
                        department: department, 
                        city: city, 
                        join_date: join_date 
                    },
                    success: function(data) {
                        alert('Added successfully');
                        $('#studentbody tr td[colspan]').closest('tr').remove();
                        var s = data.student;
                        $('#studentbody').append(
                            '<tr>' +
                            '<td>' + s.student_id + '</td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:110px;" id="name' + s.student_id + '" value="' + s.name + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:50px;" id="gender' + s.student_id + '" value="' + s.gender + '"></td>' +
                            '<td><input type="date" class="form-control form-control-sm" style="width:120px;" id="dob' + s.student_id + '" value="' + s.dob + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:110px;" id="phone' + s.student_id + '" value="' + s.phone + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:160px;" id="email' + s.student_id + '" value="' + s.email + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:60px;" id="department' + s.student_id + '" value="' + s.department + '"></td>' +
                            '<td><input type="text" class="form-control form-control-sm" style="width:100px;" id="city' + s.student_id + '" value="' + s.city + '"></td>' +
                            '<td><input type="date" class="form-control form-control-sm" style="width:120px;" id="join_date' + s.student_id + '" value="' + s.join_date + '"></td>' +
                            '<td><button class="btn-update updatebtn" data-id="' + s.student_id + '">Update</button></td>' +
                            '<td><button class="btn-delete deletebtn" data-id="' + s.student_id + '">Delete</button></td>' +
                            // Add in BOTH load rows AND add success append
                            '<td><button class="btn-idcard idcardbtn" ' +
                                'data-id="' + s.student_id + '" ' +
                                'data-name="' + s.name + '" ' +
                                'data-gender="' + s.gender + '" ' +
                                'data-dob="' + s.dob + '" ' +
                                'data-dept="' + s.department + '" ' +
                                'data-city="' + s.city + '" ' +
                                'data-join="' + s.join_date + '">' +
                                '<i class="bi bi-person-badge-fill me-1"></i>ID Card' +
                                '</button></td>' +
                            '</tr>'
                        );
                        $('#name, #phone, #email, #department, #city').val('');
                        $('#gender').val(''); 
                        $('#dob').val(''); 
                        $('#join_date').val('');
                    }
                });
            });

            // Update Student
            $(document).on('click', '.updatebtn', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/student_update/' + id,
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name:       $('#name' + id).val(),
                        gender:     $('#gender' + id).val(),
                        dob:        $('#dob' + id).val(),
                        phone:      $('#phone' + id).val(),
                        email:      $('#email' + id).val(),
                        department: $('#department' + id).val(),
                        city:       $('#city' + id).val(),
                        join_date:  $('#join_date' + id).val()
                    },
                    success: function(data) { 
                        alert('Updated successfully');
                    },
                    error: function(xhr) { 
                        alert('Update failed!');
                    }
                });
            });

            // Delete Student
            $(document).on('click', '.deletebtn', function() {
                var id  = $(this).attr('data-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: '/student_delete/' + id,
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(data) { 
                        alert('Deleted successfully'); 
                        row.remove(); 
                        if($('#studentbody tr').length == 0) {
                            $('#studentbody').html('<tr><td colspan="11" class="text-center text-muted py-3"><i class="bi bi-exclamation-circle me-1"></i>No students found. Please add a student below.</td></tr>');
                        }
                    },
                    error: function(xhr) { 
                        var r = JSON.parse(xhr.responseText); 
                        alert(r.message); 
                    }
                });
            });

            // ID Card Button
            $(document).on('click', '.idcardbtn', function() {
                currentStudentName = $(this).attr('data-name'); // Get from data-name!
                var id     = $(this).attr('data-id');
                var name   = $(this).attr('data-name');
                var gender = $(this).attr('data-gender');
                var dob    = $(this).attr('data-dob');
                var dept   = $(this).attr('data-dept');
                var city   = $(this).attr('data-city');
                var join   = $(this).attr('data-join');

                // Fill card data
                $('#card_id').text(id);
                $('#card_student_id_badge').text('ID: ' + id);
                $('#card_name').text(currentStudentName); 
                $('#card_gender').text(gender == 'M' ? 'Male' : 'Female');
                $('#card_dob').text(dob || 'N/A');
                $('#card_dept').text(dept || 'N/A');
                $('#card_city').text(city || 'N/A');
                $('#card_join').text(join || 'N/A');
                $('#card_issued').text(new Date().toLocaleDateString());

                // Reset photo
                $('#photoPreview').html('<i class="bi bi-person-fill" style="font-size:60px; color:#0d6efd;"></i>');
                $('#photoUpload').val('');

                var modal = new bootstrap.Modal(document.getElementById('idCardModal'));
                modal.show();
            });

            // Photo Upload Preview
            $(document).on('change', '#photoUpload', function() {
                var file   = this.files[0];
                if(file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#photoPreview').html(
                            '<img src="' + e.target.result + '" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">'
                        );
                    };
                    reader.readAsDataURL(file);
                }
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

        // Print ID Card — OUTSIDE ready()
        function printIDCard() {
            var content = document.getElementById('idCardContent').innerHTML;
            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write(`
                <html>
                <head>
                    <title>${currentStudentName}</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                    <style>
                        body { margin:20px; font-family:Arial, sans-serif; }
                        @media print {
                            body { margin:0; }
                            @page { size:A6 landscape; margin:10mm; }
                        }
                        .text-primary { color:#0d6efd !important; -webkit-print-color-adjust:exact; }
                    </style>
                </head>
                <body>
                    <div style="width:700px; margin:auto; font-family:Arial, sans-serif;">
                        ${content}
                    </div>
                    <script>window.onload = function() { window.print(); window.close(); }<\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
</body>
</html>