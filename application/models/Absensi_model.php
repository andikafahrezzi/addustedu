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
public function get_status_absen_siswa($id_pertemuan, $nis)
{
    // Ambil semua pengaturan absensi
    $pengaturan = $this->get_pengaturan();

    // Hitung performa siswa di pertemuan (komentar, hari unik, quiz)
    $data_siswa = $this->hitung_data_siswa($id_pertemuan, $nis);

    // Tentukan status hadir/tidak hadir
    $status = $this->tentukan_status($data_siswa, $pengaturan);

    return $status; // 'hadir' atau 'tidak_hadir'
}

public function get_absensi_final_admin($id_pertemuan)
{
    return $this->db->select('a.*, s.nama')
                    ->from('absensi_pertemuan a')
                    ->join('siswa s', 's.nis = a.nis')
                    ->where('a.id_pertemuan', $id_pertemuan)
                    ->get()
                    ->result();
}

public function admin_recalculate_absensi($id_pertemuan)
{
    $siswa = $this->get_siswa_pertemuan($id_pertemuan);
    $pengaturan = $this->get_pengaturan();

    foreach ($siswa as $row) {
        $data_siswa = $this->hitung_data_siswa($id_pertemuan, $row->nis);
        $status = $this->tentukan_status($data_siswa, $pengaturan);

        $this->save_absensi_final($id_pertemuan, $row->nis, $status);
    }
}

public function save_absensi_final($id_pertemuan, $nis, $status)
{
    $data = [
        'id_pertemuan' => $id_pertemuan,
        'siswa_id' => $nis,
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $exist = $this->db->where('id_pertemuan', $id_pertemuan)
                      ->where('siswa_id', $nis)
                      ->get('absensi_pertemuan')
                      ->row();

    if ($exist) {
        $this->db->where('id', $exist->id)->update('absensi_pertemuan', $data);
    } else {
        $this->db->insert('absensi_pertemuan', $data);
    }
}

public function admin_update_status($id_absen, $status)
{
    return $this->db->where('id', $id_absen)
                    ->update('absensi_pertemuan', [
                        'status' => $status,
                        'manual_edit' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
}
public function get_detail_admin_pertemuan($id_pertemuan)
{
    return $this->db->select('
            p.*,
            k.nama_kelas,
            m.deskripsi,
            mp.nama_mapel,
            g.nama_guru
        ')
        ->from('pertemuan p')
        ->join('kelas k', 'k.id = p.id_kelas')
        ->join('materi m', 'm.id = p.id_materi')
        ->join('mata_pelajaran mp', 'mp.id = m.id_mapel')
        ->join('guru g', 'g.nip = m.id_guru')
        ->where('p.id', $id_pertemuan)
        ->get()
        ->row();
}
public function get_siswa_pertemuan($id_pertemuan)
{
    $p = $this->db->where('id', $id_pertemuan)->get('pertemuan')->row();

    if (!$p) return [];

    return $this->db->select('nis, nama')
                    ->from('siswa')
                    ->where('id_kelas', $p->id_kelas)
                    ->order_by('nama', 'ASC')
                    ->get()
                    ->result();
}
public function get_absensi_final_admins($id_pertemuan)
{
    return $this->db->select('a.*, s.nama, s.nis')
                    ->from('absensi_pertemuan a')
                    ->join('siswa s', 's.nis = a.siswa_id')
                    ->where('a.id_pertemuan', $id_pertemuan)
                    ->order_by('s.nama', 'ASC')
                    ->get()
                    ->result();
}
public function update_status_absensi($id_absen, $status)
{
    return $this->db->where('id', $id_absen)
        ->update('absensi_pertemuan', [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
}
public function get_detail_pertemuans($id_pertemuan)
{
    return $this->db->select("p.*, g.nama_guru, m.nama_mapel, k.nama_kelas")
                    ->from("pertemuan p")
                    ->join("guru g", "p.id_guru = g.nis", "left")
                    ->join("mata_pelajaran m", "p.id_mapel = m.id", "left")
                    ->join("kelas k", "p.id_kelas = k.id", "left")
                    ->where("p.id", $id_pertemuan)
                    ->get()
                    ->row();
}

public function get_absensi_pertemuans($id_pertemuan)
{
    return $this->db->select("ap.*, s.nama, s.nis")
                    ->from("absensi_pertemuan ap")
                    ->join("siswa s", "ap.id_siswa = s.id", "left")
                    ->where("ap.id_pertemuan", $id_pertemuan)
                    ->order_by("s.nama", "ASC")
                    ->get()
                    ->result();
}

public function get_pertemuan_semester($kelas_id, $mapel_id, $semester)
{
    return $this->db->select("id, pertemuan_ke, tanggal")
                    ->from("pertemuan")
                    ->where("id_kelas", $kelas_id)
                    ->where("id_mapel", $mapel_id)
                    ->where("semester", $semester)
                    ->order_by("pertemuan_ke", "ASC")
                    ->get()
                    ->result();
}

public function get_absensi_by_pertemuan_ids($pertemuan_ids)
{
    return $this->db->select("ap.*, s.nama, s.nis")
                    ->from("absensi_pertemuan ap")
                    ->join("siswa s", "ap.siswa_id = s.nis", "left")
                    ->where_in("ap.id_pertemuan", $pertemuan_ids)
                    ->order_by("s.nama", "ASC")
                    ->get()
                    ->result();
}
public function get_pertemuan_range($kelas_id, $mapel_id, $start, $end)
{
    return $this->db->select("p.id, p.pertemuan_ke, p.tanggal, m.id_mapel, m.id_guru")
                    ->from("pertemuan p")
                    ->join("materi m", "m.id = p.id_materi", "left")
                    ->where("p.id_kelas", $kelas_id)
                    ->where("m.id_mapel", $mapel_id)
                    ->where("p.pertemuan_ke >=", $start)
                    ->where("p.pertemuan_ke <=", $end)
                    ->order_by("p.pertemuan_ke", "ASC")
                    ->get()
                    ->result_array();
}

public function get_siswa_kelas($kelas_id)
{
    return $this->db->where("id_kelas", $kelas_id)
                    ->get("siswa")
                    ->result_array();
}

public function get_status_absensi($id_pertemuan, $nis)
{
    $row = $this->db->select("status")
                    ->where("id_pertemuan", $id_pertemuan)
                    ->where("siswa_id", $nis)
                    ->get("absensi_pertemuan")
                    ->row();

    return $row ? $row->status : "tidak_hadir";
}
public function get_absensi_per_pertemuans($id_pertemuan)
{
    return $this->db->select("absensi_pertemuan.*, siswa.nama, siswa.nis")
                    ->from("absensi_pertemuan")
                    ->join("siswa", "siswa.nis = absensi_pertemuan.siswa_id")
                    ->where("absensi_pertemuan.id_pertemuan", $id_pertemuan)
                    ->order_by("siswa.nama", "ASC")
                    ->get()
                    ->result_array();
}




}
