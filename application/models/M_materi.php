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
public function get_paginated($limit, $start, $filters = [])
{
    $this->db->select('materi.*, guru.nama_guru, mata_pelajaran.nama_mapel, kelas.nama_kelas');
    $this->db->from('materi');
    $this->db->join('guru', 'materi.id_guru = guru.nip', 'left');
    $this->db->join('mata_pelajaran', 'materi.id_mapel = mata_pelajaran.id', 'left');
    $this->db->join('kelas', 'materi.id_kelas = kelas.id', 'left');
    
    // Filter keyword (judul_materi / deskripsi)
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('materi.deskripsi', $filters['keyword']);
        $this->db->or_like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->group_end();
    }
    
    // Filter mapel
    if (!empty($filters['mapel'])) {
        $this->db->where('materi.id_mapel', $filters['mapel']);
    }
    
    // Filter kelas
    if (!empty($filters['kelas'])) {
        $this->db->where('materi.id_kelas', $filters['kelas']);
    }
    
    $this->db->order_by('materi.id', 'desc');
    $this->db->limit($limit, $start);
    return $this->db->get()->result();
}

public function count_all($filters = [])
{
    $this->db->select('COUNT(materi.id) as total');
    $this->db->from('materi');
    $this->db->join('guru', 'materi.id_guru = guru.nip', 'left');
    $this->db->join('mata_pelajaran', 'materi.id_mapel = mata_pelajaran.id', 'left');
    $this->db->join('kelas', 'materi.id_kelas = kelas.id', 'left');
    
    // Filter keyword
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('materi.deskripsi', $filters['keyword']);
        $this->db->or_like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->group_end();
    }
    
    // Filter mapel
    if (!empty($filters['mapel'])) {
        $this->db->where('materi.id_mapel', $filters['mapel']);
    }
    
    // Filter kelas
    if (!empty($filters['kelas'])) {
        $this->db->where('materi.id_kelas', $filters['kelas']);
    }
    
    $query = $this->db->get();
    return $query->row()->total;
}

// Method untuk dropdown filter
public function get_mapel_list()
{
    $this->db->select('id, nama_mapel');
    $this->db->from('mata_pelajaran');
    $this->db->order_by('nama_mapel', 'asc');
    return $this->db->get()->result();
}

public function get_kelas_list()
{
    $this->db->select('id, nama_kelas');
    $this->db->from('kelas');
    $this->db->order_by('nama_kelas', 'asc');
    return $this->db->get()->result();
}

// Method lama tetap dipertahankan


// Method untuk dropdown filter

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

