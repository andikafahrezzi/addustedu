<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_soal_model extends CI_Model {

    public function get_all_soal() {
        $this->db->select('bank_soal.*, mata_pelajaran.nama_mapel');
        $this->db->from('bank_soal');
        $this->db->join('mata_pelajaran', 'bank_soal.id_mapel = mata_pelajaran.id', 'left');
        return $this->db->get();
    }
    public function get_kategori() {
    return []; // Bisa diisi kalau kamu punya kategori soal di masa depan
}
public function get_soal_by_mapel($id_mapel)
{
    $this->db->select('bank_soal.*, mata_pelajaran.nama_mapel');
    $this->db->from('bank_soal');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = bank_soal.id_mapel');
    $this->db->where('bank_soal.id_mapel', $id_mapel);
    $this->db->order_by('bank_soal.created_at', 'DESC');
    return $this->db->get()->result();
}



    
    public function get_soal_by_guru($nip) {
        // Join dengan tabel guru untuk memastikan mapel sesuai
        return $this->db->select('bank_soal.*')
                      ->from('bank_soal')
                      ->join('guru', 'guru.nama_mapel = bank_soal.mapel_diajarkan')
                      ->where('guru.nip', $nip)
                      ->where('bank_soal.user_type', 'guru')
                      ->order_by('bank_soal.created_at', 'DESC')
                      ->get()
                      ->result();
    }
    public function get_soal_by_mapel_kelas($id_mapel, $tingkat)
{
    $this->db->select('bank_soal.*');
    $this->db->from('bank_soal');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = bank_soal.id_mapel');
    $this->db->join('kelas', 'kelas.id = bank_soal.id_kelas');
    $this->db->where('bank_soal.id_mapel', $id_mapel);
    $this->db->where('kelas.tingkat', $tingkat);
    $this->db->order_by('bank_soal.created_at', 'DESC');
    return $this->db->get()->result();
}
public function get_detail_by_nip($nip)
{
    $this->db->select('guru.*, mata_pelajaran.id AS id_mapel, mata_pelajaran.nama_mapel');
    $this->db->from('guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru.id_mapel', 'left');
    $this->db->where('guru.nip', $nip);
    return $this->db->get()->row();
}
public function get_detail_by_nips($nip)
{
    // Ambil data guru
    $this->db->select('nip, nama_guru, email,  image,');
    $this->db->from('guru');
    $this->db->where('nip', $nip);
    $guru = $this->db->get()->row();

    if (!$guru) {
        return null;
    }

    // Ambil semua mata pelajaran yang diajarkan
    $this->db->select('mata_pelajaran.id AS id_mapel, mata_pelajaran.nama_mapel');
    $this->db->from('guru_mapel');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru_mapel.id_mapel');
    $this->db->where('guru_mapel.id_guru', $nip);
    $mapel = $this->db->get()->result();

    // Gabungkan data guru dan mapel
    $guru->mapel_diajarkan = $mapel; // array of mapel

    return $guru;
}
public function get_mapel_by_nip($nip)
{
    $this->db->select('mata_pelajaran.id, mata_pelajaran.nama_mapel');
    $this->db->from('guru_mapel');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru_mapel.id_mapel');
    $this->db->where('guru_mapel.id_guru', $nip);
    return $this->db->get()->result();
}


public function get_detail_soals($id_soal)
{
    return $this->db->where('id_soal', $id_soal)
                    ->get('bank_soal')
                    ->row();
}

public function hapus_soals($id_soal)
{
    return $this->db->where('id_soal', $id_soal)
                    ->delete('bank_soal');
}


    public function get_mapel_ids_by_guru($nip) {
    $this->db->select('id_mapel');
    $this->db->from('guru');
    $this->db->where('nip', $nip);
    $result = $this->db->get()->row();

    return $result ? [$result->id_mapel] : []; // Dibuat array agar kompatibel dengan perulangan
    }


    public function get_laporan_soal($nip = null) {
        $this->db->select('
            bank_soal.*,
            guru.nama_guru,
            guru.nama_mapel,
            materi.kelas
        ');
        
        $this->db->from('bank_soal');
        $this->db->join('guru', 'guru.nama_mapel = bank_soal.mapel_diajarkan', 'left');
        $this->db->join('materi', 'materi.nama_mapel = bank_soal.mapel_diajarkan', 'left');
        
        if ($nip) {
            $this->db->where('guru.nip', $nip);
        }
        
        return $this->db->get()->result();
    }
    

    public function tambah_soal($data) {
        // Handle perbedaan data untuk pilihan ganda vs essay
        if ($data['tipe_soal'] == 'essay') {
            $data['pilihan_a'] = null;
            $data['pilihan_b'] = null;
            $data['pilihan_c'] = null;
            $data['pilihan_d'] = null;
            $data['kunci_jawaban'] = null;
        }
        return $this->db->insert('bank_soal', $data);
    }
    
    public function update_soal($id_soal, $data) {
        // Logika update serupa
        if ($data['tipe_soal'] == 'essay') {
            $data['pilihan_a'] = null;
            $data['pilihan_b'] = null;
            $data['pilihan_c'] = null;
            $data['pilihan_d'] = null;
            $data['kunci_jawaban'] = null;
        }
        return $this->db->where('id_soal', $id_soal)
                       ->update('bank_soal', $data);
    }

    public function hapus_soal($id_soal) {
        return $this->db->where('id_soal', $id_soal)
                       ->delete('bank_soal');
    }
    public function hapus_soal_fix($id_soal)
{
    // 1. Cek apakah soal sudah dipakai di ujian_soal
    $dipakaiUjian = $this->db->where('bank_soal_id', $id_soal)
                             ->count_all_results('ujian_soal');

    // 2. Cek apakah soal sudah pernah dijawab siswa
    $sudahDijawab = $this->db->where('bank_soal_id', $id_soal)
                             ->count_all_results('tbl_jawaban_siswa');

    if ($dipakaiUjian > 0 || $sudahDijawab > 0) {
        return false; // tidak boleh hapus
    }

    // 3. Hapus kalau aman
    return $this->db->where('id_soal', $id_soal)
                    ->delete('bank_soal');
}

public function get_mapel_by_nips($nip)
{
    $this->db->select('mata_pelajaran.id, mata_pelajaran.nama_mapel');
    $this->db->from('guru_mapel');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru_mapel.id_mapel');
    $this->db->where('guru_mapel.id_guru', $nip);
    return $this->db->get()->result();
}

    public function get_detail_soal($id_soal)
{
    $this->db->select('bank_soal.*, mata_pelajaran.nama_mapel');
    $this->db->from('bank_soal');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = bank_soal.id_mapel', 'left');
    $this->db->where('bank_soal.id_soal', $id_soal);
    return $this->db->get()->row();
}
    // Di Bank_soal_model.php
public function get_soal_for_ujian($ujian_id) {
    return $this->db->select('bank_soal.*')
                   ->from('bank_soal')
                   ->join('ujian_soal', 'ujian_soal.soal_id = bank_soal.id_soal')
                   ->where('ujian_soal.ujian_id', $ujian_id)
                   ->get()
                   ->result();
}

// Di Ujian_model.php
public function get_ujian_with_soal($ujian_id) {
    $ujian = $this->db->get_where('tbl_ujian', ['id_ujian' => $ujian_id])->row();
    if ($ujian) {
        $ujian->soal = $this->Bank_soal_model->get_soal_for_ujian($ujian_id);
    }
    return $ujian;
}
public function filter_soal($mapel, $tingkat = null, $tipe = null, $keyword = null) {
    $this->db->where('mapel_diajarkan', $mapel);
    
    if ($tingkat) $this->db->where('tingkat_kesulitan', $tingkat);
    if ($tipe) $this->db->where('tipe_soal', $tipe);
    if ($keyword) $this->db->like('pertanyaan', $keyword);
    
    return $this->db->get('bank_soal')->result();
}
public function get_soal_acak_for_ujian($ujian_id, $limit = null) {
    $query = $this->db->select('bank_soal.*')
                     ->from('bank_soal')
                     ->join('ujian_soal', 'ujian_soal.soal_id = bank_soal.id_soal')
                     ->where('ujian_soal.ujian_id', $ujian_id)
                     ->order_by('RAND()');
    
    if ($limit) $query->limit($limit);
    
    return $query->get()->result();
}
public function nilai_jawaban($ujian_id, $siswa_id, $jawaban) {
    $soal = $this->get_soal_for_ujian($ujian_id);
    $total_benar = 0;
    
    foreach ($soal as $s) {
        if ($s->tipe_soal == 'pilihan' && isset($jawaban[$s->id_soal])) {
            if ($jawaban[$s->id_soal] == $s->kunci_jawaban) {
                $total_benar++;
            }
        }
    }
    
    $nilai = ($total_benar / count($soal)) * 100;
    
    // Simpan hasil
    $this->db->insert('hasil_ujian', [
        'ujian_id' => $ujian_id,
        'siswa_id' => $siswa_id,
        'nilai' => $nilai,
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    return $nilai;
}
}