<?php

class M_materi extends CI_Model
{
    public function tampil_data()
    {
        $this->db->select('materi.*, guru.nama_guru, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->from('materi');
        $this->db->join('guru', 'materi.id_guru = guru.nip', 'left');
        $this->db->join('mata_pelajaran', 'materi.id_mapel = mata_pelajaran.id', 'left');
        $this->db->join('kelas', 'materi.id_kelas = kelas.id', 'left');

        return $this->db->get();
    }
    public function tampil_materi_guru($nip)
    {
        $this->db->select('materi.*, mata_pelajaran.nama_mapel, kelas.nama_kelas, pertemuan.id AS id_pertemuan');
        $this->db->from('materi');
        $this->db->join('mata_pelajaran', 'materi.id_mapel = mata_pelajaran.id');
        $this->db->join('kelas', 'materi.id_kelas = kelas.id');
        $this->db->join('pertemuan', 'pertemuan.id_materi = materi.id', 'left');
        $this->db->where('materi.id_guru', $nip);
        return $this->db->get()->result();
    }
    public function get_detail_guru($nip) {
        $this->db->select('guru.*, mata_pelajaran.nama_mapel, kelas.nama_kelas');
        $this->db->from('guru');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru.id_mapel', 'left');
        $this->db->join('materi', 'materi.id_guru = guru.nip', 'left');
        $this->db->join('kelas', 'kelas.id = materi.id_kelas', 'left');
        $this->db->where('guru.nip', $nip);
        $this->db->group_by('guru.nip');
        return $this->db->get()->row_array();
    }
    public function is_pertemuan_terpakai($id_mapel, $id_kelas, $pertemuan_ke, $id_guru)
    {
        $this->db->select('pertemuan.id');
        $this->db->from('pertemuan');
        $this->db->join('materi', 'materi.id = pertemuan.id_materi');
        $this->db->where([
            'pertemuan.pertemuan_ke' => $pertemuan_ke,
            'materi.id_kelas'        => $id_kelas,
            'materi.id_mapel'        => $id_mapel,
            'materi.id_guru'         => $id_guru
        ]);
        return $this->db->get()->row() ? true : false;
    }



    public function belajar($id = null, $materi_id)
    {
        $query = $this->db->get_where('materi', array('id' => $id))->row();
        return $query;

        return $this->db->get_where('materi', ['id' => $materi_id]);
    }
public function get_materi_by_id($id)
{
    $this->db->select('
        materi.*,
        guru.nama_guru, guru.nip,
        mata_pelajaran.nama_mapel,
        kelas.nama_kelas,
        pertemuan.id AS id_pertemuan,
        pertemuan.pertemuan_ke,
        pertemuan.tanggal
    ');
    $this->db->from('materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->join('pertemuan', 'pertemuan.id_materi = materi.id', 'left');
    $this->db->where('materi.id', $id);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row(); // object
    }

    return null;
}

public function get_materi_by_ids($id)
{
    $this->db->select('materi.*, 
                       mata_pelajaran.nama_mapel, 
                       kelas.nama_kelas, 
                       guru.nama_guru, pertemuan.pertemuan_ke');
    $this->db->from('materi');
    $this->db->join('mata_pelajaran', 'materi.id_mapel = mata_pelajaran.id', 'left');
    $this->db->join('kelas', 'materi.id_kelas = kelas.id', 'left');
    $this->db->join('guru', 'materi.id_guru = guru.nip', 'left');
    $this->db->join('pertemuan', 'pertemuan.id_materi = materi.id', 'left');
    $this->db->where('materi.id', $id);
    return $this->db->get()->row(); // jika hanya 1 data
}

public function get_all_materi_idd()
{
    $this->db->select('materi.*, 
                       pertemuan.id AS id_pertemuan, 
                       pertemuan.pertemuan_ke, 
                       pertemuan.tanggal,
                       kelas.nama_kelas, 
                       mata_pelajaran.nama_mapel, 
                       guru.nama_guru');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');
    $this->db->join('guru', 'guru.nip = materi.id_guru', 'left');
    return $this->db->get()->result(); // ✅ Kembalikan semua data
}
public function get_all_materi_id($nip)
{
    $this->db->select('materi.*, 
                       pertemuan.id AS id_pertemuan, 
                       pertemuan.pertemuan_ke, 
                       pertemuan.tanggal,
                       kelas.nama_kelas, 
                       mata_pelajaran.nama_mapel, 
                       guru.nama_guru');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');
    $this->db->join('guru', 'guru.nip = materi.id_guru', 'left');
    $this->db->where('materi.id_guru', $nip);
    return $this->db->get()->result(); // ✅ Kembalikan semua data
}
public function get_materi_by_pertemuan($id_pertemuan)
{
    $this->db->select('materi.*, 
                       pertemuan.id AS id_pertemuan, 
                       pertemuan.pertemuan_ke, 
                       pertemuan.tanggal,
                       kelas.nama_kelas, 
                       mata_pelajaran.nama_mapel, 
                       guru.nama_guru');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');
    $this->db->join('guru', 'guru.nip = materi.id_guru', 'left');
    $this->db->where('pertemuan.id', $id_pertemuan);
    return $this->db->get()->row(); // hanya satu baris
}



    public function detail_materi($id = null)
    {
        $query = $this->db->get_where('materi', array('id' => $id))->row();
        return $query;
    }

    public function delete_materi($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function get_all_materi() {
    $this->db->select('materi.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_guru');
    $this->db->from('materi');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->order_by('kelas.nama_kelas', 'asc');
    $this->db->order_by('mata_pelajaran.nama_mapel', 'asc');
    return $this->db->get()->result();
}


    public function update_materi($where, $table)
    {
        return $this->db->get_where($table, $where);
    }
    public function update_matery($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('materi', $data);
}

    public function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    public function delete_data($where, $table)
{
    $this->db->where($where);
    $this->db->delete($table);
}

}
