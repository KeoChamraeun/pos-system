<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Login | POS System</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            max-width: 900px;
            width: 100%;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background: white;
            display: flex;
            flex-wrap: nowrap;
        }

        .login-img {
            flex: 1;
            padding: 0;
        }

        .login-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            display: block;
        }

        .form-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .btn-login {
            background-color: #4e73df;
            color: white;
            font-weight: 600;
        }

        .btn-login:hover {
            background-color: #3c5ec5;
        }

        .input-group-text {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="container-fluid login-wrapper">
        <div class="login-box">
            <div class="login-img d-none d-md-block">
                <img src="{{ asset('images/login_img.png') }}" alt="Login Illustration" />
            </div>

            <div class="form-section">
                <h3 class="text-center mb-3">Log In</h3>

                @if(Session::has('account_deactivated'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('account_deactivated') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="Enter email" required />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Password" required />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Login</button>
                    </div>
                </form>

                <div class="text-center mt-2">
                    <small class="text-muted">Developed by
                        <a href="https://t.me/keochamraeun">Keo Chamraeun</a></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
