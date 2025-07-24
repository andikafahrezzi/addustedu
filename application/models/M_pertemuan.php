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
    public function get_by_id($id_pertemuan) {
        return $this->db->get_where('pertemuan', ['id' => $id_pertemuan])->row();
    }

    public function update($id_pertemuan, $data) {
        $this->db->where('id', $id_pertemuan);
        return $this->db->update('pertemuan', $data);
    }

    public function delete($id_pertemuan) {
        $this->db->where('id', $id_pertemuan);
        return $this->db->delete('pertemuan');
    }
}
