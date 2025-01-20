<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar bg-dark vh-100">
                <div class="move-up">
                    <img 
                        alt="Logo" 
                        class="move-up"
                        src="{{ asset('gambar/logo.png') }}"
                    />
                </div>                      
                <a href="{{ url('/ownerdashboard') }}" class="btn btn-primary mb-2 d-block">DASHBOARD</a>
                <a href="{{ url('/ownerkaryawan') }}" class="btn btn-primary mb-2 d-block">PEGAWAI</a>
                <a href="{{ url('/ownerasuransi') }}" class="btn btn-primary mb-2 d-block">ASURANSI</a>

            </div>

            <!-- Content Area -->
            <div class="col-md-10 offset-md-2">
                <!-- Header -->
                <div class="header d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                    <h1><b>Admin</b></h1>
                    <div class="d-flex align-items-center">
                        @if(Auth::check())
                        <span class="user-name">{{ strtoupper(Auth::user()->name) }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="ms-3">
                                @csrf
                                <button type="submit" class="btn btn-link p-0" style="border: none; background: none;">
                                    <i class="fas fa-sign-out-alt" style="font-size: 24px; color: black;"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-link">Logout</a>
                        @endif
                    </div>
                </div>

                <!-- Dynamic Content -->
                <div class="content p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
