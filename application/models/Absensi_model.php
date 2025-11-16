<?php
class Absensi_model extends CI_Model {

    public function get_pengaturan() {
        $settings = $this->db->get('pengaturan_absensi')->result_array();
        $result = [];
        foreach ($settings as $s) {
            $result[$s['nama']] = $s['nilai'];
        }
        return $result;
    }

    // Hitung data REAL-TIME dari tabel asli
    public function hitung_data_siswa($id_pertemuan, $siswa_id)
    {
        // Ambil batas waktu
        $batas = $this->get_info_batas_waktu($id_pertemuan);
        $batas_waktu = $batas ? $batas['batas_waktu'] : null;

        /* ---------------------------------------
        1. Hitung total komentar 
        --------------------------------------- */
        $this->db->where('id_pertemuan', $id_pertemuan)
                ->where('user_type', 'siswa')
                ->where('user_id', $siswa_id);

        if ($batas_waktu) {
            $this->db->where('DATE(created_at) <=', $batas_waktu);
        }

        $total_komentar = $this->db->count_all_results('forum_diskusi');

        /* ---------------------------------------
        2. Hitung hari berbeda komentar
        --------------------------------------- */
        $this->db->select('COUNT(DISTINCT DATE(created_at)) as total')
                ->where('id_pertemuan', $id_pertemuan)
                ->where('user_type', 'siswa')
                ->where('user_id', $siswa_id);

        if ($batas_waktu) {
            $this->db->where('DATE(created_at) <=', $batas_waktu);
        }

        $hari_berbeda = $this->db->get('forum_diskusi')->row()->total ?? 0;

        /* ---------------------------------------
        3. Cek quiz selesai
        --------------------------------------- */
        $this->db->select('qs.id')
                ->from('quiz_siswa qs')
                ->join('quiz q', 'q.id = qs.quiz_id')
                ->where('q.id_pertemuan', $id_pertemuan)
                ->where('qs.siswa_id', $siswa_id)
                ->where('qs.status', 'completed');

        // filter waktu berdasarkan end_time
        if ($batas_waktu) {
            $this->db->where('DATE(qs.end_time) <=', $batas_waktu);
        }

        $quiz_completed = $this->db->count_all_results(); // <= EKSEKUSI

        return [
            'total_komentar'  => $total_komentar,
            'hari_berbeda'    => $hari_berbeda,
            'quiz_completed'  => $quiz_completed
        ];
    }


