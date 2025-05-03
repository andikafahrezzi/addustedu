<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_soal_model extends CI_Model {

    public function get_all_soal() {
        return $this->db->get('bank_soal')->result();
    }

    public function get_soal_by_mapel($mapel) {
        return $this->db->where('mapel_diajarkan', $mapel)
                      ->order_by('created_at', 'DESC')
                      ->get('bank_soal')
                      ->result();
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
    public function get_kategori() {
        return $this->db->get('kategori_soal')->result();
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

    public function get_detail_soal($id_soal) {
        return $this->db->where('id_soal', $id_soal)
                       ->get('bank_soal')
                       ->row();
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