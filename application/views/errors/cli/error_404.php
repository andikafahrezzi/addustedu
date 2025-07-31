<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>
	    <link rel="icon" href="<?= base_url('assets/') ?>img/logoh.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #00c9ff, #92fe9d);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .container {
            max-width: 700px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            color: transparent;
            background: linear-gradient(45deg, #ffffff, #ffd700);
            -webkit-background-clip: text;
            background-clip: text;
            animation: pulse 2s infinite alternate;
        }

        .error-title {
            font-size: 2.5rem;
            margin-top: -20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        }

        .error-message {
            margin: 20px 0;
            font-size: 1.2rem;
            line-height: 1.6;
            opacity: 0.95;
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: #fff;
            color: #00c9ff;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            margin-top: 25px;
        }

        .btn:hover {
            background: #00c9ff;
            color: #fff;
            transform: scale(1.05);
        }

        .floating-books .book {
            position: absolute;
            width: 30px;
            height: 40px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 4px;
            opacity: 0.6;
            animation: float 6s ease-in-out infinite;
        }

        .floating-books .book:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .floating-books .book:nth-child(2) { top: 30%; left: 25%; animation-delay: 1s; }
        .floating-books .book:nth-child(3) { top: 60%; left: 15%; animation-delay: 2s; }
        .floating-books .book:nth-child(4) { top: 45%; left: 80%; animation-delay: 3s; }
        .floating-books .book:nth-child(5) { top: 20%; left: 60%; animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse {
            from { transform: scale(1); }
            to { transform: scale(1.05); }
        }

        @media (max-width: 600px) {
            .error-code { font-size: 5rem; }
            .error-title { font-size: 1.8rem; }
            .error-message { font-size: 1rem; }
        }
    </style>
</head>
<body>

    <div class="floating-books">
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
    </div>

    <div class="container">
        <div class="error-code">404</div>
        <div class="error-title">Halaman Tidak Ditemukan</div>
        <div class="error-message">
            Ups! Sepertinya halaman yang kamu cari tidak tersedia.😗<br>
            Coba periksa kembali URL atau kembali ke beranda.
        </div>
        <a href="<?= base_url() ?>" class="btn">🏠 Kembali ke Beranda</a>
    </div>

</body>
</html>
