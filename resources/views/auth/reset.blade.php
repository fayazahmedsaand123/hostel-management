<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>HMS Portal — Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/reset.css') }}">
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="icon-circle">
                <i class="bi bi-shield-lock-fill" style="font-size:32px;"></i>
            </div>
            <h3 class="fw-bold mb-1">HMS Portal</h3>
            <p class="mb-0" style="opacity:0.8;">Create New Password</p>
        </div>
        <div class="auth-body">
            <h5 class="fw-bold text-center mb-4 text-dark">
                <i class="bi bi-lock-fill me-2 text-primary"></i>Reset Password
            </h5>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form action="{{ route('reset_post') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label fw-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope-fill text-primary"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Your email" value="{{ $email ?? old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">New Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill text-primary"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="New password (min 6 chars)" required>
                        <span class="input-group-text" onclick="togglePassword('password','eyeNew')"
                            style="cursor:pointer;">
                            <i class="bi bi-eye-slash" id="eyeNew"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Confirm New Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill text-primary"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Repeat new password" required>
                        <span class="input-group-text" onclick="togglePassword('password_confirmation','eyeConfirmNew')"
                            style="cursor:pointer;">
                            <i class="bi bi-eye-slash" id="eyeConfirmNew"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-check-circle-fill me-2"></i>Reset Password
                </button>
            </form>

            <hr class="my-4">
            <p class="text-center mb-0 text-muted">
                Remember your password?
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
        } else {
            input.type = 'password';        // Hide password
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash'); // Eye closed icon
        }
    }
</script>
</body>
</html>