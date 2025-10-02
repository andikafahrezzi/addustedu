<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;"><?= $kuisioner->judul ?></h2>
                <hr>
                <p><?= $kuisioner->deskripsi ?></p>

                <form action="<?= base_url('kuisioner_user/submit/'.$kuisioner->id) ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                           value="<?= $this->security->get_csrf_hash(); ?>" />

                    <?php foreach ($pertanyaan as $p): ?>
                        <div class="form-group">
                            <label><?= $p->pertanyaan ?></label>

                            <?php if ($p->tipe_jawaban == 'skala'): ?>
                                <?php for ($i=$p->skala_min; $i<=$p->skala_max; $i++): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" 
                                               name="pertanyaan_<?= $p->id ?>" 
                                               value="<?= $i ?>" required>
                                        <label class="form-check-label"><?= $i ?></label>
                                    </div>
                                <?php endfor; ?>

                            <?php elseif ($p->tipe_jawaban == 'pilihan'): ?>
                                <?php foreach (json_decode($p->opsi_pilihan) as $opsi): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" 
                                               name="pertanyaan_<?= $p->id ?>" 
                                               value="<?= $opsi ?>" required>
                                        <label class="form-check-label"><?= $opsi ?></label>
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <textarea name="pertanyaan_<?= $p->id ?>" class="form-control" required></textarea>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-success">Kirim Jawaban ⭢</button>
                </form>
            </div>
        </div>
    </section>
</div>

