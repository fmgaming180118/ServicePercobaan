<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="logout-container">
        <h1>Anda Telah Logout</h1>
        <p>Terima kasih telah menggunakan layanan kami.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Kembali ke Login</a>
    </div>
</body>
</html>
