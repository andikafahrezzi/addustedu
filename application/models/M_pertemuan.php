<?php
class M_pertemuan extends CI_Model
{
public function get_all_materi()
{
    $this->db->select('materi.*, mata_pelajaran.nama_mapel, kelas.nama_kelas, guru.nama_guru');
    $this->db->from('materi');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
    $this->db->join('kelas', 'kelas.id = materi.id_kelas');
    $this->db->join('guru', 'guru.nip = materi.id_guru', 'left'); // optional
    $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
    return $this->db->get()->result();
}
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
public function delete_ptm_admin($id)
{
    // Hapus turunan dulu
    $this->db->where('id_pertemuan', $id)->delete('quiz');
    $this->db->where('id_pertemuan', $id)->delete('forum_diskusi');
    $this->db->where('id_pertemuan', $id)->delete('tugas_siswa');
    $this->db->where('id_pertemuan', $id)->delete('tbl_ujian');

    // Terakhir hapus pertemuan
    $this->db->where('id', $id)->delete('pertemuan');
}




public function get_pertemuan_by_guru($nip) {
        $this->db->select('p.*, m.deskripsi, m.video, mp.nama_mapel, k.nama_kelas');
        $this->db->from('pertemuan p');
        $this->db->join('materi m', 'm.id = p.id_materi');
        $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
        $this->db->join('kelas k', 'k.id = p.id_kelas');
        $this->db->where('m.id_guru', $nip);
        $this->db->order_by('p.tanggal', 'DESC');
        return $this->db->get()->result();
    }
    
    // Get materi by guru untuk dropdown
    public function get_materi_by_gurus($nip) {
        $this->db->select('m.*, mp.nama_mapel, k.nama_kelas');
        $this->db->from('materi m');
        $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
        $this->db->join('kelas k', 'k.id = m.id_kelas');
        $this->db->where('m.id_guru', $nip);
        $this->db->order_by('mp.nama_mapel', 'ASC');
        return $this->db->get()->result();
    }

    // Get next pertemuan number
    public function get_next_pertemuan($id_materi) {
        $this->db->select_max('pertemuan_ke');
        $this->db->where('id_materi', $id_materi);
        $result = $this->db->get('pertemuan')->row();
        return $result ? $result->pertemuan_ke + 1 : 1;
    }

    // Get kelas by materi
    public function get_kelas_by_materi($id_materi) {
        $this->db->select('k.id, k.nama_kelas');
        $this->db->from('materi m');
        $this->db->join('kelas k', 'k.id = m.id_kelas');
        $this->db->where('m.id', $id_materi);
        return $this->db->get()->row();
    }

    // Add pertemuan
    public function add_pertemuan($data) {
        return $this->db->insert('pertemuan', $data);
    }

