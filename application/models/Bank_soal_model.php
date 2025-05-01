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
        return $this->db->insert('bank_soal', $data);
    }

    public function update_soal($id_soal, $data) {
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
}