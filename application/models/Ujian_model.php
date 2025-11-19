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
public function get_ujian_by_gurus($nip)
{
    $this->db->select('
        tbl_ujian.*, 
        mata_pelajaran.nama_mapel,
        kelas.nama_kelas,
        kelas.tingkat,
        pertemuan.pertemuan_ke
    ');
    $this->db->from('tbl_ujian');
    $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');

    // ✔ FIX UTAMA — gunakan pertemuan.id_guru, bukan materi.id_guru
    $this->db->where('pertemuan.id_guru', $nip);

    return $this->db->get()->result_array();
}


    public function get_soal($id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        return $this->db->get('tbl_soal')->result();
    }
public function get_soal_by_id($id)
{
    return $this->db->get_where('ujian_soal', ['id' => $id])->row_array();
}

public function delete_soal($id)
{
    return $this->db->delete('ujian_soal', ['id' => $id]);
}

public function soal_sudah_dikerjakan($id)
{
    $soal = $this->get_soal_by_id($id);
    if (!$soal) return false;

    $this->db->from('tbl_jawaban_siswa');

    if ($soal['sumber'] === 'bank_soal') {
        $this->db->where('bank_soal_id', $soal['bank_soal_id']);
    } else {
        $this->db->where('id_soal', $soal['soal_id']);
    }

    $this->db->where('id_ujian', $soal['ujian_id']);

    return $this->db->count_all_results() > 0;
}
public function hapus_ujian($id_ujian)
{
    // 1. Ambil semua soal dari ujian_soal
    $soal_ujian = $this->db->get_where('ujian_soal', ['ujian_id' => $id_ujian])->result();

    foreach ($soal_ujian as $soal) {
        if ($soal->sumber === 'pribadi') {
            $this->db->where('id_soal', $soal->id_soal);
        } elseif ($soal->sumber === 'bank') {
            $this->db->where('bank_soal_id', $soal->bank_soal_id);
        }
        $this->db->where('id_ujian', $id_ujian); // pastikan filter tetap kuat
        $this->db->delete('tbl_jawaban_siswa');
    }

    // 🔥 Hapus semua jawaban yang mungkin tidak terkait id_soal/bank (sisa orphan)
    $this->db->where('id_ujian', $id_ujian);
    $this->db->delete('tbl_jawaban_siswa');

    // 2. Hapus soal pribadi
    $this->db->where('id_ujian', $id_ujian);
    $this->db->delete('tbl_soal');

    // 3. Hapus relasi soal
    $this->db->where('ujian_id', $id_ujian);
    $this->db->delete('ujian_soal');

    // 4. Hapus ujian
    $this->db->where('id_ujian', $id_ujian);
    return $this->db->delete('tbl_ujian');
}





public function get_materi_options($nip) {
    $this->db->select('
        pertemuan.id AS id_pertemuan,
        materi.deskripsi,
        kelas.nama_kelas,
        kelas.tingkat,
        mata_pelajaran.nama_mapel,
        pertemuan.pertemuan_ke
    ');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');

    // ✔ Ambil pertemuan berdasarkan guru yang membuat pertemuan
    $this->db->where('pertemuan.id_guru', $nip);

    // ✔ Urutkan rapi, tidak mempengaruhi fleksibilitas PKBM
    $this->db->order_by('kelas.tingkat', 'ASC');
    $this->db->order_by('kelas.nama_kelas', 'ASC');
    $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');

    return $this->db->get()->result();
}

public function get_materi_optionss($nip)
{
    $this->db->select('
        pertemuan.id AS id_pertemuan,
        materi.id AS id_materi,
        materi.deskripsi,
        kelas.id AS id_kelas,
        kelas.nama_kelas,
        kelas.tingkat,
        mata_pelajaran.id AS id_mapel,
        mata_pelajaran.nama_mapel,
        pertemuan.pertemuan_ke
    ');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->where('materi.id_guru', $nip); // hanya materi milik guru
    $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
    $this->db->order_by('kelas.tingkat', 'ASC');
    $this->db->order_by('kelas.nama_kelas', 'ASC');
    $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');

    return $this->db->get()->result();
}


public function get_ujian_by_kelas($id_kelas, $nip_guru, $id_mapel)
{
    $this->db->select('tbl_ujian.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
    $this->db->from('tbl_ujian');
    $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    $this->db->where('pertemuan.id_kelas', $id_kelas); // HARUS ambil dari pertemuan, bukan materi!
    $this->db->where('materi.id_mapel', $id_mapel);     // ✅ Tambahkan filter mapel di sini
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

public function hitung_skor($id_ujian, $nis) {
    $this->load->database();

    // 1. Ambil semua soal ujian (PG + Essay)
    $ujian_soal = $this->db->get_where('ujian_soal', ['ujian_id' => $id_ujian])->result();
    
    // 2. Hitung total soal per tipe
    $soal_pg_total = 0;
    $soal_essay_total = 0;
    $jumlah_benar = 0;
    $nilai_essay_total = 0;
    $essay_terkoreksi = 0;
    $essay_belum_dinilai = false;

    // 3. Ambil semua jawaban siswa sekaligus (optimasi query)
    $jawaban_siswa = $this->db->get_where('tbl_jawaban_siswa', [
        'id_ujian' => $id_ujian, 
        'nis' => $nis
    ])->result();

    foreach ($ujian_soal as $item) {
        $is_bank = $item->sumber === 'bank_soal';
        $soal_id = $is_bank ? $item->bank_soal_id : $item->soal_id;
        $tabel_soal = $is_bank ? 'bank_soal' : 'tbl_soal';

        $soal = $this->db->select('id_soal, tipe_soal, kunci_jawaban')
                         ->get_where($tabel_soal, ['id_soal' => $soal_id])
                         ->row();

        if (!$soal) continue;

        // 4. Cari jawaban siswa (jika ada)
        $jawaban = null;
        foreach ($jawaban_siswa as $js) {
            if (($is_bank && $js->bank_soal_id == $soal_id) || 
                (!$is_bank && $js->id_soal == $soal_id)) {
                $jawaban = $js;
                break;
            }
        }

        if ($soal->tipe_soal === 'pilihan') {
            $soal_pg_total++;
            
            // 5. Jika tidak dijawab atau jawaban salah → salah
            if ($jawaban && $jawaban->jawaban === $soal->kunci_jawaban) {
                $jumlah_benar++;
            }
            // Jika tidak ada record jawaban, otomatis dianggap salah (tidak perlu penanganan)

        } elseif ($soal->tipe_soal === 'essay') {
            $soal_essay_total++;
            
            // 6. Essay: Tidak diisi = 0, Sudah dinilai = ambil nilai, Belum dinilai = flag
            if (!$jawaban || empty($jawaban->jawaban_essay)) {
                // Tidak diisi sama sekali
                $nilai_essay_total += 0;
            } elseif (is_null($jawaban->nilai_essay)) {
                $essay_belum_dinilai = true;
            } else {
                $nilai_essay_total += floatval($jawaban->nilai_essay);
            }
        }
    }

    // 7. Hitung nilai akhir (PG salah otomatis, Essay 0 jika tidak diisi)
    $nilai_pg = $soal_pg_total > 0 ? ($jumlah_benar / $soal_pg_total) * 100 : 0;
    $rata_essay = $soal_essay_total > 0 ? ($nilai_essay_total / $soal_essay_total) : 0;

    $ujian = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();
    $bobot_pg = $ujian->bobot_pg / 100;
    $bobot_essay = $ujian->bobot_essay / 100;

    $total_nilai = ($nilai_pg * $bobot_pg) + ($rata_essay * $bobot_essay);

    // 8. Update database
    $data_update = [
        'jumlah_benar' => $jumlah_benar,
        'jumlah_salah' => $soal_pg_total - $jumlah_benar, // Otomatis hitung salah
        'score' => $total_nilai,
        'is_selesai' => 1,
        'waktu_submit' => date('Y-m-d H:i:s')
    ];

    if (!$essay_belum_dinilai) {
        $data_update['nilai_akhir'] = $total_nilai;
    }

    $this->db->where(['id_ujian' => $id_ujian, 'nis' => $nis])
             ->update('tbl_jawaban_siswa', $data_update);
    log_message('debug', 'Total PG: '.$soal_pg_total.' | Benar: '.$jumlah_benar.' | NIS: '.$nis.' | Ujian: '.$id_ujian);
    log_message('debug', 'Soal Essay Total: '.$soal_essay_total.' | Sudah dinilai: '.$essay_terkoreksi);
    log_message('debug', 'Nilai PG: '.$nilai_pg.' | Rata Essay: '.$rata_essay.' | Total Nilai: '.$total_nilai);
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
    $this->db->select('tbl_ujian.*, guru.nama_guru, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->from('tbl_ujian');
        $this->db->join('guru', 'guru.nip = tbl_ujian.nip_guru');
        $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
        $this->db->join('materi', 'materi.id = pertemuan.id_materi');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
        $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
        return $this->db->get();
    }
public function get_paginated_ujian($limit, $start, $filters = [])
{
    $this->db->select('tbl_ujian.*, guru.nama_guru, mata_pelajaran.nama_mapel, kelas.nama_kelas');
    $this->db->from('tbl_ujian');
    $this->db->join('guru', 'guru.nip = tbl_ujian.nip_guru');
    $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    
    // Filter keyword
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('tbl_ujian.nama_ujian', $filters['keyword']);
        $this->db->or_like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->group_end();
    }
    
    // Filter guru
    if (!empty($filters['guru'])) {
        $this->db->where('guru.nip', $filters['guru']);
    }
    
    // Filter mapel
    if (!empty($filters['mapel'])) {
        $this->db->where('mata_pelajaran.id', $filters['mapel']);
    }
    
    // Filter kelas
    if (!empty($filters['kelas'])) {
        $this->db->where('kelas.id', $filters['kelas']);
    }
    
    // Filter status
    if (!empty($filters['status'])) {
        $this->db->where('tbl_ujian.status', $filters['status']);
    }
    
    $this->db->order_by('tbl_ujian.id_ujian', 'DESC');
    $this->db->limit($limit, $start);
    return $this->db->get()->result();
}

public function count_all_ujian($filters = [])
{
    $this->db->select('COUNT(tbl_ujian.id_ujian) as total');
    $this->db->from('tbl_ujian');
    $this->db->join('guru', 'guru.nip = tbl_ujian.nip_guru');
    $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    
    // Filter keyword
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('tbl_ujian.nama_ujian', $filters['keyword']);
        $this->db->or_like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->group_end();
    }
    
    // Filter guru
    if (!empty($filters['guru'])) {
        $this->db->where('guru.nip', $filters['guru']);
    }
    
    // Filter mapel
    if (!empty($filters['mapel'])) {
        $this->db->where('mata_pelajaran.id', $filters['mapel']);
    }
    
    // Filter kelas
    if (!empty($filters['kelas'])) {
        $this->db->where('kelas.id', $filters['kelas']);
    }
    
    // Filter status
    if (!empty($filters['status'])) {
        $this->db->where('tbl_ujian.status', $filters['status']);
    }

    $query = $this->db->get();
    return $query->row()->total;
}

// Method untuk dropdown filter
public function get_guru_list()
{
    $this->db->select('nip, nama_guru');
    $this->db->from('guru');
    $this->db->order_by('nama_guru', 'asc');
    return $this->db->get()->result();
}

public function get_mapel_list()
{
    $this->db->select('id, nama_mapel');
    $this->db->from('mata_pelajaran');
    $this->db->order_by('nama_mapel', 'asc');
    return $this->db->get()->result();
}

public function get_kelas_list()
{
    $this->db->select('id, nama_kelas');
    $this->db->from('kelas');
    $this->db->order_by('nama_kelas', 'asc');
    return $this->db->get()->result();
}

    public function detail_ujian($id_ujian = null)
    {
        $this->db->from('tbl_ujian');
        $this->db->join('guru', 'guru.nip = tbl_ujian.nip_guru');
        $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
        $this->db->join('materi', 'materi.id = pertemuan.id_materi');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
        $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
        $this->db->where('tbl_ujian.id_ujian', $id_ujian);
        return $this->db->get()->row();
    }
public function get_peserta_ujian($ujian_id)
{
    // Ambil data ujian
    $ujian = $this->db->get_where('tbl_ujian', ['id_ujian' => $ujian_id])->row();
    $bobot_pg = $ujian ? ($ujian->bobot_pg / 100) : 0.7;
    $bobot_essay = $ujian ? ($ujian->bobot_essay / 100) : 0.3;

    // Ambil soal
    $ujian_soal = $this->db->get_where('ujian_soal', ['ujian_id' => $ujian_id])->result();

    $soal_pg_total = 0;
    $soal_essay_total = 0;
    $soal_map = [];

    foreach ($ujian_soal as $s) {
        $id_soal = $s->sumber == 'bank_soal' ? $s->bank_soal_id : $s->soal_id;
        $table = $s->sumber == 'bank_soal' ? 'bank_soal' : 'tbl_soal';
        $soal = $this->db->select('id_soal, tipe_soal, kunci_jawaban')->get_where($table, ['id_soal' => $id_soal])->row();
        if ($soal) {
            $key = $s->sumber . '_' . $id_soal;
            $soal_map[$key] = $soal;
            if ($soal->tipe_soal == 'pilihan') $soal_pg_total++;
            if ($soal->tipe_soal == 'essay') $soal_essay_total++;
        }
    }

    // Ambil semua jawaban siswa
    $this->db->select('js.*, s.nama,  k.nama_kelas');
    $this->db->from('tbl_jawaban_siswa js');
    $this->db->join('siswa s', 's.nis = js.nis');
    $this->db->join('kelas k', 'k.id = s.id_kelas');
    $this->db->where('js.id_ujian', $ujian_id);
    $this->db->order_by('s.nama');
    $jawaban_all = $this->db->get()->result();

    // Kelompokkan per siswa
    $ranking = [];
    foreach ($jawaban_all as $j) {
        $key = $j->sumber . '_' . ($j->sumber == 'bank_soal' ? $j->bank_soal_id : $j->id_soal);
        $nis = $j->nis;

        if (!isset($ranking[$nis])) {
            $ranking[$nis] = [
                'nis' => $j->nis,
                'nama' => $j->nama,
                'nama_kelas' => $j->nama_kelas,
                'jumlah_benar' => 0,
                'nilai_essay_total' => 0,
                'jumlah_essay_terkoreksi' => 0,
                'waktu_dikerjakan' => $j->waktu_jawab ?? null
            ];
        }

        if (!isset($soal_map[$key])) continue;
        $soal = $soal_map[$key];

        if ($soal->tipe_soal == 'pilihan') {
            if ($j->jawaban == $soal->kunci_jawaban) {
                $ranking[$nis]['jumlah_benar']++;
            }
        } elseif ($soal->tipe_soal == 'essay') {
            if (!is_null($j->nilai_essay)) {
                $ranking[$nis]['nilai_essay_total'] += floatval($j->nilai_essay);
                $ranking[$nis]['jumlah_essay_terkoreksi']++;
            }
        }
    }

    // Hitung nilai akhir
    foreach ($ranking as &$r) {
        $nilai_pg = $soal_pg_total > 0 ? ($r['jumlah_benar'] / $soal_pg_total) * 100 : 0;
        $rata_essay = $soal_essay_total > 0 ? ($r['nilai_essay_total'] / $soal_essay_total) : 0;
        $r['total_nilai'] = ($nilai_pg * $bobot_pg) + ($rata_essay * $bobot_essay);
    }

    return array_values($ranking);
}



public function update_nilai_akhir($id_jawaban)
{
    // Ambil jawaban siswa
    $jawaban = $this->db->get_where('tbl_jawaban_siswa', ['id_jawaban' => $id_jawaban])->row();

    if (!$jawaban) return;

    $id_ujian = $jawaban->id_ujian;
    $nis = $jawaban->nis;

    // Ambil semua jawaban siswa untuk ujian itu
    $jawaban_siswa = $this->db->get_where('tbl_jawaban_siswa', [
        'id_ujian' => $id_ujian,
        'nis' => $nis
    ])->result();

    $jumlah_benar = 0;
    $total_soal_pg = 0;
    $total_nilai_essay = 0;
    $jumlah_soal_essay = 0;

    foreach ($jawaban_siswa as $j) {
        // Ambil soal
        $soal = null;
        if ($j->sumber == 'bank_soal') {
            $soal = $this->db->get_where('bank_soal', ['id_soal' => $j->bank_soal_id])->row();
        } else {
            $soal = $this->db->get_where('tbl_soal', ['id_soal' => $j->id_soal])->row();
        }

        if (!$soal) continue;

        // Hitung PG
        if ($soal->tipe_soal == 'pilihan') {
            $total_soal_pg++;
            if ($j->jawaban == $soal->kunci_jawaban) {
                $jumlah_benar++;
            }
        }

        // Hitung Essay
        if ($soal->tipe_soal == 'essay' && $j->nilai_essay !== null) {
            $total_nilai_essay += floatval($j->nilai_essay);
            $jumlah_soal_essay++;
        }
    }

    $nilai_pg = $total_soal_pg > 0 ? ($jumlah_benar / $total_soal_pg) * 100 : 0;
    $rata_essay = $jumlah_soal_essay > 0 ? $total_nilai_essay / $jumlah_soal_essay : 0;

    // Ambil bobot dari ujian
    $ujian = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();
    $bobot_pg = $ujian->bobot_pg ?? 70;
    $bobot_essay = $ujian->bobot_essay ?? 30;

    if ($total_soal_pg > 0 && $jumlah_soal_essay > 0) {
        $total_nilai = ($nilai_pg * ($bobot_pg / 100)) + ($rata_essay * ($bobot_essay / 100));
    } elseif ($total_soal_pg > 0) {
        $total_nilai = $nilai_pg;
    } elseif ($jumlah_soal_essay > 0) {
        $total_nilai = $rata_essay;
    } else {
        $total_nilai = 0;
    }

    // Update semua jawaban siswa untuk ujian itu (boleh hanya salah satu juga)
    $this->db->where('id_ujian', $id_ujian);
    $this->db->where('nis', $nis);
    $this->db->update('tbl_jawaban_siswa', ['nilai_akhir' => $total_nilai]);
}
 public function get_peserta_ujians($id_ujian)
    {
        $this->db->select('s.nis, s.nama, MAX(j.id_jawaban) as terakhir');
        $this->db->from('tbl_jawaban_siswa j');
        $this->db->join('siswa s', 's.nis = j.nis');
        $this->db->where('j.id_ujian', $id_ujian);
        $this->db->group_by('s.nis, s.nama');
        $this->db->order_by('s.nama', 'ASC');
        return $this->db->get()->result();
    }
    public function get_ujian_by_ids($id_ujian)
{
    $this->db->select('tbl_ujian.*, guru.nama_guru, mata_pelajaran.nama_mapel, kelas.nama_kelas');
    $this->db->from('tbl_ujian');
    $this->db->join('guru', 'guru.nip = tbl_ujian.nip_guru');
    $this->db->join('pertemuan', 'pertemuan.id = tbl_ujian.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    $this->db->where('tbl_ujian.id_ujian', $id_ujian);
    return $this->db->get()->row(); // row karena hanya satu
}


    // Hapus semua jawaban siswa untuk 1 ujian
    public function hapus_jawaban_siswa($id_ujian, $nis)
    {
        $this->db->where('id_ujian', $id_ujian);
        $this->db->where('nis', $nis);
        return $this->db->delete('tbl_jawaban_siswa');
    }

}