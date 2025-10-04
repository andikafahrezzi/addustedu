<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: black;"><?= $kuisioner->judul ?></h2>
                <hr>
                <p><?= $kuisioner->deskripsi ?></p>
                <div class="alert alert-info mb-4">
                    <strong>Keterangan Skala:</strong><br>
                    1 = Sangat Tidak Setuju (STS) &nbsp;&nbsp;
                    2 = Tidak Setuju (TS) &nbsp;&nbsp;
                    3 = Netral (N) &nbsp;&nbsp;
                    4 = Setuju (S) &nbsp;&nbsp;
                    5 = Sangat Setuju (SS)
                </div>

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

    /* Animated Background Effects */
    .main-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.12) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.12) 0%, transparent 50%),
            radial-gradient(circle at 50% 20%, rgba(255, 215, 0, 0.08) 0%, transparent 50%);
        pointer-events: none;
        animation: pulse-bg 10s ease-in-out infinite;
    }

    @keyframes pulse-bg {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 0.9; }
    }

    .main-content::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle, rgba(255, 255, 255, 0.3) 2px, transparent 2px),
            radial-gradient(circle, rgba(255, 215, 0, 0.25) 1px, transparent 1px);
        background-size: 120px 120px, 180px 180px;
        background-position: 0 0, 60px 60px;
        pointer-events: none;
        animation: float-dots 40s linear infinite;
        opacity: 0.4;
    }

    @keyframes float-dots {
        from { transform: translateY(0); }
        to { transform: translateY(-180px); }
    }

    .section {
        max-width: 950px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Card Styling */
    .card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 30px;
        box-shadow: 
            0 25px 70px rgba(0, 0, 0, 0.2),
            0 0 0 1px rgba(255, 255, 255, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        border: none;
        backdrop-filter: blur(20px);
        overflow: hidden;
        animation: cardEntrance 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
    }

    @keyframes cardEntrance {
        from {
            opacity: 0;
            transform: translateY(60px) scale(0.95);
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
        height: 5px;
        background: linear-gradient(90deg, #00c9ff, #92fe9d, #ffd700, #00c9ff);
        background-size: 300% 100%;
        animation: gradient-flow 5s ease infinite;
        box-shadow: 0 2px 12px rgba(0, 201, 255, 0.4);
    }

    @keyframes gradient-flow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .card::after {
        content: '✨';
        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 2rem;
        opacity: 0.25;
        animation: sparkle 4s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes sparkle {
        0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.25; }
        50% { transform: scale(1.2) rotate(180deg); opacity: 0.5; }
    }

    .card-body {
        padding: 3rem;
        position: relative;
    }

    /* Title Styling */
    .card-title {
        font-size: clamp(1.8rem, 5vw, 2.8rem);
        font-weight: 800;
        background: linear-gradient(135deg, #00c9ff, #92fe9d, #ffd700);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
        animation: gradient-text 6s ease infinite;
        filter: drop-shadow(0 2px 8px rgba(0, 201, 255, 0.25));
    }

    @keyframes gradient-text {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .card-title::after {
        content: '📝';
        position: absolute;
        right: -3rem;
        top: -0.3rem;
        font-size: 2.2rem;
        animation: float-icon 3.5s ease-in-out infinite;
        filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.15));
    }

    @keyframes float-icon {
        0%, 100% { transform: translateY(0) rotate(-3deg); }
        50% { transform: translateY(-12px) rotate(3deg); }
    }

    hr {
        border: none;
        height: 3px;
        background: linear-gradient(90deg, #00c9ff, #92fe9d, #00c9ff);
        background-size: 200% 100%;
        margin: 1.5rem 0 2rem;
        border-radius: 3px;
        animation: gradient-flow 4s ease infinite;
        box-shadow: 0 2px 8px rgba(0, 201, 255, 0.25);
    }

    /* Description Styling */
    .card-body > p {
        color: #444;
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        padding: 1.3rem 1.5rem;
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.06), rgba(146, 254, 157, 0.06));
        border-radius: 12px;
        border-left: 4px solid #00c9ff;
        box-shadow: 0 3px 12px rgba(0, 201, 255, 0.08);
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
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 4s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Alert Info Styling - NEW */
    .alert-info {
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.1), rgba(146, 254, 157, 0.1));
        border: 2px solid rgba(0, 201, 255, 0.3);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 201, 255, 0.12);
    }

    .alert-info::before {
        content: 'ℹ️';
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        font-size: 1.8rem;
        opacity: 0.6;
    }

    .alert-info strong {
        display: block;
        margin-bottom: 0.8rem;
        padding-left: 3rem;
        color: #00c9ff;
        font-size: 1.15rem;
    }

    .alert-info br + text,
    .alert-info strong + text {
        padding-left: 3rem;
        display: block;
        line-height: 2;
        color: #555;
        font-size: 0.95rem;
    }

    /* Form Styling */
    form {
        margin-top: 2rem;
    }

    .form-group {
        margin-bottom: 2rem;
        padding: 1.8rem;
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.04), rgba(146, 254, 157, 0.04));
        border-radius: 18px;
        border: 2px solid rgba(0, 201, 255, 0.15);
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 15px rgba(0, 201, 255, 0.08);
    }

    .form-group:hover {
        border-color: rgba(0, 201, 255, 0.35);
        box-shadow: 0 6px 25px rgba(0, 201, 255, 0.15);
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.08), rgba(146, 254, 157, 0.08));
    }

    .form-group::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #00c9ff, #92fe9d);
        border-radius: 4px 0 0 4px;
    }

    .form-group > label:first-child {
        display: block;
        font-size: 1.15rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 1.2rem;
        padding-left: 0.3rem;
        position: relative;
        line-height: 1.5;
    }

    .form-group > label:first-child::before {
        content: '▸';
        position: absolute;
        left: -1rem;
        color: #00c9ff;
        animation: arrow-pulse 2s ease-in-out infinite;
    }

    @keyframes arrow-pulse {
        0%, 100% { transform: translateX(0); opacity: 0.7; }
        50% { transform: translateX(4px); opacity: 1; }
    }

    /* Radio Button Styling - BOTH CLICKABLE */
    .form-check {
        margin-bottom: 0.9rem;
        background: white;
        border-radius: 12px;
        transition: all 0.25s ease;
        cursor: pointer;
        border: 2px solid #e8e8e8;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
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
        background: linear-gradient(90deg, transparent, rgba(0, 201, 255, 0.08), transparent);
        transition: left 0.5s;
    }

    .form-check:hover::before {
        left: 100%;
    }

    .form-check:hover {
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.06), rgba(146, 254, 157, 0.06));
        border-color: rgba(0, 201, 255, 0.5);
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(0, 201, 255, 0.12);
    }

    .form-check label {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 1rem 1.2rem;
        margin: 0;
        cursor: pointer;
        position: relative;
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin: 0 1rem 0 0;
        cursor: pointer;
        accent-color: #00c9ff;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .form-check-input:checked {
        transform: scale(1.15);
        filter: drop-shadow(0 0 6px rgba(0, 201, 255, 0.5));
    }

    .form-check:has(.form-check-input:checked) {
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.15), rgba(146, 254, 157, 0.15));
        border-color: #00c9ff;
        box-shadow: 
            0 6px 20px rgba(0, 201, 255, 0.2),
            inset 0 0 20px rgba(0, 201, 255, 0.08);
    }

    .form-check:has(.form-check-input:checked)::after {
        content: '✓';
        position: absolute;
        top: 50%;
        right: 1.2rem;
        transform: translateY(-50%);
        font-size: 1.3rem;
        color: #00c9ff;
        font-weight: bold;
        animation: checkmark-appear 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes checkmark-appear {
        0% { transform: translateY(-50%) scale(0) rotate(-180deg); opacity: 0; }
        100% { transform: translateY(-50%) scale(1) rotate(0deg); opacity: 1; }
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
        font-weight: 600;
    }

    /* Inline Radio (Skala) - BOTH CLICKABLE */
    .form-check-inline {
        display: inline-flex;
        align-items: center;
        margin-right: 0.6rem;
        margin-bottom: 0.6rem;
        background: white;
        border-radius: 50px;
        transition: all 0.25s ease;
        cursor: pointer;
        border: 2px solid #e0e0e0;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
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
        transition: opacity 0.25s ease;
    }

    .form-check-inline label {
        display: flex;
        align-items: center;
        padding: 0.85rem 1.4rem;
        margin: 0;
        cursor: pointer;
        position: relative;
        z-index: 1;
        transition: all 0.2s ease;
    }

    .form-check-inline:hover {
        border-color: rgba(0, 201, 255, 0.6);
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 18px rgba(0, 201, 255, 0.18);
    }

    .form-check-inline:has(.form-check-input:checked) {
        border-color: transparent;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 
            0 8px 25px rgba(0, 201, 255, 0.3),
            0 0 0 3px rgba(0, 201, 255, 0.15);
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

    /* Textarea Styling */
    .form-control {
        width: 100%;
        padding: 1.1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1.02rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: all 0.3s ease;
        background: white;
        resize: vertical;
        min-height: 130px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        line-height: 1.6;
    }

    .form-control:focus {
        outline: none;
        border-color: #00c9ff;
        box-shadow: 
            0 0 0 4px rgba(0, 201, 255, 0.12),
            0 6px 20px rgba(0, 201, 255, 0.15);
        background: linear-gradient(135deg, rgba(0, 201, 255, 0.01), rgba(146, 254, 157, 0.01));
    }

    .form-control::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* Submit Button */
    .btn-success {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1.1rem 2.8rem;
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        background-size: 200% 200%;
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1.15rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 
            0 6px 20px rgba(0, 201, 255, 0.35),
            0 0 0 0 rgba(0, 201, 255, 0.4);
        position: relative;
        overflow: hidden;
        margin-top: 1.5rem;
        animation: button-glow 3s ease-in-out infinite;
    }

    @keyframes button-glow {
        0%, 100% {
            box-shadow: 
                0 6px 20px rgba(0, 201, 255, 0.35),
                0 0 0 0 rgba(0, 201, 255, 0.4);
        }
        50% {
            box-shadow: 
                0 6px 20px rgba(0, 201, 255, 0.35),
                0 0 0 8px rgba(0, 201, 255, 0);
        }
    }

    .btn-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .btn-success::after {
        content: '🚀';
        position: absolute;
        right: -40px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.3rem;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 12px 35px rgba(0, 201, 255, 0.45),
            0 0 0 3px rgba(255, 255, 255, 0.25);
        background-position: 100% 50%;
    }

    .btn-success:hover::before {
        left: 100%;
    }

    .btn-success:hover::after {
        right: 0.8rem;
        opacity: 1;
    }

    .btn-success:active {
        transform: translateY(-1px) scale(1);
    }

    .btn-success:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }

/* ========================================
   RESPONSIVE MOBILE STYLES
   Tambahkan ini di bagian bawah CSS Anda
   ======================================== */

/* Tablet View (768px and below) */
@media (max-width: 768px) {
    .card-body {
        padding: 2rem 1.5rem;
    }

    /* Title emoji positioning untuk mobile */
    .card-title::after {
        position: static;
        margin-left: 0.5rem;
        font-size: 2rem;
    }

    /* Alert info styling untuk mobile */
    .alert-info strong {
        padding-left: 0;
    }

    .alert-info::before {
        position: static;
        display: block;
        margin-bottom: 0.5rem;
    }

    /* Form group mobile padding */
    .form-group {
        padding: 1.5rem;
    }

    /* Skala inline radio - 2 kolom di tablet */
    .form-check-inline {
        width: calc(50% - 0.3rem);
        margin-right: 0.6rem;
    }

    .form-check-inline:nth-child(even) {
        margin-right: 0;
    }

    /* Button full width */
    .btn-success {
        width: 100%;
        justify-content: center;
    }

    /* Hide rocket emoji on mobile */
    .btn-success::after {
        display: none;
    }
}

/* Mobile View (480px and below) */
@media (max-width: 480px) {
    /* Main container mobile padding */
    .main-content {
        padding: 1rem 0.5rem;
    }

    /* Card mobile border radius */
    .card {
        border-radius: 20px;
    }

    /* Card body mobile padding */
    .card-body {
        padding: 1.5rem 1rem;
    }

    /* Alert info mobile adjustments */
    .alert-info {
        padding: 1.2rem;
        font-size: 0.9rem;
    }

    /* Form group mobile padding */
    .form-group {
        padding: 1.2rem;
    }

    /* Radio card mobile padding */
    .form-check label {
        padding: 0.85rem 1rem;
    }

    /* Skala inline - 1 kolom penuh di mobile */
    .form-check-inline {
        width: 100%;
        margin-right: 0;
        margin-bottom: 0.8rem;
    }

    /* Title font size adjustment */
    .card-title {
        font-size: clamp(1.5rem, 8vw, 2rem);
    }

    /* Description mobile padding */
    .card-body > p {
        padding: 1rem;
        font-size: 1rem;
    }

    /* Form label mobile size */
    .form-group > label:first-child {
        font-size: 1.05rem;
    }

    /* Textarea mobile height */
    .form-control {
        min-height: 100px;
        font-size: 0.95rem;
        padding: 0.9rem;
    }

    /* Button mobile size */
    .btn-success {
        padding: 1rem 2rem;
        font-size: 1.05rem;
    }
}

/* Extra Small Mobile (360px and below) */
@media (max-width: 360px) {
    .main-content {
        padding: 0.8rem 0.3rem;
    }

    .card-body {
        padding: 1.2rem 0.8rem;
    }

    .form-group {
        padding: 1rem;
    }

    .alert-info {
        padding: 1rem;
        font-size: 0.85rem;
    }

    .form-check label {
        padding: 0.75rem 0.8rem;
        font-size: 0.9rem;
    }

    .form-check-inline label {
        padding: 0.75rem 1.2rem;
    }

    .btn-success {
        padding: 0.9rem 1.5rem;
        font-size: 1rem;
    }
}

/* Landscape Orientation Adjustments */
@media (max-width: 768px) and (orientation: landscape) {
    .card-body {
        padding: 1.5rem;
    }

    .form-check-inline {
        width: calc(33.333% - 0.4rem);
    }

    .form-check-inline:nth-child(3n) {
        margin-right: 0;
    }
}

/* Touch Device Optimization */
@media (hover: none) and (pointer: coarse) {
    /* Larger touch targets for mobile */
    .form-check label {
        min-height: 48px;
        display: flex;
        align-items: center;
    }

    .form-check-inline label {
        min-height: 44px;
    }

    .form-check-input {
        width: 1.4rem;
        height: 1.4rem;
    }

    .btn-success {
        min-height: 50px;
    }

    /* Remove hover effects on touch devices */
    .form-check:hover,
    .form-check-inline:hover,
    .form-group:hover {
        transform: none;
    }
}

/* Accessibility - High Contrast Mode */
@media (prefers-contrast: high) {
    .form-check {
        border-width: 3px;
    }

    .form-check:has(.form-check-input:checked) {
        border-color: #0066cc;
        background: rgba(0, 102, 204, 0.2);
    }
}

/* Accessibility - Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }

    .main-content::before,
    .main-content::after,
    .card::after,
    .card-title::after {
        animation: none !important;
    }
}

/* iOS Safari Specific Fixes */
@supports (-webkit-touch-callout: none) {
    .form-check-input {
        margin-top: 0;
        vertical-align: middle;
    }

    .form-control {
        font-size: 16px; /* Prevents zoom on focus in iOS */
    }
}

/* Android Chrome Specific Fixes */
@supports (-webkit-appearance: none) {
    select.form-control,
    textarea.form-control,
    input.form-control {
        -webkit-appearance: none;
    }
}

/* Safe Area Insets for Notched Devices (iPhone X, etc) */
@supports (padding: max(0px)) {
    .main-content {
        padding-left: max(1rem, env(safe-area-inset-left));
        padding-right: max(1rem, env(safe-area-inset-right));
        padding-bottom: max(1rem, env(safe-area-inset-bottom));
    }

    @media (max-width: 480px) {
        .main-content {
            padding-left: max(0.5rem, env(safe-area-inset-left));
            padding-right: max(0.5rem, env(safe-area-inset-right));
        }
    }
}

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #00c9ff, #92fe9d);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #0099cc, #6fd67c);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // SOLUTION: Make both radio input AND card clickable
    document.querySelectorAll('.form-check, .form-check-inline').forEach(card => {
        // Click on card (but not on input)
        card.addEventListener('click', function(e) {
            // If clicking directly on input, let it handle naturally
            if (e.target.classList.contains('form-check-input')) {
                return;
            }
            
            // Otherwise, trigger the radio
            e.preventDefault();
            const radio = this.querySelector('.form-check-input');
            if (radio && !radio.checked) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });

    // Add ripple effect to submit button
    const submitBtn = document.querySelector('.btn-success');
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            if (this.disabled) return;
            
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
                background: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.7s ease-out;
                pointer-events: none;
                z-index: 10;
            `;
            
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 700);
        });
    }

    // Lazy load form group animations
    const formGroups = document.querySelectorAll('.form-group');
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -30px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                entry.target.style.animation = 'slideIn 0.5s ease-out forwards';
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    formGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.animationDelay = `${index * 0.08}s`;
        observer.observe(group);
    });

    // Form submission handling
    const form = document.querySelector('form');
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '✓ Mengirim Jawaban...';
            submitBtn.style.background = 'linear-gradient(135deg, #92fe9d, #00c9ff)';
        });
    }

    // Save scroll position
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('scrollPos', window.scrollY);
    });

    const savedScroll = sessionStorage.getItem('scrollPos');
    if (savedScroll) {
        setTimeout(() => {
            window.scrollTo(0, parseInt(savedScroll));
            sessionStorage.removeItem('scrollPos');
        }, 100);
    }
});

// Additional animations
const styleSheet = document.createElement('style');
styleSheet.textContent = `
    @keyframes ripple {
        to {
            transform: scale(2.2);
            opacity: 0;
        }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(styleSheet);
</script>