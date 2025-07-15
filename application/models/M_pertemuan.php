<?php
class M_pertemuan extends CI_Model
{
    public function get_materi_by_guru($nip)
    {
        $this->db->select('materi.*, mata_pelajaran.nama_mapel');
        $this->db->from('materi');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
        $this->db->where('materi.id_guru', $nip);
        return $this->db->get()->result();
    }

    public function insert_pertemuan($data)
    {
        return $this->db->insert('pertemuan', $data);
    }
    public function get_all_kelas()
    {
        return $this->db->get('kelas')->result();
    }
}
