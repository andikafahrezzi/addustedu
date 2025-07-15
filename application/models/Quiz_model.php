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
        return $this->db->get('materi')->result();
    }

    public function get_quiz_with_questions($quiz_id)
    {
        $quiz = $this->db->get_where('quiz', ['id' => $quiz_id])->row();
        
        if($quiz) {
            $quiz->questions = $this->db->get_where('quiz_questions', ['quiz_id' => $quiz_id])->result();
            $quiz->materi = $this->db->get_where('materi', ['id' => $quiz->materi_id])->row();
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
    $this->db->where('id', $quiz_siswa_id)
             ->update('quiz_siswa', [
                 'end_time' => date('Y-m-d H:i:s'),
                 'status' => 'completed',
                 'score' => $score
             ]);
    $this->db->where('id', $quiz_siswa_id);
    return $this->db->set('quiz_siswa', $data);
}
public function get_quiz_siswa($quiz_siswa_id)
{
    return $this->db->get_where('quiz_siswa', ['id' => $quiz_siswa_id])->row();
}

public function get_quiz_result_detail($quiz_siswa_id)
{
    return $this->db->select('quiz_siswa.*, quiz.judul, materi.nama_mapel, materi.id as materi_id')
                   ->from('quiz_siswa')
                   ->join('quiz', 'quiz.id = quiz_siswa.quiz_id')
                   ->join('materi', 'materi.id = quiz.materi_id')
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
public function tampil_quiz()
{
    return $this->db->get('quiz');
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
    $this->db->select('quiz.*, materi.deskripsi as judul_materi, materi.kelas as kelas');
    $this->db->from('quiz');
    $this->db->join('materi', 'materi.id = quiz.materi_id');
    $this->db->where('materi.id_guru', $nip);
    return $this->db->get()->result();
}

// Get single quiz with ownership check
public function get_quiz_by_guru($quiz_id, $nip) {
    $this->db->select('quiz.*, materi.deskripsi as judul_materi');
    $this->db->from('quiz');
    $this->db->join('materi', 'materi.id = quiz.materi_id');
    $this->db->where('quiz.id', $quiz_id);
    $this->db->where('materi.id_guru', $nip);
    return $this->db->get()->row();
}

public function get_pesertaquiz($quiz_id, $nip) {
    $this->db->select('quiz_siswa.*, siswa.nama as nama_siswa, siswa.kelas, materi.deskripsi as judul_materi');
    $this->db->from('quiz_siswa');
    $this->db->join('quiz', 'quiz.id = quiz_siswa.quiz_id'); // Join ke quiz dulu
    $this->db->join('materi', 'materi.id = quiz.materi_id'); // Lalu ke materi
    $this->db->join('siswa', 'siswa.nis = quiz_siswa.siswa_id'); // Join ke siswa
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
    $this->db->where('id', $quiz_id);
    $this->db->where('materi_id IN (SELECT id FROM materi WHERE id_guru = "'.$nip.'")', NULL, FALSE);
    return $this->db->update('quiz', $data);
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
    $this->db->select('id, deskripsi, kelas');
    $this->db->from('materi');
    $this->db->where('id_guru', $nip);
    return $this->db->get()->result();
}

}