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
        $this->db->select('tbl_ujian.*, mata_pelajaran.nama_mapel');
        $this->db->from('tbl_ujian');
        $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
        $this->db->join('materi', 'materi.id = pertemuan.id_materi');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
        $this->db->where('materi.id_guru', $nip);  // Menambahkan filter berdasarkan nip guru
        return $this->db->get()->result_array();  // Mengambil hasil sebagai array
    }
    public function get_soal($id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        return $this->db->get('tbl_soal')->result();
    }

    public function get_materi_options($nip) {
        $this->db->select('pertemuan.id AS id_pertemuan, materi.deskripsi, kelas.nama_kelas, kelas.tingkat, mata_pelajaran.nama_mapel, pertemuan.pertemuan_ke');
        $this->db->from('pertemuan');
        $this->db->join('materi', 'materi.id = pertemuan.id_materi');
        $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
        $this->db->where('materi.id_guru', $nip);
        $this->db->order_by('kelas.tingkat', 'ASC');
        $this->db->order_by('kelas.nama_kelas', 'ASC');
        $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');
        return $this->db->get()->result();
    }



public function get_ujian_by_kelas($id_kelas, $nip_guru)
{
    $this->db->select('tbl_ujian.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
    $this->db->from('tbl_ujian');
    $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->where('materi.id_kelas', $id_kelas);
    $this->db->where('tbl_ujian.status', 'aktif');
    $this->db->where('tbl_ujian.nip_guru', $nip_guru);
    return $this->db->get()->result_array();
}

public function get_all_soal_by_ujian($ujian_id)
{
    $soal_list = [];

    // Ambil dari bank_soal
    $this->db->select('bank_soal.id_soal as id, bank_soal.pertanyaan, bank_soal.pilihan_a, 
                      bank_soal.pilihan_b, bank_soal.pilihan_c, bank_soal.pilihan_d, 
                      bank_soal.kunci_jawaban,bank_soal.tipe_soal, "bank_soal" as sumber');
    $this->db->from('ujian_soal');
    $this->db->join('bank_soal', 'bank_soal.id_soal = ujian_soal.bank_soal_id');
    $this->db->where('ujian_soal.ujian_id', $ujian_id);
    $this->db->where('ujian_soal.sumber', 'bank_soal');
    $bank_soal = $this->db->get()->result_array();

    // Ambil dari tbl_soal
    $this->db->select('tbl_soal.id_soal as id, tbl_soal.pertanyaan, tbl_soal.pilihan_a, 
                      tbl_soal.pilihan_b, tbl_soal.pilihan_c, tbl_soal.pilihan_d, 
                      tbl_soal.kunci_jawaban,tbl_soal.tipe_soal, "tbl_soal" as sumber');
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

public function simpan_jawaban($id_soal, $jawaban, $ragu, $sumber = 'tbl_soal', $tipe_soal = 'pilihan')
{
    if (!in_array($sumber, ['tbl_soal', 'bank_soal'])) return false;

    $data = [
        'nis' => $this->session->userdata('nis'),
        'id_ujian' => $this->session->userdata('ujian_id'),
        'ragu_ragu' => $ragu,
        'sumber' => $sumber,
        'waktu_jawab' => date('Y-m-d H:i:s')
    ];

    // Simpan ke kolom jawaban atau jawaban_essay
    if ($tipe_soal === 'pilihan') {
        $data['jawaban'] = $jawaban;
        $data['jawaban_essay'] = null;
    } else {
        $data['jawaban'] = null;
        $data['jawaban_essay'] = $jawaban;
    }

    if ($sumber === 'tbl_soal') {
        $data['id_soal'] = $id_soal;
        $data['bank_soal_id'] = null;
    } else {
        $data['bank_soal_id'] = $id_soal;
        $data['id_soal'] = null;
    }

    $this->db->trans_start();

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
        $this->db->update('tbl_jawaban_siswa', $data);
    } else {
        $this->db->insert('tbl_jawaban_siswa', $data);
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
    $jawaban_siswa = $this->db->get_where('tbl_jawaban_siswa', [
        'id_ujian' => $id_ujian,
        'nis' => $nis
    ])->result();

    $jumlah_benar = 0;
    $total_soal_pg = 0;
    $nilai_essay_total = 0;
    $jumlah_soal_essay = 0;

    foreach ($jawaban_siswa as $jawaban) {
        $kunci_jawaban = null;
        $tipe_soal = null;

        // Ambil soal
        if ($jawaban->sumber == 'bank_soal') {
            $soal = $this->db->select('kunci_jawaban, tipe_soal')
                             ->from('bank_soal')
                             ->where('id_soal', $jawaban->bank_soal_id)
                             ->get()->row();
        } else {
            $soal = $this->db->select('kunci_jawaban, tipe_soal')
                             ->from('tbl_soal')
                             ->where('id_soal', $jawaban->id_soal)
                             ->get()->row();
        }

        if ($soal) {
            $kunci_jawaban = $soal->kunci_jawaban;
            $tipe_soal = $soal->tipe_soal;
        }

        if ($tipe_soal === 'pilihan') {
            $total_soal_pg++;
            if ($jawaban->jawaban == $kunci_jawaban) {
                $jumlah_benar++;
            }
        } elseif ($tipe_soal === 'essay') {
            // 🔒 Cek apakah guru sudah menilai
            if (is_null($jawaban->nilai_essay)) {
                // Essay belum dinilai
                return false; // atau return -1 jika mau
            }

            $nilai_essay_total += floatval($jawaban->nilai_essay);
            $jumlah_soal_essay++;
        }
    }

    $nilai_pg = $total_soal_pg > 0 ? ($jumlah_benar / $total_soal_pg) * 100 : 0;
    $rata_essay = $jumlah_soal_essay > 0 ? $nilai_essay_total / $jumlah_soal_essay : 0;

    $total_nilai = ($nilai_pg * 0.7) + ($rata_essay * 0.3);

    // Update skor
    $this->db->where(['id_ujian' => $id_ujian, 'nis' => $nis])
             ->update('tbl_jawaban_siswa', [
                'jumlah_benar' => $jumlah_benar,
                'jumlah_salah' => $total_soal_pg - $jumlah_benar,
                'score' => $total_nilai,
                'is_selesai' => 1,
                'waktu_submit' => date('Y-m-d H:i:s')
             ]);

    return $total_nilai;
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
    public function tampil_ujian()
    {
    return $this->db->get('tbl_ujian');
    }
    public function detail_ujian($id_ujian = null)
    {
        $query = $this->db->get_where('tbl_ujian', array('id_ujian' => $id_ujian))->row();
        return $query;
    }
    public function get_peserta_ujian($ujian_id) {
        $this->db->select('siswa.nis, siswa.nama, siswa.kelas, tbl_jawaban_siswa.id_ujian, MAX(tbl_jawaban_siswa.score) as total_score, MAX(tbl_jawaban_siswa.waktu_jawab) as waktu_dikerjakan');
        $this->db->from('tbl_jawaban_siswa');
        $this->db->join('siswa', 'siswa.nis = tbl_jawaban_siswa.nis');
        $this->db->where('tbl_jawaban_siswa.id_ujian', $ujian_id);
        $this->db->group_by('tbl_jawaban_siswa.nis, tbl_jawaban_siswa.id_ujian');
        return $this->db->get()->result();
    }
}