<?php

class M_guru extends CI_Model
{
public function get_paginated($limit, $start, $filters = [])
{
    $this->db->select('guru.nip, guru.nama_guru, guru.email, GROUP_CONCAT(mata_pelajaran.nama_mapel SEPARATOR ", ") as mapel_diajar');
    $this->db->from('guru');
    $this->db->join('guru_mapel', 'guru_mapel.id_guru = guru.nip', 'left');
    $this->db->join('mata_pelajaran', 'guru_mapel.id_mapel = mata_pelajaran.id', 'left');
    
    // Filter keyword (nama_guru / nip)
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('guru.nip', $filters['keyword']);
        $this->db->or_like('guru.email', $filters['keyword']);
        $this->db->group_end();
    }
    
    $this->db->group_by('guru.nip');
    $this->db->limit($limit, $start);
    return $this->db->get()->result();
}

public function count_all($filters = [])
{
    // Gunakan query manual untuk menghindari duplicate column issues
    $this->db->select('COUNT(DISTINCT guru.nip) as total');
    $this->db->from('guru');
    $this->db->join('guru_mapel', 'guru_mapel.id_guru = guru.nip', 'left');
    $this->db->join('mata_pelajaran', 'guru_mapel.id_mapel = mata_pelajaran.id', 'left');
    
    // Filter keyword (nama_guru / nip)
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('guru.nip', $filters['keyword']);
        $this->db->or_like('guru.email', $filters['keyword']);
        $this->db->group_end();
    }
    
    $query = $this->db->get();
    return $query->row()->total;
}

// Method alternatif yang lebih aman
public function count_all_alternative($filters = [])
{
    // Subquery untuk menghindari duplicate column
    $this->db->select('guru.nip');
    $this->db->from('guru');
    $this->db->join('guru_mapel', 'guru_mapel.id_guru = guru.nip', 'left');
    $this->db->join('mata_pelajaran', 'guru_mapel.id_mapel = mata_pelajaran.id', 'left');
    
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('guru.nip', $filters['keyword']);
        $this->db->or_like('guru.email', $filters['keyword']);
        $this->db->group_end();
    }
    
    $this->db->group_by('guru.nip');
    $subquery = $this->db->get_compiled_select();
    
    // Hitung total dari subquery
    $query = $this->db->query("SELECT COUNT(*) as total FROM ($subquery) as counted");
    return $query->row()->total;
}

// Method lama tetap dipertahankan
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
