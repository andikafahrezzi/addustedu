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
    $this->db->select('materi.*, mata_pelajaran.nama_mapel, kelas.nama_kelas, pertemuan.pertemuan_ke, pertemuan.id AS id_pertemuan');
    $this->db->from('materi');
    $this->db->join('guru_mapel', 'materi.id_mapel = guru_mapel.id_mapel'); // join ke relasi guru_mapel
    $this->db->join('mata_pelajaran', 'materi.id_mapel = mata_pelajaran.id');
    $this->db->join('kelas', 'materi.id_kelas = kelas.id');
    $this->db->join('pertemuan', 'pertemuan.id_materi = materi.id', 'left');
    $this->db->where('guru_mapel.id_guru', $nip);  // filter berdasarkan nip di tabel relasi
    $this->db->order_by('mata_pelajaran.nama_mapel, kelas.nama_kelas, pertemuan.pertemuan_ke', 'ASC');
    return $this->db->get()->result();
}


    
    public function get_detail_guru($nip) {
    // Ambil info dasar guru
    $this->db->select('guru.*');
    $this->db->from('guru');
    $this->db->where('guru.nip', $nip);
    $guru = $this->db->get()->row_array();

    // Ambil semua mapel yang diajar guru ini
    $this->db->select('mata_pelajaran.id, mata_pelajaran.nama_mapel');
    $this->db->from('guru_mapel');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru_mapel.id_mapel');
    $this->db->where('guru_mapel.id_guru', $nip);
    $mapel = $this->db->get()->result_array();

    $guru['mapel_diajar'] = $mapel;
    return $guru;
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
    $this->db->select('materi.*, kelas.nama_kelas, kelas.tingkat, mata_pelajaran.nama_mapel, guru.nama_guru, pertemuan.pertemuan_ke, pertemuan.tanggal');
    $this->db->from('materi');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('guru', 'guru.nip = materi.id_guru');

    // INNER JOIN agar hanya ambil materi yang punya pertemuan
    $this->db->join('pertemuan', 'pertemuan.id_materi = materi.id AND pertemuan.id_kelas = kelas.id');

    // Urutkan sesuai permintaan
    $this->db->order_by('guru.nama_guru', 'asc');
    $this->db->order_by('kelas.tingkat', 'asc');
    $this->db->order_by('kelas.nama_kelas', 'asc');
    $this->db->order_by('pertemuan.pertemuan_ke', 'asc');

    return $this->db->get()->result();
}
public function get_materi_terjadwal_grouped()
{
    $this->db->select('materi.*, mata_pelajaran.nama_mapel, guru.nama_guru, kelas.nama_kelas, kelas.tingkat, pertemuan.pertemuan_ke, pertemuan.tanggal');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas'); // kelas dari tabel pertemuan
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('guru', 'guru.nip = materi.id_guru');

    $this->db->order_by('guru.nama_guru');
    $this->db->order_by('kelas.tingkat');
    $this->db->order_by('kelas.nama_kelas');
    $this->db->order_by('pertemuan.pertemuan_ke');

    $query = $this->db->get()->result();

    $result = [];
    foreach ($query as $row) {
        $result[$row->nama_guru][$row->tingkat][$row->nama_kelas][] = $row;
    }

    return $result;
}






    public function update_materi($where)
{
    $this->db->select('materi.*, 
                       guru.nama_guru, guru.nip, 
                       mata_pelajaran.nama_mapel, mata_pelajaran.id as id_mapel,
                       kelas.nama_kelas, kelas.id as id_kelas');
    $this->db->from('materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->where($where);
    return $this->db->get();
}
public function get_pertemuan_grouped()
{
    $this->db->select('pertemuan.*, pertemuan.id AS id_pertemuan, 
                       guru.nama_guru, guru.nip, 
                       mata_pelajaran.nama_mapel, 
                       materi.deskripsi, 
                       kelas.nama_kelas, kelas.tingkat');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');

    // Urutan
    $this->db->order_by('guru.nama_guru', 'ASC');
    $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
    $this->db->order_by('kelas.tingkat', 'ASC');
    $this->db->order_by('kelas.nama_kelas', 'ASC');
    $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');

    $query = $this->db->get()->result();

    // Kelompokkan data: guru → mapel → tingkat → kelas → pertemuan
    $result = [];
    foreach ($query as $row) {
        $result[$row->nama_guru][$row->nama_mapel][$row->tingkat][$row->nama_kelas][] = $row;
    }

    return $result;
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
public function get_all() {
    $this->db->select('materi.*, mata_pelajaran.nama_mapel');
    $this->db->from('materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    return $this->db->get()->result();
}
public function get_by_mapel($id_mapel)
{
    $this->db->select('materi.*, mata_pelajaran.nama_mapel');
    $this->db->from('materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->where('materi.id_mapel', $id_mapel);
    return $this->db->get()->result();
}

public function get_all_kelas() {
    return $this->db->get('kelas')->result();
}
public function insert_kelas($data) {
    return $this->db->insert('kelas', $data);
}

public function get_kelas_by_id($id) {
    return $this->db->get_where('kelas', ['id' => $id])->row();
}

public function update_kelas($id, $data) {
    return $this->db->update('kelas', $data, ['id' => $id]);
}

public function delete_kelas($id) {
    return $this->db->delete('kelas', ['id' => $id]);
}
public function get_all_mapel()
{
    return $this->db->get('mata_pelajaran')->result();
}

public function get_mapel_by_id($id)
{
    return $this->db->get_where('mata_pelajaran', ['id' => $id])->row();
}

public function insert_mapel($data)
{
    return $this->db->insert('mata_pelajaran', $data);
}

public function update_mapel($id, $data)
{
    return $this->db->update('mata_pelajaran', $data, ['id' => $id]);
}

public function delete_mapel($id)
{
    return $this->db->delete('mata_pelajaran', ['id' => $id]);
}

}
