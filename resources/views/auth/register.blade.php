<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>HMS Portal — Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/register.css') }}">
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="icon-circle">
                <i class="bi bi-building" style="font-size:32px;"></i>
            </div>
            <h3 class="fw-bold mb-1">HMS Portal</h3>
            <p class="mb-0" style="opacity:0.8;">Hostel Management System</p>
        </div>
        <div class="auth-body">
            <h5 class="fw-bold text-center mb-4 text-dark">
                <i class="bi bi-person-plus-fill me-2 text-primary"></i>Create New Account
            </h5>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form action="{{ route('register_post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-primary"></i>
                        </span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter your full name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope-fill text-primary"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill text-primary"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 6 characters" required>
                             <span class="input-group-text" onclick="togglePassword('password','eyePass')"
                                style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="eyePass"></i>
                            </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill text-primary"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Repeat your password" required>
                        <span class="input-group-text" onclick="togglePassword('password_confirmation','eyeConfirm')"
                            style="cursor:pointer;">
                            <i class="bi bi-eye-slash" id="eyeConfirm"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-person-check-fill me-2"></i>Register
                </button>
            </form>

            <hr class="my-4">
            <p class="text-center mb-0 text-muted">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link fw-bold">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login here
                </a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Toggle eye function — works for all pages!
    function togglePassword(inputId, iconId) {
        var input = document.getElementById(inputId);
        var icon  = document.getElementById(iconId);

        if(input.type === 'password') {
            input.type = 'text';           // Show password
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');  // Eye open icon
        } 
        else {
            input.type = 'password';        // Hide password
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash'); // Eye closed icon
        }
    }
</script>
</body>
</html>