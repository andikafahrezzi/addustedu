<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Akses Ditolak</title>
    <link rel="icon" href="<?= base_url('assets/') ?>img/logoh.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #00c9ff, #92fe9d);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float-around 20s linear infinite;
        }

        .floating-element:nth-child(1) { 
            left: 10%; top: 20%; 
            animation-delay: 0s; 
            font-size: 2rem;
        }
        .floating-element:nth-child(2) { 
            right: 10%; top: 10%; 
            animation-delay: 5s; 
            font-size: 1.5rem;
        }
        .floating-element:nth-child(3) { 
            left: 20%; bottom: 20%; 
            animation-delay: 10s; 
            font-size: 2.5rem;
        }
        .floating-element:nth-child(4) { 
            right: 30%; bottom: 30%; 
            animation-delay: 15s; 
            font-size: 1.8rem;
        }

        @keyframes float-around {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -50px) rotate(90deg); }
            50% { transform: translate(-20px, -100px) rotate(180deg); }
            75% { transform: translate(-50px, -30px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particle-float 15s linear infinite;
        }

        @keyframes particle-float {
            0% {
                transform: translateY(100vh) translateX(0) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(100px) scale(1);
                opacity: 0;
            }
        }

        .container {
            max-width: 900px;
            width: 90%;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            position: relative;
            z-index: 1;
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-code {
            font-size: clamp(4rem, 15vw, 8rem);
            font-weight: 900;
            background: linear-gradient(45deg, #ffffff, #ffd700, #ff6b6b);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
            animation: pulse-glow 3s ease-in-out infinite alternate;
            position: relative;
            margin-bottom: 1rem;
        }

        .error-code::before {
            content: '🔒';
            position: absolute;
            top: -0.5rem;
            right: -1rem;
            font-size: clamp(2rem, 6vw, 3rem);
            animation: lock-bounce 2s ease-in-out infinite;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }

        @keyframes pulse-glow {
            from { 
                transform: scale(1);
                filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.4));
            }
            to { 
                transform: scale(1.02);
                filter: drop-shadow(0 0 40px rgba(255, 255, 255, 0.6));
            }
        }

        @keyframes lock-bounce {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(-5deg); }
            75% { transform: translateY(-5px) rotate(5deg); }
        }

        .error-title {
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #fff, #ffd700);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .error-message {
            font-size: clamp(1rem, 3vw, 1.3rem);
            line-height: 1.7;
            margin-bottom: 2rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid #ffd700;
            backdrop-filter: blur(10px);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.8s;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }

        .info-card:hover::before {
            left: 100%;
        }

        .info-card h3 {
            font-size: clamp(1.1rem, 3vw, 1.4rem);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #ffd700;
        }

        .info-card ul {
            list-style: none;
            text-align: left;
        }

        .info-card li {
            padding: 0.3rem 0;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            position: relative;
            padding-left: 1.5rem;
        }

        .info-card li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: #ffd700;
            font-weight: bold;
        }

        .buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            min-width: 160px;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(45deg, #fff, #f0f0f0);
            color: #00c9ff;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #00c9ff, #0099cc);
            color: #fff;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .btn:hover::before {
            left: 100%;
        }

        .mascot {
            position: absolute;
            bottom: -2rem;
            right: -2rem;
            font-size: 4rem;
            opacity: 0.2;
            animation: mascot-float 4s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes mascot-float {
            0%, 100% { transform: rotate(0deg) translateY(0); }
            50% { transform: rotate(10deg) translateY(-20px); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 1.5rem;
                margin: 1rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .buttons-container {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }

            .mascot {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 1rem;
            }

            .error-message {
                padding: 1rem;
            }

            .info-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="animated-bg">
        <div class="floating-element">🎓</div>
        <div class="floating-element">📚</div>
        <div class="floating-element">🏫</div>
        <div class="floating-element">👥</div>
        
        <div class="particles" id="particles"></div>
    </div>

    <div class="container">
        <div class="error-code">403</div>
        <h1 class="error-title">Akses Ditolak</h1>
        
        <div class="error-message">
            <strong>Pertemuan tidak ditemukan atau bukan untuk kelas Anda.</strong><br>
            Sepertinya Anda mencoba mengakses pertemuan yang tidak tersedia atau tidak memiliki akses ke kelas ini. 🔐
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>🔍 Kemungkinan Penyebab</h3>
                <ul>
                    <li>Pertemuan belum dijadwalkan atau sudah berakhir</li>
                    <li>Anda belum terdaftar di kelas ini</li>
                    <li>Akses pertemuan dibatasi waktu tertentu</li>
                    <li>Link pertemuan tidak valid atau expired</li>
                </ul>
            </div>
            
            <div class="info-card">
                <h3>💡 Solusi yang Bisa Dicoba</h3>
                <ul>
                    <li>Periksa jadwal kelas di dashboard Anda</li>
                    <li>Pastikan sudah terdaftar di kelas yang tepat</li>
                    <li>Hubungi instruktur jika masih bermasalah</li>
                    <li>Cek kembali link atau URL yang digunakan</li>
                </ul>
            </div>
        </div>

        <div class="buttons-container">
            <a href="<?= base_url() ?>" class="btn btn-primary">
                🏠 Kembali ke Beranda
            </a>
        </div>

        <div class="mascot">🎯</div>
    </div>

    <script>
        // Create animated particles
        function createParticles() {
            const particlesContainer = document.querySelector('.particles');
            const particleCount = window.innerWidth < 768 ? 15 : 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (Math.random() * 5 + 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Add click ripple effect
        function addRippleEffect(e, element) {
            const ripple = document.createElement('span');
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
                z-index: 1;
            `;
            
            element.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        }

        // Initialize effects
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Add ripple effect to buttons
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    addRippleEffect(e, this);
                });
            });

            // Animate info cards on scroll/load
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.info-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = `all 0.6s ease ${index * 0.2}s`;
                observer.observe(card);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
            .btn {
                position: relative;
                overflow: hidden;
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>