public function get_by_mapel($id_mapel)
{
    $this->db->select('materi.*, mata_pelajaran.nama_mapel');
    $this->db->from('materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->where('materi.id_mapel', $id_mapel);
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
    $this->db->select('
        pertemuan.id, 
        pertemuan.pertemuan_ke,
        pertemuan.tanggal,
        guru.nama_guru, guru.nip, 
        mata_pelajaran.nama_mapel, 
        materi.deskripsi, 
        kelas.nama_kelas, kelas.tingkat
    ');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('guru', 'guru.nip = pertemuan.id_guru'); // ambil langsung dari pertemuan
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
public function get_pertemuan_with_forum()
{
    $this->db->select('
        pertemuan.id AS id_pertemuan,
        pertemuan.pertemuan_ke,
        pertemuan.tanggal,
        guru.nama_guru,
        mata_pelajaran.nama_mapel,
        kelas.nama_kelas,
        materi.deskripsi,
        COUNT(forum_diskusi.id) as total_komentar
    ');
    $this->db->from('forum_diskusi');
    $this->db->join('pertemuan', 'pertemuan.id = forum_diskusi.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    $this->db->group_by('pertemuan.id');
    $this->db->order_by('guru.nama_guru', 'ASC');
    $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
    $this->db->order_by('kelas.nama_kelas', 'ASC');
    $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');

    return $this->db->get()->result();
}
public function get_pertemuan_with_forum_paginated($limit, $start, $filters = [])
{
    $this->db->select('
        pertemuan.id AS id_pertemuan,
        pertemuan.pertemuan_ke,
        pertemuan.tanggal,
        guru.nama_guru,
        mata_pelajaran.nama_mapel,
        kelas.nama_kelas,
        materi.deskripsi,
        COUNT(forum_diskusi.id) as total_komentar
    ');
    $this->db->from('forum_diskusi');
    $this->db->join('pertemuan', 'pertemuan.id = forum_diskusi.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    
    // Filter keyword
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->or_like('materi.deskripsi', $filters['keyword']);
        $this->db->group_end();
    }
    
    // Filter guru
    if (!empty($filters['guru'])) {
        $this->db->where('guru.nip', $filters['guru']);
    }
    
    // Filter mapel
    if (!empty($filters['mapel'])) {
        $this->db->where('mata_pelajaran.id', $filters['mapel']);
    }
    
    // Filter kelas
    if (!empty($filters['kelas'])) {
        $this->db->where('kelas.id', $filters['kelas']);
    }
    
    $this->db->group_by('pertemuan.id');
    $this->db->order_by('guru.nama_guru', 'ASC');
    $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
    $this->db->order_by('kelas.nama_kelas', 'ASC');
    $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');
    $this->db->limit($limit, $start);

    return $this->db->get()->result();
}

public function count_pertemuan_with_forum($filters = [])
{
    $this->db->select('COUNT(DISTINCT pertemuan.id) as total');
    $this->db->from('forum_diskusi');
    $this->db->join('pertemuan', 'pertemuan.id = forum_diskusi.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('guru', 'guru.nip = materi.id_guru');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    
    // Filter keyword
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('guru.nama_guru', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->or_like('materi.deskripsi', $filters['keyword']);
        $this->db->group_end();
    }
    
    // Filter guru
    if (!empty($filters['guru'])) {
        $this->db->where('guru.nip', $filters['guru']);
    }
    
    // Filter mapel
    if (!empty($filters['mapel'])) {
        $this->db->where('mata_pelajaran.id', $filters['mapel']);
    }
    
    // Filter kelas
    if (!empty($filters['kelas'])) {
        $this->db->where('kelas.id', $filters['kelas']);
    }

    $query = $this->db->get();
    return $query->row()->total;
}

// Method untuk dropdown filter
public function get_guru_list()
{
    $this->db->select('nip, nama_guru');
    $this->db->from('guru');
    $this->db->order_by('nama_guru', 'asc');
    return $this->db->get()->result();
}

public function get_mapel_lista()
{
    $this->db->select('id, nama_mapel');
    $this->db->from('mata_pelajaran');
    $this->db->order_by('nama_mapel', 'asc');
    return $this->db->get()->result();
}

public function get_kelas_lista()
{
    $this->db->select('id, nama_kelas');
    $this->db->from('kelas');
    $this->db->order_by('nama_kelas', 'asc');
    return $this->db->get()->result();
}
    public function count_materi($filter_mapel = null, $filter_kelas = null, $keyword = null)
    {
        $this->db->from('materi m');
        $this->db->join('mata_pelajaran mp','mp.id = m.id_mapel','left');
        $this->db->join('kelas k','k.id = m.id_kelas','left');

        if (!empty($filter_mapel)) $this->db->where('m.id_mapel', $filter_mapel);
        if (!empty($filter_kelas)) $this->db->where('m.id_kelas', $filter_kelas);
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('m.judul', $keyword);
            $this->db->or_like('m.deskripsi', $keyword);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    // ambil materi paginated (join guru, mapel, kelas)
    public function get_materi_paginated($limit, $offset, $filter_mapel = null, $filter_kelas = null, $keyword = null)
    {
        $this->db->select('m.*, g.nama_guru, mp.nama_mapel, k.nama_kelas');
        $this->db->from('materi m');
        $this->db->join('guru g','g.nip = m.id_guru','left');
        $this->db->join('mata_pelajaran mp','mp.id = m.id_mapel','left');
        $this->db->join('kelas k','k.id = m.id_kelas','left');

        if (!empty($filter_mapel)) $this->db->where('m.id_mapel', $filter_mapel);
        if (!empty($filter_kelas)) $this->db->where('m.id_kelas', $filter_kelas);
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('m.judul', $keyword);
            $this->db->or_like('m.deskripsi', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('m.id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->select('m.*, g.nama_guru, mp.nama_mapel, k.nama_kelas')
                        ->from('materi m')
                        ->join('guru g','g.nip = m.id_guru','left')
                        ->join('mata_pelajaran mp','mp.id = m.id_mapel','left')
                        ->join('kelas k','k.id = m.id_kelas','left')
                        ->where('m.id', $id)
                        ->get()
                        ->row_array();
    }


    public function get_mapel_listt()
    {
        return $this->db->order_by('nama_mapel','asc')->get('mata_pelajaran')->result_array();
    }

    public function get_kelas_listt()
    {
        return $this->db->order_by('nama_kelas','asc')->get('kelas')->result_array();
    }

    // optional: materi milik guru (untuk dropdown)
    public function get_materi_by_guru($nip)
    {
        return $this->db->where('id_guru', $nip)->order_by('judul','asc')->get('materi')->result_array();
    }
    
    public function count_all_materi($id_guru, $mapel = null, $kelas = null, $search = null) {
    $this->db->from('materi m');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->join('kelas k', 'k.id = m.id_kelas');
    
    // Filter mapel
    if ($mapel) {
        $this->db->where('m.id_mapel', $mapel);
    }
    
    // Filter kelas
    if ($kelas) {
        $this->db->where('m.id_kelas', $kelas);
    }

    // Filter search
    if ($search) {
        $this->db->group_start()
                 ->like('m.deskripsi', $search)
                 ->or_like('mp.nama_mapel', $search)
                 ->or_like('k.nama_kelas', $search)
                 ->group_end();
    }

    return $this->db->count_all_results();
}

public function count_all_materis($mapel = null, $kelas = null, $search = null) {
    $this->db->from('materi m');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->join('kelas k', 'k.id = m.id_kelas');
    
    // Filter mapel
    if ($mapel) {
        $this->db->where('m.id_mapel', $mapel);
    }
    
    // Filter kelas
    if ($kelas) {
        $this->db->where('m.id_kelas', $kelas);
    }

    // Filter search
    if ($search) {
        $this->db->group_start()
                 ->like('m.deskripsi', $search)
                 ->or_like('mp.nama_mapel', $search)
                 ->or_like('k.nama_kelas', $search)
                 ->or_like('m.video', $search)
                 ->group_end();
    }

    return $this->db->count_all_results();
}
public function get_all_materis($limit, $start, $mapel = null, $kelas = null, $search = null) {
    $this->db->select('m.*, mp.nama_mapel, g.nama_guru, k.nama_kelas, g.nip as guru_nip');
    $this->db->from('materi m');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->join('kelas k', 'k.id = m.id_kelas');
    $this->db->join('guru g', 'g.nip = m.id_guru');

    // Filter mapel
    if ($mapel) {
        $this->db->where('m.id_mapel', $mapel);
    }
    
    // Filter kelas
    if ($kelas) {
        $this->db->where('m.id_kelas', $kelas);
    }

    // Filter search
    if ($search) {
        $this->db->group_start()
                 ->like('m.deskripsi', $search)
                 ->or_like('mp.nama_mapel', $search)
                 ->or_like('k.nama_kelas', $search)
                 ->or_like('g.nama_guru', $search)
                 ->or_like('m.video', $search)
                 ->group_end();
    }

    $this->db->limit($limit, $start);
    $this->db->order_by('m.id', 'DESC');

    return $this->db->get()->result_array();
}
    public function get_all_mapels() {
        return $this->db->get('mata_pelajaran')->result_array();
    }
    public function get_all_kelass() {
        return $this->db->get('kelas')->result_array();
    }

}