    // Tentukan status berdasarkan data real-time
    public function tentukan_status($data_siswa, $pengaturan) {
        if ($pengaturan['require_quiz'] == '1') {
            // Harus selesaikan quiz DAN memenuhi syarat komentar
            if ($data_siswa['quiz_completed'] && 
               ($data_siswa['total_komentar'] >= $pengaturan['min_komentar'] || 
                $data_siswa['hari_berbeda'] >= $pengaturan['min_hari'])) {
                return 'hadir';
            }
        } else {
            // Cukup memenuhi syarat komentar
            if ($data_siswa['total_komentar'] >= $pengaturan['min_komentar'] || 
                $data_siswa['hari_berbeda'] >= $pengaturan['min_hari']) {
                return 'hadir';
            }
        }
        
        return 'tidak_hadir';
    }


public function get_siswa_by_pertemuan($id_pertemuan) {
    // 1. Ambil data pertemuan untuk tahu kelasnya
    $pertemuan = $this->db->where('id', $id_pertemuan)->get('pertemuan')->row();
    
    if (!$pertemuan) {
        return [];
    }
    
    // 2. Cek struktur siswa - apakah ada kolom kelas?
    $siswa_fields = $this->db->list_fields('siswa');
    $has_kelas_field = in_array('id_kelas', $siswa_fields) || in_array('kelas', $siswa_fields);
    
    // 3. Jika siswa punya kolom kelas, filter by kelas pertemuan
    if ($has_kelas_field && isset($pertemuan->id_kelas)) {
        // Coba dengan id_kelas dulu
        if (in_array('id_kelas', $siswa_fields)) {
            return $this->db->select('nis, nama, id_kelas')
                           ->from('siswa')
                           ->where('id_kelas', $pertemuan->id_kelas)
                           ->get()
                           ->result_array();
        }
        // Coba dengan kelas (string)
        elseif (in_array('kelas', $siswa_fields)) {
            // Ambil nama kelas dari tabel kelas
            $kelas = $this->db->select('nama_kelas')
                             ->where('id', $pertemuan->id_kelas)
                             ->get('kelas')
                             ->row();
            
            if ($kelas) {
                return $this->db->select('nis, nama, kelas')
                               ->from('siswa')
                               ->where('kelas', $kelas->nama_kelas)
                               ->get()
                               ->result_array();
            }
        }
    }
    

    return $this->db->select('nis, nama')->get('siswa')->result_array();
}

public function hitung_absensi_pertemuan($id_pertemuan) {
    // Validasi pertemuan exists
    $pertemuan = $this->db->where('id', $id_pertemuan)->get('pertemuan')->row();
    if (!$pertemuan) {
        return false;
    }
    
    $pengaturan = $this->get_pengaturan();
    
    // AMBIL HANYA SISWA YANG TERKAIT DENGAN PERTEMUAN INI
    $siswa_list = $this->get_siswa_by_pertemuan($id_pertemuan);
    
    if (empty($siswa_list)) {
        return false; // Tidak ada siswa di kelas ini
    }
    
    foreach ($siswa_list as $siswa) {
        $nis = $siswa['nis'];
        
        // Hitung data REAL-TIME
        $data_siswa = $this->hitung_data_siswa($id_pertemuan, $nis);
        
        // Tentukan status
        $status = $this->tentukan_status($data_siswa, $pengaturan);
        
        // Simpan HANYA status akhir
        $absensi_data = [
            'id_pertemuan' => $id_pertemuan,
            'siswa_id' => $nis,
            'status' => $status
        ];
        
        // Update atau insert
        $existing = $this->db
            ->where('id_pertemuan', $id_pertemuan)
            ->where('siswa_id', $nis)
            ->get('absensi_pertemuan')
            ->row();
        
        if ($existing) {
            $this->db->where('id', $existing->id)->update('absensi_pertemuan', $absensi_data);
        } else {
            $this->db->insert('absensi_pertemuan', $absensi_data);
        }
    }
    
    return true;
}



// CEK BATAS WAKTU - PAKAI PENGATURAN YANG SUDAH ADA
public function get_info_batas_waktu($id_pertemuan) {
    // Ambil tanggal pertemuan
    $pertemuan = $this->db->select('tanggal')
                        ->where('id', $id_pertemuan)
                        ->get('pertemuan')
                        ->row();
    
    if (!$pertemuan) return null;
    
    // Ambil batas waktu dari pengaturan (jika ada), default 7 hari
    $pengaturan = $this->get_pengaturan();
    $batas_hari = isset($pengaturan['batas_waktu_hari']) ? (int)$pengaturan['batas_waktu_hari'] : 7;
    
    $batas_waktu = date('Y-m-d', strtotime($pertemuan->tanggal . " +{$batas_hari} days"));
    
    return [
        'tanggal_pertemuan' => $pertemuan->tanggal,
        'batas_waktu' => $batas_waktu,
        'batas_hari' => $batas_hari
    ];
}
public function get_statistik($id_pertemuan) {
    // Hitung berdasarkan siswa yang terkait dengan pertemuan
    $siswa_pertemuan = $this->get_siswa_by_pertemuan($id_pertemuan);
    $total_siswa = count($siswa_pertemuan);
    
    if ($total_siswa == 0) {
        return [
            'total' => 0,
            'hadir' => 0,
            'tidak_hadir' => 0,
            'persentase' => 0
        ];
    }
    
    // Hitung yang hadir dari absensi_pertemuan
    $hadir = 0;
    foreach ($siswa_pertemuan as $siswa) {
        $absensi = $this->db
            ->where('id_pertemuan', $id_pertemuan)
            ->where('siswa_id', $siswa['nis'])
            ->where('status', 'hadir')
            ->get('absensi_pertemuan')
            ->row();
        
        if ($absensi) {
            $hadir++;
        }
    }
    
    return [
        'total' => $total_siswa,
        'hadir' => $hadir,
        'tidak_hadir' => $total_siswa - $hadir,
        'persentase' => $total_siswa > 0 ? round(($hadir / $total_siswa) * 100, 2) : 0
    ];
}

