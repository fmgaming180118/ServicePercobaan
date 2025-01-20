<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/loginadmin.css') }}">
    <title>Login Admin - Altrindo Motor</title>
</head>

<body>
    <!-- Logo -->
    <a class="Logo">
        <img src="{{ asset('gambar/logo.png') }}" alt="Logo" class="logo">
    </a>

    <!-- Wrapper Utama -->
    <div class="main-wrapper">
        <!-- Flash Message Status -->
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <!-- Error Handling -->
        @if (session('msg'))
      <div class="alert alert-danger">
        {{ session('msg') }}
      </div>
      @endif

        <!-- Form Login -->
        <div class="login-form">
            <h1 class="title">Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Input Email -->
                <div class="input-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control" required autofocus>
                </div>
                <!-- Input Password -->
                <div class="input-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required>
                </div>
                <!-- Tombol Login -->
                <button type="submit" class="login-btn btn btn-primary w-100">Login</button>
            </form>
        </div>

        <!-- Hero Image -->
        <div class="hero mt-4">
            <img src="{{ asset('gambar/car1.png') }}" alt="Car" class="car-image">
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
