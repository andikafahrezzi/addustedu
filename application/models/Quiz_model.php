<?php
class Quiz_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function create_quiz($data)
    {
        $this->db->insert('quiz', $data);
        return $this->db->insert_id();
    }

    public function get_materi_list()
    {
        $this->db->select('pertemuan.id AS id_pertemuan,
                        pertemuan.pertemuan_ke, 
                       mata_pelajaran.nama_mapel, 
                       kelas.nama_kelas, 
                       guru.nama_guru, materi.deskripsi');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('mata_pelajaran', 'materi.id_mapel = mata_pelajaran.id');
    $this->db->join('kelas', 'materi.id_kelas = kelas.id');
    $this->db->join('guru', 'materi.id_guru = guru.nip');
    return $this->db->get()->result();
    }

public function get_quiz_with_questions($quiz_id)
{
    $quiz = $this->db->get_where('quiz', ['id' => $quiz_id])->row();
    
    if ($quiz) {
        // Ambil semua soal
        $quiz->questions = $this->db
            ->get_where('quiz_questions', ['quiz_id' => $quiz_id])
            ->result();

        // 🔀 Jika shuffle_question = 1, acak urutan soal
       if ((int) $quiz->shuffle_questions === 1) {
            shuffle($quiz->questions);
        }


        // Ambil info materi/pertemuan
        $this->db->select('
            pertemuan.id AS id_pertemuan,
            pertemuan.pertemuan_ke,
            pertemuan.tanggal,
            materi.id AS id_materi,
            materi.deskripsi,
            kelas.nama_kelas,
            mata_pelajaran.nama_mapel,
            guru.nama_guru
        ');
        $this->db->from('pertemuan');
        $this->db->join('materi', 'materi.id = pertemuan.id_materi');
        $this->db->join('kelas', 'kelas.id = materi.id_kelas');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');
        $this->db->join('guru', 'guru.nip = materi.id_guru');
        $this->db->where('pertemuan.id', $quiz->id_pertemuan);

        $quiz->materi = $this->db->get()->row();
    }

    return $quiz;
}

    public function tambah_soal($data)
{
    return $this->db->insert('quiz_questions', $data);
}

public function hapus_soal($soal_id)
{
    return $this->db->delete('quiz_questions', ['id' => $soal_id]);
}
public function get_available_quizzes($kelas_siswa)
{
    return $this->db->select('quiz.*, materi.nama_mapel, materi.kelas')
                   ->from('quiz')
                   ->join('materi', 'materi.id = quiz.materi_id')
                   ->where('materi.kelas', $kelas_siswa)
                   ->get()
                   ->result();
}

public function start_quiz($quiz_id, $siswa_id, $waktu_pengerjaan)
{
    $data = [
        'quiz_id' => $quiz_id,
        'siswa_id' => $siswa_id,
        'start_time' => date('Y-m-d H:i:s'),
        'end_time' => date('Y-m-d H:i:s', strtotime("+{$waktu_pengerjaan} minutes")),
        'status' => 'ongoing'
    ];
    
    $this->db->insert('quiz_siswa', $data);
    return $this->db->insert_id();
}

public function submit_answer($data)
{
    $this->db->insert('jawaban_siswa', $data);
}

public function complete_quiz($quiz_siswa_id, $score)
{
    // Update quiz_siswa langsung
    return $this->db->where('id', $quiz_siswa_id)
                    ->update('quiz_siswa', [
                        'end_time' => date('Y-m-d H:i:s'),
                        'status'   => 'completed',
                        'score'    => $score
                    ]);
}

public function get_quiz_siswa($quiz_siswa_id)
{
    return $this->db->get_where('quiz_siswa', ['id' => $quiz_siswa_id])->row();
}

public function get_quiz_result_detail($quiz_siswa_id)
{
    return $this->db->select('
            quiz_siswa.*,
            quiz.judul,
            pertemuan.id AS id_pertemuan,
            materi.id AS id_materi,
            mata_pelajaran.nama_mapel,
            kelas.nama_kelas,
            guru.nama_guru
        ')
        ->from('quiz_siswa')
        ->join('quiz', 'quiz.id = quiz_siswa.quiz_id')
        ->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan')
        ->join('materi', 'materi.id = pertemuan.id_materi')
        ->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel')
        ->join('kelas', 'kelas.id = materi.id_kelas')
        ->join('guru', 'guru.nip = materi.id_guru')
        ->where('quiz_siswa.id', $quiz_siswa_id)
        ->get()
        ->row();
}

public function get_quizzes_by_materi($id_pertemuan)
{
    return $this->db->select('quiz.*, COUNT(quiz_questions.id) as jumlah_soal')
                   ->from('quiz')
                   ->join('quiz_questions', 'quiz_questions.quiz_id = quiz.id', 'left')
                   ->where('quiz.id_pertemuan', $id_pertemuan)
                   ->group_by('quiz.id')
                   ->get()
                   ->result();
}

public function get_quiz_result($quiz_id, $siswa_id)
{
    return $this->db->get_where('quiz_siswa', [
        'quiz_id' => $quiz_id,
        'siswa_id' => $siswa_id
    ])->row();
}
public function hitung_nilai_terakhir($id)
{
    // Hitung total nilai dari jawaban yang sudah dikerjakan
    $this->db->select_sum('poin');
    $this->db->where('id', $id);
    $query = $this->db->get('quiz_questions');
    
    return $query->row()->total_nilai ?? 0; // Return 0 jika tidak ada jawaban
}
public function delete_quizs($id)
{
    $this->db->trans_start();

    // 1. Ambil semua quiz_siswa yang terkait
    $this->db->select('id');
    $this->db->where('quiz_id', $id);
    $quizSiswa = $this->db->get('quiz_siswa')->result();

    // 2. Hapus jawaban_siswa dulu
    if (!empty($quizSiswa)) {
        $ids = array_column($quizSiswa, 'id');
        $this->db->where_in('quiz_siswa_id', $ids);
        $this->db->delete('jawaban_siswa');
    }

    // 3. Hapus quiz_siswa
    $this->db->where('quiz_id', $id);
    $this->db->delete('quiz_siswa');

    // 4. Hapus soal quiz
    $this->db->where('quiz_id', $id);
    $this->db->delete('quiz_questions');

    // 5. Hapus quiz
    $this->db->where('id', $id);
    $this->db->delete('quiz');

    $this->db->trans_complete();

    return $this->db->trans_status();
}

public function tampil_quiz()
{
    $this->db->select('quiz.*, 
                      mata_pelajaran.nama_mapel, 
                      kelas.nama_kelas, 
                      guru.nama_guru,
                      pertemuan.pertemuan_ke');
    $this->db->from('quiz');
    $this->db->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan', 'left');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas', 'left');
    $this->db->join('guru', 'guru.nip = materi.id_guru', 'left');
    $this->db->order_by('quiz.created_at', 'DESC');
    return $this->db->get();
}
public function get_paginated_quiz($limit, $start, $filters = [])
{
    $this->db->select('quiz.*, 
                      mata_pelajaran.nama_mapel, 
                      kelas.nama_kelas, 
                      guru.nama_guru,
                      pertemuan.pertemuan_ke');
    $this->db->from('quiz');
    $this->db->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan', 'left');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas', 'left');
    $this->db->join('guru', 'guru.nip = materi.id_guru', 'left');
    
    // Filter keyword
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('quiz.judul', $filters['keyword']);
        $this->db->or_like('quiz.deskripsi', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->or_like('guru.nama_guru', $filters['keyword']);
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
    
    $this->db->order_by('quiz.created_at', 'DESC');
    $this->db->limit($limit, $start);
    return $this->db->get()->result();
}

public function count_all_quiz($filters = [])
{
    $this->db->select('COUNT(quiz.id) as total');
    $this->db->from('quiz');
    $this->db->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan', 'left');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas', 'left');
    $this->db->join('guru', 'guru.nip = materi.id_guru', 'left');
    
    // Filter keyword
    if (!empty($filters['keyword'])) {
        $this->db->group_start();
        $this->db->like('quiz.judul', $filters['keyword']);
        $this->db->or_like('quiz.deskripsi', $filters['keyword']);
        $this->db->or_like('mata_pelajaran.nama_mapel', $filters['keyword']);
        $this->db->or_like('kelas.nama_kelas', $filters['keyword']);
        $this->db->or_like('guru.nama_guru', $filters['keyword']);
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

public function delete_quiz($id)
{
    // Cek validitas id
    if (!is_numeric($id)) return false;

    // 1️⃣ Hapus semua pertanyaan terkait di quiz_questions
    $this->db->where('quiz_id', $id);
    $this->db->delete('quiz_questions');

    // 2️⃣ Hapus semua quiz_siswa berdasarkan quiz_id
    $quiz_siswa_list = $this->db->get_where('quiz_siswa', ['quiz_id' => $id])->result();
    foreach ($quiz_siswa_list as $qs) {
        $this->db->where('quiz_siswa_id', $qs->id);
        $this->db->delete('jawaban_siswa');
    }
    $this->db->where('quiz_id', $id);
    $this->db->delete('quiz_siswa');

    // 3️⃣ Hapus quiz
    $this->db->where('id', $id);
    $this->db->delete('quiz');

    return true;
}

public function get_quizzes_by_guru($nip) {
    $this->db->select('
        quiz.*, 
        pertemuan.id AS id_pertemuan,
        pertemuan.pertemuan_ke,
        materi.deskripsi AS judul_materi, 
        kelas.tingkat, 
        kelas.nama_kelas, 
        kelas.jurusan,
        mata_pelajaran.nama_mapel
    ');
    $this->db->from('quiz');
    $this->db->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan', 'left');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi', 'left');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');

    // Join ke guru_mapel untuk memastikan guru mengajar mapel quiz ini
    $this->db->join('guru_mapel', 'guru_mapel.id_mapel = materi.id_mapel');

    $this->db->where('guru_mapel.id_guru', $nip);

    // Urutan: mapel -> kelas -> pertemuan_ke
    $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
    $this->db->order_by('kelas.tingkat', 'ASC');
    $this->db->order_by('kelas.nama_kelas', 'ASC');
    $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');

    return $this->db->get()->result();
}



// Get single quiz with ownership check
public function get_quiz_by_guru($id_quiz, $nip) {
    $this->db->select('
        quiz.*, 
        pertemuan.pertemuan_ke, 
        materi.deskripsi AS judul_materi, 
        kelas.nama_kelas, 
        mata_pelajaran.nama_mapel
    ');
    $this->db->from('quiz');
    $this->db->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan', 'left');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi', 'left');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas', 'left');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel', 'left');

    // Asumsikan kamu cek kepemilikan lewat guru_mapel atau materi.id_guru
    $this->db->join('guru_mapel', 'guru_mapel.id_mapel = materi.id_mapel', 'left');

    $this->db->where('quiz.id', $id_quiz);
    $this->db->group_start();
        $this->db->where('materi.id_guru', $nip);
        $this->db->or_where('guru_mapel.id_guru', $nip);
    $this->db->group_end();

    $query = $this->db->get();
    return $query->row();
}


public function get_pesertaquiz($quiz_id, $nip) {
    $this->db->select('quiz_siswa.*, siswa.nama as nama_siswa, kelas.nama_kelas, materi.deskripsi as judul_materi');
    $this->db->from('quiz_siswa');
    $this->db->join('quiz', 'quiz.id = quiz_siswa.quiz_id'); // Join ke quiz dulu
    $this->db->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan'); // Lalu ambil pertemuan
    $this->db->join('materi', 'materi.id = pertemuan.id_materi'); // Lalu ambil materi
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas'); // Lalu ambil kelas
    $this->db->join('siswa', 'siswa.nis = quiz_siswa.siswa_id'); // ambil juga siswa
    $this->db->where('quiz_siswa.quiz_id', $quiz_id);
    $this->db->where('materi.id_guru', $nip); // Batasi hanya untuk guru ini
    return $this->db->get()->result();
}

public function delete_quiz_siswa($id) {
    $this->db->where('quiz_siswa_id', $id);
    $this->db->delete('jawaban_siswa');

    // Baru hapus data quiz_siswa
    $this->db->where('id', $id);
    return $this->db->delete('quiz_siswa');
}



// Create new quiz

// Update quiz with ownership check
public function update_quiz($quiz_id, $nip, $data) {
    // Verifikasi kepemilikan
    $this->db->select('quiz.id');
    $this->db->from('quiz');
    $this->db->join('pertemuan', 'pertemuan.id = quiz.id_pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->where('quiz.id', $quiz_id);
    $this->db->where('materi.id_guru', $nip);
    $quiz = $this->db->get()->row();

    if ($quiz) {
        $this->db->where('id', $quiz_id);
        return $this->db->update('quiz', $data);
    } else {
        return false;
    }
}





// Delete quiz with ownership check
public function delete_quiz_guru($quiz_id, $nip) {
    // First delete related questions and answers
    $this->db->trans_start();
    
    $this->db->query("DELETE jawaban_siswa FROM jawaban_siswa 
                     JOIN quiz_siswa ON jawaban_siswa.quiz_siswa_id = quiz_siswa.id 
                     WHERE quiz_siswa.quiz_id = ?", [$quiz_id]);
                     
    $this->db->where('quiz_id', $quiz_id);
    $this->db->delete('quiz_siswa');
    
    $this->db->where('quiz_id', $quiz_id);
    $this->db->delete('quiz_questions');
    
    // Then delete the quiz
    $this->db->where('id', $quiz_id);
    $this->db->where('materi_id IN (SELECT id FROM materi WHERE id_guru = "'.$nip.'")', NULL, FALSE);
    $this->db->delete('quiz');
    
    $this->db->trans_complete();
    return $this->db->trans_status();
}

// Get available materials for select dropdown
public function get_materi_options($nip) {
    $this->db->select('
        pertemuan.id AS id_pertemuan,
        materi.deskripsi,
        kelas.nama_kelas,
        kelas.tingkat,
        mata_pelajaran.nama_mapel,
        pertemuan.pertemuan_ke
    ');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->join('kelas', 'kelas.id = pertemuan.id_kelas');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = materi.id_mapel');

    // Join guru_mapel untuk cek relasi guru ke mapel
    $this->db->join('guru_mapel', 'guru_mapel.id_mapel = materi.id_mapel');

    // Filter berdasarkan guru di tabel guru_mapel
    $this->db->where('guru_mapel.id_guru', $nip);

    // Urutkan hasil agar rapi
    $this->db->order_by('mata_pelajaran.nama_mapel', 'ASC');
    $this->db->order_by('kelas.tingkat', 'ASC');
    $this->db->order_by('kelas.nama_kelas', 'ASC');
    $this->db->order_by('pertemuan.pertemuan_ke', 'ASC');

    // Pastikan hanya distinct pertemuan yang muncul (optional)
    $this->db->group_by('pertemuan.id');

    return $this->db->get()->result();
}

public function get_ujian_by_gurus($nip)
{
    $this->db->select('
        tu.*, 
        mp.nama_mapel,
        k.nama_kelas,
        k.tingkat,
        p.pertemuan_ke
    ');
    $this->db->from('tbl_ujian tu');
    $this->db->join('pertemuan p', 'p.id = tu.id_pertemuan');
    $this->db->join('materi m', 'm.id = p.id_materi');
    $this->db->join('kelas k', 'k.id = m.id_kelas');
    $this->db->join('mata_pelajaran mp', 'mp.id = m.id_mapel');
    $this->db->where('m.id_guru', $nip);
    $this->db->order_by('tu.tanggal_mulai', 'DESC');
    return $this->db->get()->result_array();
}
    public function get_soal_by_id_and_guru($id_soal, $nip)
    {
        $this->db->select('qq.*, q.id AS quiz_id, q.id_pertemuan, p.id_materi, m.id_guru');
        $this->db->from('quiz_questions qq');
        $this->db->join('quiz q', 'q.id = qq.quiz_id');
        $this->db->join('pertemuan p', 'p.id = q.id_pertemuan', 'left');
        $this->db->join('materi m', 'm.id = p.id_materi', 'left');
        $this->db->where('qq.id', $id_soal);
        $this->db->where('m.id_guru', $nip); // pastikan materi.id_guru = nip guru
        return $this->db->get()->row();
    }

    // Hapus soal quiz (beserta jawaban terkait jika ada) dengan transaction
    public function hapus_soalquiz($id_soal)
    {
        // Mulai transaction
        $this->db->trans_start();

        // Hapus jawaban quiz yang merujuk pada quiz_questions (jika tabel jawaban menyimpan question_id)
        // Tabel jawaban quiz di DB kamu ada `jawaban_siswa` (lihat script SQL)
        $this->db->where('question_id', $id_soal);
        $this->db->delete('jawaban_siswa');

        // Juga hapus di tabel jawaban ujian pribadi jika ada referensi id_soal
        // (di DB ada tbl_jawaban_siswa yang menggunakan id_soal)
        $this->db->where('id_soal', $id_soal);
        $this->db->delete('tbl_jawaban_siswa');

        // Hapus soal itu sendiri
        $this->db->where('id', $id_soal);
        $this->db->delete('quiz_questions');

        // Selesai transaction (commit/rollback otomatis)
        $this->db->trans_complete();

        return $this->db->trans_status(); // true jika sukses
    }

}