    // Get pertemuan by ID
public function get_pertemuan_by_id($id)
{
    return $this->db
        ->select('p.id, p.id_materi, p.id_kelas, p.pertemuan_ke, p.tanggal, p.id_guru, 
                  m.deskripsi, mp.nama_mapel, k.nama_kelas')
        ->from('pertemuan p')
        ->join('materi m', 'm.id = p.id_materi')
        ->join('mata_pelajaran mp', 'mp.id = m.id_mapel')
        ->join('kelas k', 'k.id = p.id_kelas')
        ->where('p.id', $id)
        ->get()
        ->row();
}


    // Update pertemuan
    public function update_pertemuan($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('pertemuan', $data);
    }

    // Delete pertemuan
    public function delete_pertemuan($id) {
        // Hapus forum diskusi terkait
        $this->db->where('id_pertemuan', $id);
        $this->db->delete('forum_diskusi');
        
        // Hapus tugas siswa terkait
        $this->db->where('id_pertemuan', $id);
        $this->db->delete('tugas_siswa');
        
        // Hapus pertemuan
        $this->db->where('id', $id);
        return $this->db->delete('pertemuan');
    }
public function get_pertemuan_paginated($nip, $limit, $offset, $filters = [])
{
    $this->db->select('p.*, m.deskripsi, 
                       k.nama_kelas, mp.nama_mapel, g.nama_guru');
    $this->db->from('pertemuan p');
    $this->db->join('materi m', 'm.id = p.id_materi');
    $this->db->join('kelas k', 'k.id = p.id_kelas');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->join('guru g', 'g.nip = m.id_guru');
    
    // filter: pertemuan yang ditambahkan oleh guru login
    $this->db->where('p.id_guru', $nip);

    // filter tambahan
    if (!empty($filters['mapel'])) {
        $this->db->where('m.id_mapel', $filters['mapel']);
    }
    if (!empty($filters['kelas'])) {
        $this->db->where('p.id_kelas', $filters['kelas']);
    }
    if (!empty($filters['keyword'])) {
        $this->db->like('m.judul', $filters['keyword']);
    }

    $this->db->order_by('mp.nama_mapel', 'ASC');
    $this->db->order_by('p.pertemuan_ke', 'ASC');
    $this->db->limit($limit, $offset);

    return $this->db->get()->result();
}

public function count_pertemuan($nip, $filters = [])
{
    $this->db->from('pertemuan p');
    $this->db->join('materi m', 'm.id = p.id_materi');

    $this->db->where('p.id_guru', $nip); // sekarang pakai guru pertemuan

    if (!empty($filters['mapel'])) {
        $this->db->where('m.id_mapel', $filters['mapel']);
    }
    if (!empty($filters['kelas'])) {
        $this->db->where('p.id_kelas', $filters['kelas']);
    }
    if (!empty($filters['keyword'])) {
        $this->db->like('m.judul', $filters['keyword']);
    }

    return $this->db->count_all_results();
}


public function check_pertemuan_dependencies($id_pertemuan) {
    $dependencies = [];
    
    // Check quiz
    $this->db->where('id_pertemuan', $id_pertemuan);
    $quiz_count = $this->db->count_all_results('quiz');
    if ($quiz_count > 0) {
        $dependencies[] = "Quiz ($quiz_count)";
    }
    
    // Check tugas
    $this->db->where('id_pertemuan', $id_pertemuan);
    $tugas_count = $this->db->count_all_results('tugas_siswa');
    if ($tugas_count > 0) {
        $dependencies[] = "Tugas ($tugas_count)";
    }
    
    // Check forum
    $this->db->where('id_pertemuan', $id_pertemuan);
    $forum_count = $this->db->count_all_results('forum_diskusi');
    if ($forum_count > 0) {
        $dependencies[] = "Komentar ($forum_count)";
    }
    
    // Check ujian
    $this->db->where('id_pertemuan', $id_pertemuan);
    $ujian_count = $this->db->count_all_results('tbl_ujian');
    if ($ujian_count > 0) {
        $dependencies[] = "Ujian ($ujian_count)";
    }
    
    return $dependencies;
}


public function get_mapel_by_guru($nip) {
    $this->db->select('DISTINCT(mp.id), mp.nama_mapel');
    $this->db->from('materi m');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->where('m.id_guru', $nip);
    $this->db->order_by('mp.nama_mapel', 'ASC');
    return $this->db->get()->result();
}

public function get_kelas_by_guru($nip) {
    $this->db->select('DISTINCT(k.id), k.nama_kelas');
    $this->db->from('materi m');
    $this->db->join('kelas k', 'k.id = m.id_kelas');
    $this->db->where('m.id_guru', $nip);
    $this->db->order_by('k.nama_kelas', 'ASC');
    return $this->db->get()->result();
}
public function get_materi_by_mapel_kelas($nip, $id_mapel, $id_kelas) {
    $this->db->select('m.id, m.deskripsi, mp.nama_mapel, k.nama_kelas');
    $this->db->from('materi m');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->join('kelas k', 'k.id = m.id_kelas');
    $this->db->where('m.id_guru', $nip);
    $this->db->where('m.id_mapel', $id_mapel);
    $this->db->where('m.id_kelas', $id_kelas);
    $this->db->order_by('m.deskripsi', 'ASC');
    
    $result = $this->db->get()->result();
    
    // Debug: Log query
    error_log("Query: " . $this->db->last_query());
    error_log("Result count: " . count($result));
    
    return $result;
}
public function cek_pertemuan_duplikat($id_kelas, $id_mapel, $pertemuan_ke, $id = null)
{
    $this->db->from('pertemuan');
    $this->db->where([
        'id_kelas' => $id_kelas,
        'id_mapel' => $id_mapel,
        'pertemuan_ke' => $pertemuan_ke
    ]);

    if ($id) { // kalau edit, exclude id sekarang
        $this->db->where('id !=', $id);
    }

    return $this->db->count_all_results() > 0;
}

public function get_materi_by_mapel($id_mapel, $nip)
{
    $this->db->select('m.*, k.nama_kelas, mp.nama_mapel');
    $this->db->from('materi m');
    $this->db->join('kelas k', 'k.id = m.id_kelas');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->where('m.id_guru', $nip);
    $this->db->where('m.id_mapel', $id_mapel);
    return $this->db->get()->result();
}
public function is_materi_valid($id_materi, $id_mapel, $id_kelas, $nip)
{
    $this->db->where('id', $id_materi);
    $this->db->where('id_mapel', $id_mapel);
    $this->db->where('id_kelas', $id_kelas);
    $this->db->where('id_guru', $nip);
    $q = $this->db->get('materi');
    return $q->num_rows() > 0;
}

public function is_pertemuan_exists($id_mapel, $id_kelas, $pertemuan_ke, $id_guru, $exclude_id = null)
{
    $this->db->from('pertemuan p');
    $this->db->join('materi m', 'm.id = p.id_materi');
    $this->db->where('m.id_mapel', $id_mapel);
    $this->db->where('p.id_kelas', $id_kelas);
    $this->db->where('p.pertemuan_ke', $pertemuan_ke);
    $this->db->where('p.id_guru', $id_guru);

    if ($exclude_id) {
        $this->db->where('p.id !=', $exclude_id); // biar tidak bentrok dengan dirinya sendiri
    }

    return $this->db->count_all_results() > 0;
}
    public function get_pertemuan_grouped()
    {
        $this->db->select('
            p.id AS id,
            p.pertemuan_ke,
            p.tanggal,
            p.id_materi,
            p.id_kelas,
            p.id_guru,
            m.deskripsi AS deskripsi,
            mp.nama_mapel,
            k.nama_kelas,
            k.tingkat,
            g.nama_guru
        ');
        $this->db->from('pertemuan p');
        $this->db->join('materi m', 'm.id = p.id_materi', 'left');
        $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel', 'left');
        $this->db->join('kelas k', 'k.id = p.id_kelas', 'left');
        $this->db->join('guru g', 'g.nip = p.id_guru', 'left');

        $this->db->order_by('g.nama_guru', 'ASC');
        $this->db->order_by('mp.nama_mapel', 'ASC');
        $this->db->order_by('k.tingkat', 'ASC');
        $this->db->order_by('k.nama_kelas', 'ASC');
        $this->db->order_by('p.pertemuan_ke', 'ASC');

        $rows = $this->db->get()->result();

        $result = [];
        foreach ($rows as $r) {
            // pastikan index ada
            $nama_guru = $r->nama_guru ?? 'Unknown';
            $nama_mapel = $r->nama_mapel ?? 'Umum';
            $tingkat = $r->tingkat ?? ' - ';
            $nama_kelas = $r->nama_kelas ?? ' - ';
            $result[$nama_guru][$nama_mapel][$tingkat][$nama_kelas][] = $r;
        }

        return $result;
    }

    // 2) ambil pertemuan by id (satu record) — return object
    public function get_pertemuan_by_ids($id)
    {
        return $this->db
            ->select('p.id, p.pertemuan_ke, p.tanggal, p.id_materi, p.id_kelas, p.id_guru, m.deskripsi, mp.nama_mapel, k.nama_kelas, k.tingkat, g.nama_guru')
            ->from('pertemuan p')
            ->join('materi m', 'm.id = p.id_materi', 'left')
            ->join('mata_pelajaran mp', 'mp.id = m.id_mapel', 'left')
            ->join('kelas k', 'k.id = p.id_kelas', 'left')
            ->join('guru g', 'g.nip = p.id_guru', 'left')
            ->where('p.id', $id)
            ->get()
            ->row();
    }

    // 3) hapus pertemuan beserta child yang terhubung (hanya child yg berhubungan langsung dengan id_pertemuan)
    public function delete_pertemuan_cascade($id_pertemuan)
    {
        // safety: pastikan id numeric
        if (!is_numeric($id_pertemuan)) {
            return false;
        }

        $this->db->trans_start();

        // --- QUIZ ---
        if ($this->db->table_exists('quiz')) {
            // ambil semua quiz id untuk pertemuan ini
            $quizzes = $this->db->select('id')->get_where('quiz', ['id_pertemuan' => $id_pertemuan])->result();
            foreach ($quizzes as $q) {
                $quiz_id = $q->id;

                // hapus jawaban_siswa yang mengacu ke quiz_siswa milik quiz ini
                if ($this->db->table_exists('quiz_siswa') && $this->db->table_exists('jawaban_siswa')) {
                    $qs_ids = $this->db->select('id')->get_where('quiz_siswa', ['quiz_id' => $quiz_id])->result();
                    if (!empty($qs_ids)) {
                        $ids = array_column($qs_ids, 'id');
                        $this->db->where_in('quiz_siswa_id', $ids)->delete('jawaban_siswa');
                    }
                }

                // hapus quiz_siswa
                if ($this->db->table_exists('quiz_siswa')) {
                    $this->db->delete('quiz_siswa', ['quiz_id' => $quiz_id]);
                }

                // hapus quiz_questions
                if ($this->db->table_exists('quiz_questions')) {
                    $this->db->delete('quiz_questions', ['quiz_id' => $quiz_id]);
                }

                // hapus quiz itu sendiri (per quiz)
                $this->db->delete('quiz', ['id' => $quiz_id]);
            }
        }

        // --- UJIAN (tbl_ujian) ---
        if ($this->db->table_exists('tbl_ujian')) {
            $ujian_rows = $this->db->select('id_ujian')->get_where('tbl_ujian', ['id_pertemuan' => $id_pertemuan])->result();
            $ujian_ids = array_column($ujian_rows, 'id_ujian');
            if (!empty($ujian_ids)) {
                if ($this->db->table_exists('tbl_jawaban_siswa')) {
                    $this->db->where_in('id_ujian', $ujian_ids)->delete('tbl_jawaban_siswa');
                }
                if ($this->db->table_exists('tbl_soal')) {
                    $this->db->where_in('id_ujian', $ujian_ids)->delete('tbl_soal');
                }
                // hapus tbl_ujian
                $this->db->where_in('id_ujian', $ujian_ids)->delete('tbl_ujian');
            }
        }

        // --- TUGAS SISWA ---
        if ($this->db->table_exists('tugas_siswa')) {
            $this->db->delete('tugas_siswa', ['id_pertemuan' => $id_pertemuan]);
        }

        // --- FORUM DISKUSI + komentar ---
        if ($this->db->table_exists('forum_diskusi')) {
            $forum_rows = $this->db->select('id')->get_where('forum_diskusi', ['id_pertemuan' => $id_pertemuan])->result();
            $forum_ids = array_column($forum_rows, 'id');
            if (!empty($forum_ids) && $this->db->table_exists('komentar_forum')) {
                $this->db->where_in('id_forum', $forum_ids)->delete('komentar_forum');
            }
            // hapus forum_diskusi
            $this->db->delete('forum_diskusi', ['id_pertemuan' => $id_pertemuan]);
        }

        // --- TERAKHIR: HAPUS PERTEMUAN (gunakan kolom primary key 'id') ---
        $this->db->delete('pertemuan', ['id' => $id_pertemuan]);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }


}