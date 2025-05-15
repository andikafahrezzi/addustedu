
    <style>
        /* Reset & Base */
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: #333;
            margin-top: 200px;
        }
        
        /* Container */
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 25px 30px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%);
            opacity: 0.3;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 15px;
            margin-bottom: 0;
        }
        
        /* Card */
        .card {
            background-color: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            padding: 0;
            overflow: hidden;
        }
        
        /* Ranking Table */
        .ranking-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .ranking-table th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 18px 25px;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #eef0f7;
        }
        
        .ranking-table td {
            padding: 18px 25px;
            border-bottom: 1px solid #eef0f7;
            font-size: 15px;
            vertical-align: middle;
        }
        
        .ranking-table tr:last-child td {
            border-bottom: none;
        }
        
        .ranking-table tr:hover {
            background-color: #f9fafd;
        }
        
        /* Row Styles */
        .ranking-table tr.first {
            background-color: rgba(255, 215, 0, 0.08);
        }
        
        .ranking-table tr.second {
            background-color: rgba(192, 192, 192, 0.08);
        }
        
        .ranking-table tr.third {
            background-color: rgba(205, 127, 50, 0.08);
        }
        
        /* Rank Number */
        .rank {
            font-weight: 700;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
        }
        
        .rank-1 {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
        }
        
        .rank-2 {
            background: linear-gradient(135deg, #C0C0C0, #A0A0A0);
            box-shadow: 0 3px 10px rgba(192, 192, 192, 0.3);
        }
        
        .rank-3 {
            background: linear-gradient(135deg, #CD7F32, #B06500);
            box-shadow: 0 3px 10px rgba(205, 127, 50, 0.3);
        }
        
        .other-rank {
            background: linear-gradient(135deg, #a3a3a3, #6e6e6e);
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Score */
        .score {
            font-weight: 700;
            color: #28a745;
            padding: 5px 15px;
            border-radius: 20px;
            background-color: rgba(40, 167, 69, 0.1);
            display: inline-block;
        }
        
        /* Student Info */
        .student-info {
            display: flex;
            align-items: center;
        }
        
        .student-avatar {
            width: 35px;
            height: 35px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }
        
        .student-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .student-id {
            font-size: 12px;
            color: #6c757d;
        }
        
        /* Footer */
        .footer {
            margin-top: 20px;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(78, 84, 200, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(78, 84, 200, 0.4);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        /* Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 20px auto;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 22px;
            }
            
            .ranking-table th, 
            .ranking-table td {
                padding: 12px 15px;
                font-size: 14px;
            }
            
            .rank {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }
            
            .student-avatar {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header animate__animated animate__fadeIn">
        <h1><i class="fas fa fa-trophy"></i> Ranking Ujian</h1>
        <p><?= $ujian->nama_ujian ?></p>
    </div>
    
    <div class="card animate__animated animate__fadeIn animate__delay-1s">
        <table class="ranking-table">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Siswa</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach($ranking as $r): 
                    $rankClass = '';
                    if($no == 1) $rankClass = 'first';
                    else if($no == 2) $rankClass = 'second';
                    else if($no == 3) $rankClass = 'third';
                    
                    $rankStyle = '';
                    if($no == 1) $rankStyle = 'rank-1';
                    else if($no == 2) $rankStyle = 'rank-2';
                    else if($no == 3) $rankStyle = 'rank-3';
                    else $rankStyle = 'other-rank';
                    
                    // Generate initials for avatar
                    $nameParts = explode(' ', $r->nama);
                    $initials = '';
                    foreach($nameParts as $part) {
                        $initials .= strtoupper(substr($part, 0, 1));
                        if(strlen($initials) >= 2) break;
                    }
                ?>
                <tr class="<?= $rankClass ?>">
                    <td>
                        <div class="rank <?= $rankStyle ?>"><?= $no++ ?></div>
                    </td>
                    <td>
                        <div class="student-info">
                            <div class="student-avatar"><?= $initials ?></div>
                            <div>
                                <div class="student-name"><?= $r->nama ?></div>
                                <div class="student-id">NIS: <?= $r->nis ?></div>
                            </div>
                        </div>
                    </td>
                    <td><div class="score"><?= number_format($r->total_score, 2) ?>%</div></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="footer animate__animated animate__fadeIn animate__delay-2s">
        <a href="<?= site_url('user') ?>" class="btn">
            <i class="fas fa fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Add animation to rows as they appear in viewport
        let delay = 0.1;
        $('tbody tr').each(function() {
            $(this).css('animation', 'fadeIn 0.5s ease forwards ' + delay + 's');
            $(this).css('opacity', '0');
            delay += 0.1;
        });
        
        // Highlight row on hover
        $('tbody tr').hover(function() {
            $(this).css('transform', 'translateY(-3px)');
            $(this).css('box-shadow', '0 5px 15px rgba(0,0,0,0.05)');
            $(this).css('z-index', '1');
            $(this).css('transition', 'all 0.3s ease');
        }, function() {
            $(this).css('transform', 'translateY(0)');
            $(this).css('box-shadow', 'none');
            $(this).css('z-index', '0');
        });
    });
</script>
