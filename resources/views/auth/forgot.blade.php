<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>HMS Portal — Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('Fas/forgot.css') }}">
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="icon-circle">
                <i class="bi bi-shield-lock-fill" style="font-size:32px;"></i>
            </div>
            <h3 class="fw-bold mb-1">HMS Portal</h3>
            <p class="mb-0" style="opacity:0.8;">Reset Your Password</p>
        </div>
        <div class="auth-body">
            <h5 class="fw-bold text-center mb-2 text-dark">
                <i class="bi bi-key-fill me-2 text-primary"></i>Forgot Password?
            </h5>
            <p class="text-center text-muted mb-4" style="font-size:14px;">
                Enter your email and we will send you a reset link.
            </p>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form action="{{ route('forgot_post') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope-fill text-primary"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your registered email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="bi bi-send-fill me-2"></i>Send Reset Link
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
</body>
</html>