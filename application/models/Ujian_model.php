<?php
class Ujian_model extends CI_Model {

    public function get_active_ujian()
    {
        $today = date('Y-m-d');
        $this->db->where('tanggal_mulai <=', $today);
        $this->db->where('tanggal_selesai >=', $today);
        $this->db->where('status', 'aktif');
        return $this->db->get('tbl_ujian')->row();
    }

    public function get_soal($id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        return $this->db->get('tbl_soal')->result();
    }

    public function simpan_jawaban($id_soal, $jawaban, $ragu)
    {
        $data = [
            'nis' => $this->session->userdata('nis'), // pakai nis
            'id_ujian' => $this->session->userdata('ujian_id'),
            'id_soal' => $id_soal,
            'jawaban' => $jawaban,
            'ragu_ragu' => $ragu
        ];
    
        $cek = $this->db->get_where('tbl_jawaban_siswa', [
            'nis' => $data['nis'],
            'id_ujian' => $data['id_ujian'],
            'id_soal' => $id_soal
        ])->row();
    
        if ($cek) {
            $this->db->where('id_jawaban', $cek->id_jawaban);
            $this->db->update('tbl_jawaban_siswa', $data);
        } else {
            $this->db->insert('tbl_jawaban_siswa', $data);
        }
    }
    

    public function selesai_ujian()
    {
        // bisa update status selesai di tabel siswa/ujian kalau mau
    }
    public function get_ujian_by_mapel_and_kelas($kelas_siswa)
{
    // Mengambil ujian yang terkait dengan kelas dari tabel materi
    $this->db->select('tbl_ujian.*');
    $this->db->from('tbl_ujian');
    $this->db->join('materi', 'materi.id = tbl_ujian.id_materi'); // Join dengan tabel materi menggunakan id_materi
    $this->db->where('materi.kelas', $kelas_siswa); // Menggunakan kolom kelas dari tabel materi
    $this->db->where('tbl_ujian.status', 'aktif'); // Pastikan hanya ujian yang aktif yang diambil
    return $this->db->get()->result_array(); // Mengambil hasil sebagai array
}
public function add_soal($data)
    {
        return $this->db->insert('tbl_soal', $data);
    }

    // Mengedit soal
    public function edit_soal($id_soal, $data)
    {
        $this->db->where('id_soal', $id_soal);
        return $this->db->update('tbl_soal', $data);
    }

    // Menghapus soal
    public function delete_soal($id_soal)
    {
        return $this->db->delete('tbl_soal', ['id_soal' => $id_soal]);
    }

    public function tambah_ujian($data)
    {
        // Menyimpan data ujian ke dalam tabel tbl_ujian
        return $this->db->insert('tbl_ujian', $data);
    }

    // Fungsi untuk menambah soal ke dalam ujian
    public function tambah_soal($data)
    {
        // Menyimpan soal ke dalam tabel tbl_soal
        return $this->db->insert('tbl_soal', $data);
    }

    // Fungsi untuk mendapatkan soal berdasarkan id_ujian
    public function get_soal_by_ujian_G($id_ujian)
    {
        $this->db->where('id_ujian', $id_ujian);
        return $this->db->get('tbl_soal')->result_array();
    }
    public function get_soal_by_ujian($id_ujian)
    {
        return $this->db->get_where('tbl_soal', ['id_ujian' => $id_ujian])->result();
    }
    
    // Mendapatkan soal tertentu berdasarkan ID soal
    public function get_soal_by_id($id_soal)
    {
        return $this->db->get_where('tbl_soal', ['id_soal' => $id_soal])->row_array();
    }
    public function get_ujian_by_guru($nip)
    {
        $this->db->select('tbl_ujian.*, materi.nama_mapel');
        $this->db->from('tbl_ujian');
        $this->db->join('materi', 'materi.id = tbl_ujian.id_materi');
        $this->db->where('materi.id_guru', $nip);  // Menambahkan filter berdasarkan nip guru
        return $this->db->get()->result_array();  // Mengambil hasil sebagai array
    }
    public function get_materi_options($nip) {
        $this->db->select('id, deskripsi, kelas, nama_mapel');
        $this->db->from('materi');
        $this->db->where('id_guru', $nip);
        return $this->db->get()->result();
    }
    // Ambil data ujian berdasarkan id
public function get_ujian_by_id($id_ujian)
{
    $this->db->where('id_ujian', $id_ujian);
    $query = $this->db->get('tbl_ujian');
    return $query->row_array();  // Mengambil satu hasil sebagai array
}
public function get_ujian_by_idS($id_ujian)
{
    return $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();
}


// Update data ujian
public function update_ujian($id_ujian, $data)
{
    $this->db->where('id_ujian', $id_ujian);
    $this->db->update('tbl_ujian', $data);  // Memperbarui data berdasarkan id_ujian
}

}