<style>
    /* Container Styling */
    .main-content {
        padding: 2rem 1rem;
        min-height: 100vh;
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        position: relative;
        overflow-x: hidden;
    }

    /* Animated Background Particles */
    .main-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 50% 20%, rgba(255, 215, 0, 0.1) 0%, transparent 50%);
        pointer-events: none;
        animation: pulse-bg 8s ease-in-out infinite;
    }

    @keyframes pulse-bg {
        0%, 100% { opacity: 0.5; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.1); }
    }

    /* Floating Geometric Shapes */
    .main-content::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle, rgba(255, 255, 255, 0.4) 2px, transparent 2px),
            radial-gradient(circle, rgba(255, 215, 0, 0.3) 1px, transparent 1px);
        background-size: 100px 100px, 150px 150px;
        background-position: 0 0, 50px 50px;
        pointer-events: none;
        animation: float-particles 30s linear infinite;
        opacity: 0.5;
    }

    @keyframes float-particles {
        from { transform: translateY(0); }
        to { transform: translateY(-150px); }
    }

    .section {
        max-width: 950px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Card Styling with Advanced Effects */
    .card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 30px;
        box-shadow: 
            0 30px 80px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.5),
            inset 0 0 50px rgba(0, 201, 255, 0.05);
        border: 2px solid transparent;
        backdrop-filter: blur(20px);
        overflow: hidden;
        animation: cardEntrance 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
    }

    @keyframes cardEntrance {
        from {
            opacity: 0;
            transform: translateY(80px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Animated Top Border */
    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, #00c9ff, #92fe9d, #ffd700, #00c9ff);
        background-size: 300% 100%;
        animation: gradient-flow 4s ease infinite;
        box-shadow: 0 2px 15px rgba(0, 201, 255, 0.5);
    }

    @keyframes gradient-flow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Corner Decorations */
    .card::after {
        content: '✨';
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2rem;
        opacity: 0.3;
        animation: sparkle 3s ease-in-out infinite;
    }

    @keyframes sparkle {
        0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.3; }
        50% { transform: scale(1.3) rotate(180deg); opacity: 0.6; }
    }

    .card-body {
        padding: 3rem;
        position: relative;
    }

    /* Title Styling with Gradient Animation */
    .card-title {
        font-size: clamp(2rem, 6vw, 3rem);
        font-weight: 800;
        background: linear-gradient(135deg, #00c9ff, #92fe9d, #ffd700);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
        animation: gradient-text 5s ease infinite;
        filter: drop-shadow(0 2px 10px rgba(0, 201, 255, 0.3));
    }

    @keyframes gradient-text {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .card-title::after {
        content: '📝';
        position: absolute;
        right: -3rem;
        top: -0.5rem;
        font-size: 2.5rem;
        animation: float-emoji 3s ease-in-out infinite;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    @keyframes float-emoji {
        0%, 100% { transform: translateY(0) rotate(-5deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
    }

    hr {
        border: none;
        height: 3px;
        background: linear-gradient(90deg, #00c9ff, #92fe9d, #00c9ff);
        background-size: 200% 100%;
        margin: 2rem 0;
        border-radius: 3px;
        animation: gradient-flow 3s ease infinite;
        box-shadow: 0 2px 10px rgba(0, 201, 255, 0.3);
    }

    .card-body > p {
        color: #444;
        font-size: 1.15rem;
        line-height: 1.8;
        margin-bottom: 2.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.08), rgba(146, 254, 157, 0.08));
        border-radius: 15px;
        border-left: 5px solid #00c9ff;
        box-shadow: 0 4px 15px rgba(0, 201, 255, 0.1);
        position: relative;
        overflow: hidden;
    }

    .card-body > p::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Form Styling */
    form {
        margin-top: 2.5rem;
    }

    .form-group {
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.06), rgba(146, 254, 157, 0.06));
        border-radius: 20px;
        border: 2px solid rgba(0, 201, 255, 0.2);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        box-shadow: 0 5px 20px rgba(0, 201, 255, 0.1);
    }

    .form-group:hover {
        border-color: rgba(0, 201, 255, 0.5);
        box-shadow: 0 10px 35px rgba(0, 201, 255, 0.2);
        transform: translateY(-3px);
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.1), rgba(146, 254, 157, 0.1));
    }

    .form-group::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #00c9ff, #92fe9d);
        border-radius: 5px 0 0 5px;
        box-shadow: 0 0 15px rgba(0, 201, 255, 0.5);
    }

    .form-group::after {
        content: '';
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        border-radius: 50%;
        opacity: 0.1;
        animation: pulse-circle 2s ease-in-out infinite;
    }

    @keyframes pulse-circle {
        0%, 100% { transform: scale(1); opacity: 0.1; }
        50% { transform: scale(1.5); opacity: 0.2; }
    }

    .form-group label:first-child {
        display: block;
        font-size: 1.2rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 1.5rem;
        padding-left: 0.5rem;
        position: relative;
    }

    .form-group label:first-child::before {
        content: '❯';
        position: absolute;
        left: -1rem;
        color: #00c9ff;
        animation: arrow-bounce 1.5s ease-in-out infinite;
    }

    @keyframes arrow-bounce {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(5px); }
    }

    /* Enhanced Radio Button Card Styling - CLICKABLE */
    .form-check {
        margin-bottom: 1rem;
        padding: 0;
        background: white;
        border-radius: 15px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        border: 2px solid #e8e8e8;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .form-check::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(0, 201, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .form-check:hover::before {
        left: 100%;
    }

    .form-check:hover {
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.08), rgba(146, 254, 157, 0.08));
        border-color: #00c9ff;
        transform: translateX(8px) scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 201, 255, 0.15);
    }

    /* Make label fill entire card and clickable */
    .form-check label {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 1rem 1.2rem;
        margin: 0;
        cursor: pointer;
    }

    .form-check-input {
        width: 1.3rem;
        height: 1.3rem;
        margin-right: 1rem;
        cursor: pointer;
        accent-color: #00c9ff;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .form-check-input:checked {
        transform: scale(1.3);
        filter: drop-shadow(0 0 8px rgba(0, 201, 255, 0.6));
    }

    .form-check:has(.form-check-input:checked) {
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.2), rgba(146, 254, 157, 0.2));
        border-color: #00c9ff;
        box-shadow: 
            0 10px 30px rgba(0, 201, 255, 0.25),
            inset 0 0 20px rgba(0, 201, 255, 0.1);
        transform: scale(1.03);
    }

    .form-check:has(.form-check-input:checked)::after {
        content: '✓';
        position: absolute;
        top: 50%;
        right: 1.5rem;
        transform: translateY(-50%);
        font-size: 1.5rem;
        color: #00c9ff;
        font-weight: bold;
        animation: checkmark-pop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes checkmark-pop {
        0% { transform: translateY(-50%) scale(0); }
        100% { transform: translateY(-50%) scale(1); }
    }

    .form-check-label {
        color: #555;
        transition: all 0.2s ease;
        font-size: 1rem;
        user-select: none;
        flex: 1;
    }

    .form-check:has(.form-check-input:checked) .form-check-label {
        color: #00c9ff;
        font-weight: 700;
        transform: translateX(5px);
    }

    /* Enhanced Inline Radio (Skala) - CLICKABLE */
    .form-check-inline {
        display: inline-flex;
        align-items: center;
        margin-right: 0.8rem;
        margin-bottom: 0.8rem;
        padding: 0;
        background: white;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        border: 2px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }

    .form-check-inline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Make label fill entire inline card and clickable */
    .form-check-inline label {
        display: flex;
        align-items: center;
        padding: 0.9rem 1.5rem;
        margin: 0;
        cursor: pointer;
        position: relative;
        z-index: 1;
    }

    .form-check-inline:hover {
        border-color: #00c9ff;
        transform: translateY(-3px) scale(1.08);
        box-shadow: 0 8px 20px rgba(0, 201, 255, 0.25);
    }

    .form-check-inline:has(.form-check-input:checked) {
        border-color: transparent;
        transform: translateY(-5px) scale(1.15);
        box-shadow: 
            0 10px 30px rgba(0, 201, 255, 0.4),
            0 0 0 3px rgba(0, 201, 255, 0.2);
    }

    .form-check-inline:has(.form-check-input:checked)::before {
        opacity: 1;
    }

    .form-check-inline:has(.form-check-input:checked) .form-check-label {
        color: white;
        font-weight: 700;
    }

    .form-check-inline:has(.form-check-input:checked) .form-check-input {
        filter: brightness(0) invert(1);
    }

    /* Textarea Styling with Advanced Effects */
    .form-control {
        width: 100%;
        padding: 1.2rem;
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        font-size: 1.05rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: white;
        resize: vertical;
        min-height: 140px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        outline: none;
        border-color: #00c9ff;
        box-shadow: 
            0 0 0 5px rgba(0, 201, 255, 0.15),
            0 8px 25px rgba(0, 201, 255, 0.2);
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.02), rgba(146, 254, 157, 0.02));
        transform: scale(1.02);
    }

    .form-control::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* Submit Button with Advanced Effects */
    .btn-success {
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        padding: 1.2rem 3rem;
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        background-size: 200% 200%;
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 
            0 8px 25px rgba(0, 201, 255, 0.4),
            0 0 0 0 rgba(0, 201, 255, 0.5);
        position: relative;
        overflow: hidden;
        margin-top: 2rem;
        animation: button-pulse 2s ease-in-out infinite;
    }

    @keyframes button-pulse {
        0%, 100% {
            box-shadow: 
                0 8px 25px rgba(0, 201, 255, 0.4),
                0 0 0 0 rgba(0, 201, 255, 0.5);
        }
        50% {
            box-shadow: 
                0 8px 25px rgba(0, 201, 255, 0.4),
                0 0 0 10px rgba(0, 201, 255, 0);
        }
    }

    .btn-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.6s;
    }

    .btn-success::after {
        content: '🚀';
        position: absolute;
        right: -50px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
        opacity: 0;
        transition: all 0.4s ease;
    }

    .btn-success:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 
            0 15px 40px rgba(0, 201, 255, 0.5),
            0 0 0 3px rgba(255, 255, 255, 0.3);
        background-position: 100% 50%;
    }

    .btn-success:hover::before {
        left: 100%;
    }

    .btn-success:hover::after {
        right: 1rem;
        opacity: 1;
    }

    .btn-success:active {
        transform: translateY(-2px) scale(1.02);
    }

    /* Progress Bar for Questions */
    .form-group:nth-child(1)::after {
        content: '1️⃣';
    }
    .form-group:nth-child(2)::after {
        content: '2️⃣';
    }
    .form-group:nth-child(3)::after {
        content: '3️⃣';
    }
    .form-group:nth-child(4)::after {
        content: '4️⃣';
    }
    .form-group:nth-child(5)::after {
        content: '5️⃣';
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem 1.5rem;
        }

        .card-title::after {
            position: static;
            margin-left: 0.5rem;
            font-size: 2rem;
        }

        .form-group {
            padding: 1.5rem;
        }

        .form-check-inline {
            display: flex;
            width: 100%;
            margin-right: 0;
            margin-bottom: 0.8rem;
        }

        .btn-success {
            width: 100%;
            justify-content: center;
        }

        .btn-success::after {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .main-content {
            padding: 1rem 0.5rem;
        }

        .card {
            border-radius: 20px;
        }

        .card-body {
            padding: 1.5rem 1rem;
        }

        .form-group {
            padding: 1.2rem;
        }

        .form-check label {
            padding: 0.8rem 1rem;
        }
    }

    /* Custom Scrollbar */
    * {
        scrollbar-width: thin;
        scrollbar-color: #00c9ff #f1f1f1;
    }

    *::-webkit-scrollbar {
        width: 10px;
    }

    *::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    *::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        border-radius: 10px;
    }

    *::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #0099cc, #6fd67c);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make entire form-check card clickable
    document.querySelectorAll('.form-check, .form-check-inline').forEach(card => {
        card.addEventListener('click', function(e) {
            // Only trigger if not clicking the input itself
            if (e.target.tagName !== 'INPUT') {
                const radio = this.querySelector('.form-check-input');
                if (radio) {
                    radio.checked = true;
                    // Trigger change event
                    radio.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
    });

    // Add ripple effect to submit button
    const submitBtn = document.querySelector('.btn-success');
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.6);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.8s ease-out;
                pointer-events: none;
                z-index: 10;
            `;
            
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 800);
        });
    }

    // Animate form groups with stagger effect
    const formGroups = document.querySelectorAll('.form-group');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -80px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideInScale 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards';
            }
        });
    }, observerOptions);

    formGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.animationDelay = `${index * 0.15}s`;
        observer.observe(group);
    });

    // Add dynamic focus effect to textarea
    const textareas = document.querySelectorAll('.form-control');
    textareas.forEach(textarea => {
        textarea.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        });
        
        textarea.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    // Add confetti effect on form submission (visual feedback)
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Create visual feedback
            submitBtn.innerHTML = '✓ Mengirim...';
            submitBtn.style.background = 'linear-gradient(135deg, #92fe9d, #00c9ff)';
        });
    }

    // Add radio selection animation
    document.querySelectorAll('.form-check-input').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const parent = this.closest('.form-check, .form-check-inline');
                parent.style.animation = 'selected-bounce 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
                setTimeout(() => {
                    parent.style.animation = '';
                }, 500);
            }
        });
    });
});

// Add additional CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(2.5);
            opacity: 0;
        }
    }
    
    @keyframes slideInScale {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    @keyframes selected-bounce {
        0% { transform: scale(1); }
        30% { transform: scale(1.08); }
        50% { transform: scale(0.98); }
        100% { transform: scale(1.03); }
    }
`;
document.head.appendChild(style);
</script>