    public function generate_version_signature($id_pertemuan) {
        // Ambil data pertemuan
        $pertemuan = $this->db->where('id', $id_pertemuan)->get('pertemuan')->row();
        if (!$pertemuan) return null;
        
        // Ambil pengaturan
        $pengaturan = $this->get_pengaturan();
        
        // Data yang mempengaruhi perhitungan absensi
        $version_data = [
            'tanggal_pertemuan' => $pertemuan->tanggal,
            'min_komentar' => $pengaturan['min_komentar'],
            'min_hari' => $pengaturan['min_hari'],
            'require_quiz' => $pengaturan['require_quiz'],
            'batas_waktu_hari' => $pengaturan['batas_waktu_hari']
        ];
        
        // Generate unique hash
        return md5(serialize($version_data));
    }

    // CEK APAKAH DATA ABSENSI MASIH VALID
    public function is_absensi_valid($id_pertemuan) {
        // Ambil version terbaru
        $current_version = $this->generate_version_signature($id_pertemuan);
        if (!$current_version) return false;
        
        // Cek version yang tersimpan
        $saved_version = $this->db
            ->select('calculation_version')
            ->where('id_pertemuan', $id_pertemuan)
            ->limit(1)
            ->get('absensi_pertemuan')
            ->row();
            
        return ($saved_version && $saved_version->calculation_version === $current_version);
    }

    // ==================== LAZY CALCULATION CORE ====================

