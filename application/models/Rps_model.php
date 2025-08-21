<?php
class Rps_model extends CI_Model {

    // Ambil daftar mapel yang diajar guru
    public function get_mapel_by_guru($id_guru) {
        $this->db->select('gm.id AS guru_mapel_id, m.nama_mapel');
        $this->db->from('guru_mapel gm');
        $this->db->join('mata_pelajaran m', 'gm.id_mapel = m.id');
        $this->db->where('gm.id_guru', $id_guru);
        return $this->db->get()->result();
    }
    
    public function tampil_rps_guru($id_guru)
    {
        $this->db->select('rps.*, guru_mapel.id AS guru_mapel_id, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->from('rps');
        $this->db->join('guru_mapel', 'rps.guru_mapel_id = guru_mapel.id');
        $this->db->join('mata_pelajaran', 'guru_mapel.id_mapel = mata_pelajaran.id');
        $this->db->join('kelas', 'rps.kelas_id = kelas.id');
        $this->db->where('guru_mapel.id_guru', $id_guru);
        $this->db->order_by('mata_pelajaran.nama_mapel, kelas.nama_kelas, rps.semester', 'ASC');
        return $this->db->get()->result();
    }


    // Ambil semua kelas
    public function get_kelas_list() {
        return $this->db->get('kelas')->result();
    }

    // Simpan RPS
    public function save_rps($guru_mapel_id, $kelas_id, $file_name, $semester) {
        $data = [
            'guru_mapel_id' => $guru_mapel_id,
            'kelas_id' => $kelas_id,
            'file_rps' => $file_name,
            'semester' => $semester,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('rps', $data);
    }

    // Ambil daftar RPS guru
    public function get_rps_by_guru($id_guru) {
        $this->db->select('r.id_rps, r.file_rps, r.semester, m.nama_mapel, k.nama_kelas');
        $this->db->from('rps r');
        $this->db->join('guru_mapel gm', 'r.guru_mapel_id = gm.id');
        $this->db->join('mata_pelajaran m', 'gm.id_mapel = m.id');
        $this->db->join('kelas k', 'r.kelas_id = k.id');
        $this->db->where('gm.id_guru', $id_guru);
        return $this->db->get()->result();
    }
        // Ambil data RPS by id
    public function get_rps($id_rps) {
        return $this->db->get_where('rps', ['id_rps' => $id_rps])->row();
    }

    // Update RPS
    public function update_rps($id_rps, $data) {
        $this->db->where('id_rps', $id_rps);
        return $this->db->update('rps', $data);
    }

    // Hapus RPS
    public function delete_rps($id_rps) {
        $rps = $this->get_rps($id_rps);
        if ($rps && file_exists('./assets/rps_uploads/' . $rps->file_rps)) {
            unlink('./assets/rps_uploads/' . $rps->file_rps);
        }
        $this->db->where('id_rps', $id_rps);
        return $this->db->delete('rps');
    }
}