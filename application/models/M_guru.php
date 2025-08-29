<?php

class M_guru extends CI_Model
{
    public function tampil_data()
    {
        $this->db->select('guru.nip, guru.nama_guru, guru.email, GROUP_CONCAT(mata_pelajaran.nama_mapel SEPARATOR ", ") as mapel_diajar');
        $this->db->from('guru');
        $this->db->join('guru_mapel', 'guru_mapel.id_guru = guru.nip', 'left');
        $this->db->join('mata_pelajaran', 'guru_mapel.id_mapel = mata_pelajaran.id', 'left');
        $this->db->group_by('guru.nip');
        return $this->db->get();
    }

public function detail_guru($nip = null)
{
    $this->db->select('guru.*, GROUP_CONCAT(mata_pelajaran.nama_mapel SEPARATOR ", ") as mapel_diajar');
    $this->db->from('guru');
    $this->db->join('guru_mapel', 'guru.nip = guru_mapel.id_guru', 'left');
    $this->db->join('mata_pelajaran', 'guru_mapel.id_mapel = mata_pelajaran.id', 'left');
    $this->db->where('guru.nip', $nip);
    $this->db->group_by('guru.nip');
    return $this->db->get()->row(); // ambil 1 baris (detail)
}


    public function delete_guru($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    // Di file application/models/M_guru.php
public function get_guru_by_nip($nip) {
    return $this->db->get_where('guru', ['nip' => $nip])->row(); 
    // pakai row() biar 1 objek, bukan array
}

    public function update_guru($where, $table)
    {
        return $this->db->get_where($table, $where);
    }

    public function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    public function is_owner($id_materi, $id_guru) {
        return $this->db->where('id', $id_materi)
                       ->where('id_guru', $id_guru)
                       ->get('materi')
                       ->num_rows() > 0;
    }

    // Update materi dengan validasi pemilik
    public function update_materi($id_materi, $id_guru, $data) {
        $this->db->where('id', $id_materi)
                ->where('id_guru', $id_guru)
                ->update('materi', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Get materi by id dengan validasi pemilik
    public function get_materi_by_owner($id_materi, $id_guru) {
        return $this->db->where('id', $id_materi)
                      ->where('id_guru', $id_guru)
                      ->get('materi')
                      ->row();
    }
}
