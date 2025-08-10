<?php

class M_siswa extends CI_Model
{
    public function tampil_data()
    {
        return $this->db->get('siswa');
    }

public function detail_siswa($id = null)
{
    $this->db->select('siswa.*, kelas.nama_kelas');
    $this->db->from('siswa');
    $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left'); 
    $this->db->where('siswa.nis', $id);
    return $this->db->get()->row();
}


    public function kelas_siswa ($kelas = null)
    {
        $query = $this->db->get_where('siswa', array('kelas' => $kelas))->row();
        return $query;
    }

    public function delete_siswa($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function update_siswa($where, $table)
    {
        return $this->db->get_where($table, $where);
    }
    public function get_siswa_by_nis($nis)
{
    return $this->db->get_where('siswa', ['nis' => $nis])->row();
}

public function get_by_nis($nis) {
    return $this->db->get_where('siswa', ['nis' => $nis])->row();
}

public function get_by_nip($nip) {
    return $this->db->get_where('guru', ['nip' => $nip])->row();
}

public function update_profile_guru($nip, $data) {
    $this->db->where('nip', $nip);
    return $this->db->update('guru', $data);
}
public function update_profile($nis, $data) {
    $this->db->where('nis', $nis);
    return $this->db->update('siswa', $data);
}

public function update($nis, $data)
{
    $this->db->where('nis', $nis);
    return $this->db->update('siswa', $data);
}


    public function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    public function import_data($data) {
        $this->db->trans_start();
        
        // Cek duplikat NIS
        $nises = array_column($data, 'nis');
        $existing = $this->db->select('nis')
                            ->where_in('nis', $nises)
                            ->get('siswa')
                            ->result_array();
        
        if (!empty($existing)) {
            $existing_nis = array_column($existing, 'nis');
            $data = array_filter($data, function($item) use ($existing_nis) {
                return !in_array($item['nis'], $existing_nis);
            });
            
            if (empty($data)) {
                $this->db->trans_complete();
                return false;
            }
        }
        
        $this->db->insert_batch('siswa', $data);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
}
