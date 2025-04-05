<?php

class M_guru extends CI_Model
{
    public function tampil_data()
    {
        return $this->db->get('guru');
    }

    public function detail_guru($nip = null)
    {
        $query = $this->db->get_where('guru', array('nip' => $nip))->row();
        return $query;
    }

    public function delete_guru($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
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
