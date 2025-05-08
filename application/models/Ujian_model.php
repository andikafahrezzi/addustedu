<?php
class Ujian_model extends CI_Model {

    public function get_active_ujian()
    {
        $today = date('Y-m-d');
        $this->db->where('tanggal_mulai <=', $today);
        $this->db->where('tanggal_selesai >=', $today);
        $this->db->where('status', 'aktif');
        return $this->db->get('tbl_ujian')->row();
    }
    public function get_ujian_by_guru($nip)
    {
        $this->db->select('tbl_ujian.*, materi.nama_mapel');
        $this->db->from('tbl_ujian');
        $this->db->join('materi', 'materi.id = tbl_ujian.id_materi');
        $this->db->where('materi.id_guru', $nip);  // Menambahkan filter berdasarkan nip guru
        return $this->db->get()->result_array();  // Mengambil hasil sebagai array
    }
    public function get_soal($id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        return $this->db->get('tbl_soal')->result();
    }

    public function get_materi_options($nip) {
        $this->db->select('id, deskripsi, kelas, nama_mapel');
        $this->db->from('materi');
        $this->db->where('id_guru', $nip);
        return $this->db->get()->result();
    }


public function get_ujian_by_kelas($kelas_siswa)
{
    $this->db->select('tbl_ujian.*, materi.nama_mapel, materi.kelas');
    $this->db->from('tbl_ujian');
    $this->db->join('materi', 'materi.id = tbl_ujian.id_materi');
    $this->db->where('materi.kelas', $kelas_siswa);
    $this->db->where('tbl_ujian.status', 'aktif');
    return $this->db->get()->result_array();
}
public function get_all_soal_by_ujian($ujian_id)
{
    $soal_list = [];

    // Ambil dari bank_soal
    $this->db->select('bank_soal.id_soal as id, bank_soal.pertanyaan, bank_soal.pilihan_a, 
                      bank_soal.pilihan_b, bank_soal.pilihan_c, bank_soal.pilihan_d, 
                      bank_soal.kunci_jawaban, "bank_soal" as sumber');
    $this->db->from('ujian_soal');
    $this->db->join('bank_soal', 'bank_soal.id_soal = ujian_soal.bank_soal_id');
    $this->db->where('ujian_soal.ujian_id', $ujian_id);
    $this->db->where('ujian_soal.sumber', 'bank_soal');
    $bank_soal = $this->db->get()->result_array();

    // Ambil dari tbl_soal
    $this->db->select('tbl_soal.id_soal as id, tbl_soal.pertanyaan, tbl_soal.pilihan_a, 
                      tbl_soal.pilihan_b, tbl_soal.pilihan_c, tbl_soal.pilihan_d, 
                      tbl_soal.kunci_jawaban, "tbl_soal" as sumber');
    $this->db->from('ujian_soal');
    $this->db->join('tbl_soal', 'tbl_soal.id_soal = ujian_soal.soal_id');
    $this->db->where('ujian_soal.ujian_id', $ujian_id);
    $this->db->where('ujian_soal.sumber', 'tbl_soal');
    $tbl_soal = $this->db->get()->result_array();

    return array_merge($bank_soal, $tbl_soal);
}

public function update_ujian($id_ujian, $data)
{
    $this->db->where('id_ujian', $id_ujian);
    $this->db->update('tbl_ujian', $data);  // Memperbarui data berdasarkan id_ujian
}

public function simpan_jawaban($id_soal, $jawaban, $ragu, $sumber = 'tbl_soal')
{
    // Validasi sumber soal
    if (!in_array($sumber, ['tbl_soal', 'bank_soal'])) {
        log_message('error', 'Sumber soal tidak valid: ' . $sumber);
        return false;
    }

    $data = [
        'nis' => $this->session->userdata('nis'),
        'id_ujian' => $this->session->userdata('ujian_id'),
        'jawaban' => $jawaban,
        'ragu_ragu' => $ragu,
        'sumber' => $sumber,
        'waktu_jawab' => date('Y-m-d H:i:s')
    ];

    // Set kolom sesuai sumber
    if ($sumber === 'tbl_soal') {
        $data['id_soal'] = $id_soal;
        $data['bank_soal_id'] = null;
    } else {
        $data['bank_soal_id'] = $id_soal;
        $data['id_soal'] = null;
    }

    // Mulai transaction
    $this->db->trans_start();

    // Cek existing jawaban
    $where = [
        'nis' => $data['nis'],
        'id_ujian' => $data['id_ujian']
    ];

    if ($sumber === 'tbl_soal') {
        $where['id_soal'] = $id_soal;
    } else {
        $where['bank_soal_id'] = $id_soal;
    }

    $existing = $this->db->get_where('tbl_jawaban_siswa', $where)->row();

    if ($existing) {
        $this->db->where('id_jawaban', $existing->id_jawaban);
        $result = $this->db->update('tbl_jawaban_siswa', $data);
    } else {
        $result = $this->db->insert('tbl_jawaban_siswa', $data);
    }

    $this->db->trans_complete();

    return $this->db->trans_status();
}
public function tandai_ragu($id_soal, $jawaban, $sumber)
{
    $data = [
        'nis' => $this->session->userdata('nis'),
        'id_ujian' => $this->session->userdata('ujian_id'),
        'jawaban' => $jawaban,
        'ragu_ragu' => 1,
        'sumber' => $sumber,
        'waktu_jawab' => date('Y-m-d H:i:s')
    ];

    // Set kolom sesuai sumber soal
    if ($sumber === 'tbl_soal') {
        $data['id_soal'] = $id_soal;
        $data['bank_soal_id'] = null;
        $where = ['id_soal' => $id_soal];
    } else {
        $data['bank_soal_id'] = $id_soal;
        $data['id_soal'] = null;
        $where = ['bank_soal_id' => $id_soal];
    }

    // Tambahkan kondisi umum
    $where['nis'] = $data['nis'];
    $where['id_ujian'] = $data['id_ujian'];

    // Cek apakah sudah ada jawaban
    $existing = $this->db->get_where('tbl_jawaban_siswa', $where)->row();

    $this->db->trans_start();
    
    if ($existing) {
        $this->db->where('id_jawaban', $existing->id_jawaban);
        $result = $this->db->update('tbl_jawaban_siswa', $data);
    } else {
        $result = $this->db->insert('tbl_jawaban_siswa', $data);
    }

    $this->db->trans_complete();

    return $this->db->trans_status();
}

public function hitung_skor($id_ujian, $nis)
{
    // Ambil semua jawaban siswa untuk ujian ini
    $jawaban_siswa = $this->db->get_where('tbl_jawaban_siswa', [
        'id_ujian' => $id_ujian,
        'nis' => $nis
    ])->result();

    $jumlah_benar = 0;
    $total_soal = count($jawaban_siswa);

    foreach ($jawaban_siswa as $jawaban) {
        $kunci_jawaban = null;
        
        // Cek sumber soal
        if ($jawaban->sumber == 'bank_soal') {
            // Ambil kunci jawaban dari bank_soal
            $this->db->select('kunci_jawaban');
            $this->db->from('bank_soal');
            $this->db->where('id_soal', $jawaban->bank_soal_id);
            $soal = $this->db->get()->row();
            
            if ($soal) {
                $kunci_jawaban = $soal->kunci_jawaban;
            }
        } else {
            // Ambil kunci jawaban dari tbl_soal
            $this->db->select('kunci_jawaban');
            $this->db->from('tbl_soal');
            $this->db->where('id_soal', $jawaban->id_soal);
            $soal = $this->db->get()->row();
            
            if ($soal) {
                $kunci_jawaban = $soal->kunci_jawaban;
            }
        }

        // Bandingkan jawaban siswa dengan kunci
        if ($kunci_jawaban && $jawaban->jawaban == $kunci_jawaban) {
            $jumlah_benar++;
        }
    }

    $score = $total_soal > 0 ? ($jumlah_benar / $total_soal) * 100 : 0;

    // Update skor
    $this->db->where(['id_ujian' => $id_ujian, 'nis' => $nis])
            ->update('tbl_jawaban_siswa', [
                'jumlah_benar' => $jumlah_benar,
                'jumlah_salah' => $total_soal - $jumlah_benar,
                'score' => $score,
                'is_selesai' => 1,
                'waktu_submit' => date('Y-m-d H:i:s')
            ]);

    return $score;
}

    public function get_ujian_by_id($id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        return $this->db->get('tbl_ujian')->row();
    }

    public function cek_sudah_mulai($id_ujian, $nis)
    {
        return $this->db->get_where('tbl_jawaban_siswa', [
            'id_ujian' => $id_ujian,
            'nis' => $nis
        ])->row();
    }

    // public function mulai_ujian($id_ujian, $nis)
    // {
    //     $data = [
    //         'nis' => $nis,
    //         'id_ujian' => $id_ujian,
    //         'waktu_mulai_ujian' => date('Y-m-d H:i:s')
    //     ];
    //     return $this->db->insert('tbl_jawaban_siswa', $data);
    // }

    // Fungsi-fungsi lainnya tetap sama seperti sebelumnya...
}