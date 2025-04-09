<?php

class M_siswa extends CI_Model
{
    public function tampil_data()
    {
        return $this->db->get('siswa');
    }

    public function detail_siswa($id = null)
    {
        $query = $this->db->get_where('siswa', array('nis' => $id))->row();
        return $query;
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
}