    // HITUNG & SIMPAN ABSENSI (DENGAN VERSION)
    public function hitung_dan_simpan_absensi($id_pertemuan) {
        // Validasi pertemuan
        $pertemuan = $this->db->where('id', $id_pertemuan)->get('pertemuan')->row();
        if (!$pertemuan) return false;
        
        $pengaturan = $this->get_pengaturan();
        $siswa_list = $this->get_siswa_by_pertemuan($id_pertemuan);
        $version = $this->generate_version_signature($id_pertemuan);
        
        // Hapus data absensi lama untuk pertemuan ini
        $this->db->where('id_pertemuan', $id_pertemuan)->delete('absensi_pertemuan');
        
        foreach ($siswa_list as $siswa) {
            $nis = $siswa['nis'];
            
            // Validasi siswa
            $siswa_check = $this->db->where('nis', $nis)->get('siswa')->row();
            if (!$siswa_check) continue;
            
            // Hitung data
            $data_siswa = $this->hitung_data_siswa($id_pertemuan, $nis);
            $status = $this->tentukan_status($data_siswa, $pengaturan);
            
            // Simpan dengan version
            $absensi_data = [
                'id_pertemuan' => $id_pertemuan,
                'siswa_id' => $nis,
                'status' => $status,
                'calculation_version' => $version,
                'last_calculated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('absensi_pertemuan', $absensi_data);
        }
        
        return true;
    }

    // AMBIL DATA ABSENSI DENGAN VALIDATION
    public function get_absensi_pertemuan($id_pertemuan) {
        // Cek apakah data masih valid
        $is_valid = $this->is_absensi_valid($id_pertemuan);
        $data_absensi = [];
        
        if ($is_valid) {
            // Data valid, ambil dari database
            $data_absensi = $this->db
                ->select('a.*, s.nama, s.nis')
                ->from('absensi_pertemuan a')
                ->join('siswa s', 's.nis = a.siswa_id')
                ->where('a.id_pertemuan', $id_pertemuan)
                ->order_by('s.nama', 'ASC')
                ->get()
                ->result_array();
        } else {
            // Data tidak valid, hitung real-time (temporary)
            $data_absensi = $this->get_absensi_real_time($id_pertemuan);
        }
        
        // Tambahkan detail untuk display
        foreach ($data_absensi as &$item) {
            $detail = $this->hitung_data_siswa($id_pertemuan, $item['siswa_id']);
            $item['total_komentar'] = $detail['total_komentar'];
            $item['hari_berbeda'] = $detail['hari_berbeda'];
            $item['quiz_completed'] = $detail['quiz_completed'];
            $item['is_valid'] = $is_valid; // Flag untuk UI
        }
        
        return $data_absensi;
    }

    // GET DATA REAL-TIME (untuk temporary display)
    public function get_absensi_real_time($id_pertemuan) {
        $siswa_list = $this->get_siswa_by_pertemuan($id_pertemuan);
        $pengaturan = $this->get_pengaturan();
        $result = [];
        
        foreach ($siswa_list as $siswa) {
            $data_siswa = $this->hitung_data_siswa($id_pertemuan, $siswa['nis']);
            $status = $this->tentukan_status($data_siswa, $pengaturan);
            
            $result[] = [
                'id_pertemuan' => $id_pertemuan,
                'siswa_id' => $siswa['nis'],
                'status' => $status,
                'nama' => $siswa['nama'],
                'nis' => $siswa['nis'],
                'calculation_version' => null, // Tidak ada version
                'last_calculated_at' => null
            ];
        }
        
        return $result;
    }

    // GET INFO VALIDITY UNTUK DISPLAY
    public function get_validity_info($id_pertemuan) {
        $is_valid = $this->is_absensi_valid($id_pertemuan);
        $last_calculation = $this->db
            ->select('last_calculated_at')
            ->where('id_pertemuan', $id_pertemuan)
            ->limit(1)
            ->get('absensi_pertemuan')
            ->row();
            
        return [
            'is_valid' => $is_valid,
            'last_calculated' => $last_calculation ? $last_calculation->last_calculated_at : null,
            'current_version' => $this->generate_version_signature($id_pertemuan)
        ];
    }
public function get_absensi_per_pertemuan($id_pertemuan)
{
    // Ambil semua siswa yang terdaftar di absensi_pertemuan
    $this->db->select('a.siswa_id, a.status, s.nama');
    $this->db->from('absensi_pertemuan a');
    $this->db->join('siswa s', 's.nis = a.siswa_id');
    $this->db->where('a.id_pertemuan', $id_pertemuan);
    $list = $this->db->get()->result_array();

    $hasil = [];

    foreach ($list as $row) {
        // gunakan hitung_data_siswa PUNYA KAMU
        $hitung = $this->hitung_data_siswa($id_pertemuan, $row['siswa_id']);

        $hasil[] = [
            'nis'            => $row['siswa_id'],
            'nama'           => $row['nama'],
            'status'         => $row['status'],
            'total_komentar' => $hitung['total_komentar'],
            'hari_berbeda'   => $hitung['hari_berbeda'],
            'quiz_completed' => $hitung['quiz_completed']
        ];
    }

    return $hasil;
}


    public function get_detail_pertemuan($id){
        return $this->db->get_where('pertemuan', ['id' => $id])->row_array();
    }
    public function get_info_pertemuan($id_pertemuan)
{
    $this->db->select('mp.nama_mapel, k.nama_kelas');
    $this->db->from('pertemuan p');
    $this->db->join('kelas k', 'k.id = p.id_kelas');
    $this->db->join('materi m', 'm.id = p.id_materi');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->where('p.id', $id_pertemuan);
    return $this->db->get()->row_array();
}


}
