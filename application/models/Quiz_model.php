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
    return $this->db->update('quiz_siswa', $data);
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
public function get_quizzes_by_materi($materi_id)
{
    return $this->db->select('quiz.*, COUNT(quiz_questions.id) as jumlah_soal')
                   ->from('quiz')
                   ->join('quiz_questions', 'quiz_questions.quiz_id = quiz.id', 'left')
                   ->where('quiz.materi_id', $materi_id)
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


}