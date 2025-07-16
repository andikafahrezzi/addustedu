<?php
class Tugas_model extends CI_Model {
    // Upload tugas oleh siswa
    public function upload_tugas($data) {
        $this->db->insert('tugas_siswa', $data);
        return $this->db->insert_id();
    }

    // Get tugas siswa by ID
    public function get_tugas_siswa($nis, $id_pertemuan)
{
    return $this->db->get_where('tugas_siswa', [
        'siswa_id' => $nis,
        'id_pertemuan' => $id_pertemuan
    ])->row(); // atau row_array() jika di-view-nya kamu pakai array
}


    // Get semua tugas siswa untuk suatu tugas
    public function get_submissions($materi_id) {
        $this->db->select('tugas_siswa.*, siswa.nama as nama_siswa');
        $this->db->from('tugas_siswa');
        $this->db->join('siswa', 'siswa.nis = tugas_siswa.siswa_id');
        $this->db->where('materi_id', $materi_id);
        return $this->db->get()->result();
    }
    
    public function sudah_dinilai($id) {
        $this->db->where('id', $id);
        $this->db->where_not_in('nilai', [null, '']);
        return $this->db->get('tugas_siswa')->num_rows() > 0;
    }
    
    
    

    // Hapus file tugas
public function delete_tugas($id) {
    $tugas = $this->get_tugas_by_id($id);
    if ($tugas) {
        $file_path = FCPATH . ltrim($tugas->file_path, '/');
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $this->db->delete('tugas_siswa', ['id' => $id]);
        return $this->db->affected_rows() > 0;
    }
    return false;
}



    // Update nilai/catatan oleh guru
    public function update_nilai($id, $data) {
        $data['diupdate_pada'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('tugas_siswa', $data);
    }
    public function get_materi_ids_by_guru($guru_id) {
    $this->db->select('id as materi_id');
    $this->db->from('materi');
    $this->db->where('id_guru', $guru_id);
    return $this->db->get()->result();
}
public function get_tugas_per_materi($materi_id, $guru_id = null) {
    $this->db->select('tugas_siswa.*, siswa.nama as nama_siswa');
    $this->db->from('tugas_siswa');
    $this->db->join('siswa', 'siswa.nis = tugas_siswa.siswa_id');
    $this->db->join('materi', 'materi.id = tugas_siswa.materi_id'); // tambahkan join ke materi
    $this->db->where('tugas_siswa.materi_id', $materi_id);

    if ($guru_id !== null) {
        $this->db->where('materi.id_guru', $guru_id); // filter berdasarkan guru
    }

    $this->db->order_by('dikirim_pada', 'DESC');
    return $this->db->get()->result();
}

    
    public function get_all_materi_ids() {
        return $this->db->distinct()->select('materi_id')->get('tugas_siswa')->result();
    }
    public function get_tugas_by_id($id) {
    return $this->db->get_where('tugas_siswa', ['id' => $id])->row();
}


}