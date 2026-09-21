<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - 403</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        
        .error-container {
            text-align: center;
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            max-width: 450px;
            width: 90%;
        }

        /* Area logo untuk aset PNG transparan */
        .brand-logo {
            max-width: 180px;
            margin-bottom: 25px;
            height: auto;
        }

        /* Efek latar belakang teks pada header */
        .error-header {
            font-size: 96px;
            font-weight: 900;
            margin: 0;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            line-height: 1;
        }

        .error-title {
            font-size: 22px;
            font-weight: 700;
            margin: 15px 0 10px;
            color: #2c3e50;
        }

        .error-message {
            font-size: 15px;
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .btn-back {
            display: inline-block;
            padding: 12px 28px;
            background-color: #2980b9;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(41, 128, 185, 0.2);
        }

        .btn-back:hover {
            background-color: #3498db;
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <!-- Pastikan file logo Anda sudah dikonversi menjadi PNG transparan agar latar belakangnya tidak bertabrakan dengan card putih ini -->
        <!-- <img src="{{ asset('images/logo.png') }}" alt="Logo Merek" class="brand-logo"> -->
        
        <h1 class="error-header">403</h1>
        <div class="error-title">Akses Terbatas</div>
        <p class="error-message">
            Maaf, akun kasir Anda tidak memiliki izin untuk masuk ke halaman administrator ini. Silakan hubungi admin jika ini adalah sebuah kesalahan.
        </p>
        
        <!-- Mengarahkan user kembali ke rute dashboard -->
        <a href="{{ route('dashboard') }}" class="btn-back">Kembali ke Dashboard</a>
    </div>
</body>
</html>