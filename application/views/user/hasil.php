<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil <?= $ujian->nama_ujian ?></title>
    <link rel="icon" href="<?= base_url('assets/') ?>img/logoh.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --accent-color: #f39c12;
            --text-color: #444;
            --light-gray: #f5f7fa;
            --border-radius: 8px;
            --shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        
        body {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            margin-top: 300px;
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .container {
            max-width: 900px;
            margin: 80px auto;
            padding: 30px;
        }
        
        .result-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .result-header {
            background: var(--primary-color);
            color: white;
            padding: 25px 30px;
            position: relative;
        }
        
        .result-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .result-header .badge {
            position: absolute;
            right: 30px;
            top: 20px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        
        .result-body {
            padding: 30px;
        }
        
        .result-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .stat-box {
            flex: 1;
            min-width: 150px;
            background: var(--light-gray);
            padding: 15px 20px;
            border-radius: var(--border-radius);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-box:hover {
            transform: translateY(-5px);
        }
        
        .stat-box i {
            display: block;
            font-size: 24px;
            margin-bottom: 8px;
            color: var(--primary-color);
        }
        
        .stat-box .stat-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-box .stat-label {
            font-size: 14px;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .score-highlight {
            color: var(--secondary-color);
        }
        
        .result-detail {
            background: var(--light-gray);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
        }
        
        .result-detail table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .result-detail th, 
        .result-detail td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .result-detail th {
            font-weight: 600;
            color: #555;
        }
        
        .result-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background: var(--primary-color);
            color: white;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary {
            background: #f0f0f0;
            color: var(--text-color);
        }
        
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 0;
                padding: 20px;
                max-width: 100%;
            }
            
            .result-stats {
                flex-direction: column;
            }
            
            .result-header {
                padding: 20px;
            }
            
            .result-header .badge {
                position: static;
                display: inline-block;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="result-card">
            <div class="result-header">
                <h2>Hasil Ujian: <?= $ujian->nama_ujian ?></h2>
                <strong>Bobot Penilaian:</strong><br>
                    • PG: <strong><?= $ujian->bobot_pg ?>%</strong><br>
                    • Essay: <strong><?= $ujian->bobot_essay ?>%</strong>
                <div class="badge">
                    <i class="fas fa-calendar-alt"></i> 
                    <?= date('d M Y H:i', strtotime($hasil->tanggal_submit)) ?>
                </div>
            </div>
            
            <div class="result-body">
                <?php if (!empty($hasil->peringatan_essay)): ?>
                    <div class="alert alert-warning" style="background: #fff3cd; color: #856404; border-radius: var(--border-radius); padding: 15px; margin-bottom: 20px; box-shadow: var(--shadow);">
                        <i class="fas fa-exclamation-triangle"></i> <?= $hasil->peringatan_essay ?>
                    </div>
                <?php endif; ?>

                <div class="result-stats">
                    <div class="stat-box">
                        <i class="fas fa-check-circle"></i>
                        <div class="stat-value"><?= $hasil->total_pg ?></div>
                        <div class="stat-label">PG</div>
                    </div>
                    
                    <div class="stat-box">
                        <i class="fas fa-times-circle"></i>
                        <div class="stat-value"><?= $hasil->total_nilai_essay ?></div>
                        <div class="stat-label">Essay</div>
                    </div>
                    
                    <div class="stat-box">
                        <i class="fas fa-chart-pie"></i>
                        <div class="stat-value score-highlight"><?= number_format($hasil->total_nilai, 2) ?>%</div>
                        <div class="stat-label">Skor</div>
                    </div>
                </div>

                <div class="result-detail">
                    <table>
                        <tr>
                            <th width="40%">Nama Ujian</th>
                            <td><?= $ujian->nama_ujian ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Submit</th>
                            <td><?= date('d M Y H:i', strtotime($hasil->tanggal_submit)) ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Benar PG:</th>
                            <td><?= $hasil->jumlah_benar ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Salah PG:</th>
                            <td><?= $hasil->jumlah_salah ?></td>
                        </tr>
                        <tr>
                            <th>Score</th>
                            <td><strong class="score-highlight"><?= number_format($hasil->score, 2) ?>%</strong></td>
                        </tr>
                    </table>
                </div>
                
                <div class="result-actions">
                    <a href="<?= site_url('ujian/ranking/'.$ujian->id_ujian) ?>" class="btn">
                        <i class="fas fa-trophy"></i> Lihat Ranking
                    </a>
                    <a href="<?= site_url('user') ?>" class="btn btn-secondary">
                        <i class="fas fa-home"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hapus timer setelah ujian selesai
        localStorage.removeItem('waktu_ujian_<?= $id_ujian ?>');
        
        // Animasi sederhana
        document.addEventListener('DOMContentLoaded', function() {
            const statBoxes = document.querySelectorAll('.stat-box');
            statBoxes.forEach((box, index) => {
                setTimeout(() => {
                    box.style.opacity = '1';
                }, 100 * index);
            });
        });
    </script>
    <?php if (!empty($hasil->peringatan_essay)): ?>
<script>
Swal.fire({
    icon: 'info',
    title: 'Nilai Belum Final',
    text: 'Beberapa soal essay Anda belum dinilai. Nilai akhir masih bersifat sementara.',
    confirmButtonText: 'Mengerti',
    confirmButtonColor: '#3498db'
});
</script>
<?php endif; ?>

</body>
</html>