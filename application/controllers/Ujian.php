<?php
class Ujian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ujian_model');
        if (!$this->session->userdata('nis')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['ujian'] = $this->Ujian_model->get_ujian_by_kelas($this->session->userdata('kelas'));
        $this->load->view('ujian_list', $data);
    }
    
    public function mulai($id_ujian)
    {
        // Cek apakah ujian aktif
        $ujian = $this->Ujian_model->get_ujian_by_id($id_ujian);
        if (!$ujian || $ujian->status != 'aktif') {
            show_404();
            return;
        }

        // Cek tanggal ujian
        $today = date('Y-m-d');
        if ($today < $ujian->tanggal_mulai || $today > $ujian->tanggal_selesai) {
            $this->session->set_flashdata('error', 'Ujian tidak tersedia pada tanggal ini');
            redirect('ujian');
        }

        $nis = $this->session->userdata('nis');

        // Cek apakah sudah mulai ujian
        $sudah_mulai = $this->Ujian_model->cek_sudah_mulai($id_ujian, $nis);
             if (!$sudah_mulai) {
            // Simpan waktu mulai di session saja
            $this->session->set_userdata('waktu_mulai_ujian', time());
        }

        // Set session ujian
        $this->session->set_userdata('ujian_id', $id_ujian);

        // Hitung sisa waktu
        if ($sudah_mulai && $sudah_mulai->waktu_mulai_ujian) {
            $waktu_mulai = strtotime($sudah_mulai->waktu_mulai_ujian);
            $waktu_selesai = $waktu_mulai + ($ujian->durasi * 60);
            $sisa_waktu = $waktu_selesai - time();
        } else {
            $sisa_waktu = $ujian->durasi * 60;
        }

        // Jika waktu habis, submit otomatis
        if ($sisa_waktu <= 0) {
            $this->submit_ujian();
            return;
        }

            $data['ujian'] = $ujian;
            $data['soal'] = $this->Ujian_model->get_all_soal_by_ujian($id_ujian);
            $data['sisa_waktu'] = $sisa_waktu;
            $data['nis'] = $nis;

            // Pastikan semua soal memiliki id
            foreach ($data['soal'] as &$soal) {
                if (!isset($soal['id'])) {
                    $soal['id'] = $soal['id_soal'] ?? 0; // Fallback jika id_soal ada
                }
            }




        $this->load->view('user/navu');
        $this->load->view('user/ujian', $data);
        $this->load->view('user/foots');
    }

    public function submit_ujian()
    {
        $id_ujian = $this->session->userdata('ujian_id');
        $nis = $this->session->userdata('nis');

        if (!$id_ujian || !$nis) {
            redirect('ujian');
        }

        // Hitung skor
        $this->Ujian_model->hitung_skor($id_ujian, $nis);

        // Clear session ujian
        $this->session->unset_userdata('ujian_id');

        redirect('ujian/hasil/'.$id_ujian);
    }

    public function hasil($id_ujian)
    {
        $nis = $this->session->userdata('nis');
        $data['hasil'] = $this->db->select('*')
                                 ->from('tbl_jawaban_siswa')
                                 ->where('id_ujian', $id_ujian)
                                 ->where('nis', $nis)
                                 ->get()
                                 ->row();

        $data['ujian'] = $this->Ujian_model->get_ujian_by_id($id_ujian);

        $this->load->view('user/navu');
        $this->load->view('user/hasil', $data);
        
    }
    public function tandai_ragu()
{
    $this->output->set_content_type('application/json');

    // Validasi AJAX request
    if (!$this->input->is_ajax_request()) {
        return $this->output->set_status_header(403)
            ->set_output(json_encode(['status' => 'error', 'message' => 'Forbidden']));
    }

    // Validasi input
    $this->form_validation->set_rules('id_soal', 'ID Soal', 'required|numeric');
    $this->form_validation->set_rules('jawaban', 'Jawaban', 'required|in_list[A,B,C,D]');
    $this->form_validation->set_rules('sumber', 'Sumber Soal', 'required|in_list[tbl_soal,bank_soal]');

    if (!$this->form_validation->run()) {
        return $this->output->set_status_header(400)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . validation_errors(null, null)
            ]));
    }

    // Proses tanda ragu
    $this->load->model('Ujian_model');
    $success = $this->Ujian_model->tandai_ragu(
        $this->input->post('id_soal'),
        $this->input->post('jawaban'),
        $this->input->post('sumber')
    );

    if ($success) {
        return $this->output->set_status_header(200)
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Tanda ragu berhasil disimpan',
                'csrf_token' => $this->security->get_csrf_hash()
            ]));
    } else {
        return $this->output->set_status_header(500)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan tanda ragu',
                'csrf_token' => $this->security->get_csrf_hash()
            ]));
    }
}
    
    public function simpan_jawaban_ajax()
{
    $this->output->set_content_type('application/json');

    // Validasi AJAX
    if (!$this->input->is_ajax_request()) {
        return $this->output->set_status_header(403)
            ->set_output(json_encode(['status' => 'error', 'message' => 'Forbidden']));
    }

    // Validasi input
    $this->form_validation->set_rules('id_soal', 'ID Soal', 'required|numeric');
    $this->form_validation->set_rules('jawaban', 'Jawaban', 'required|in_list[A,B,C,D]');
    $this->form_validation->set_rules('sumber', 'Sumber Soal', 'required|in_list[tbl_soal,bank_soal]');
    $this->form_validation->set_rules('ragu', 'Ragu-ragu', 'required|in_list[0,1]');

    if (!$this->form_validation->run()) {
        return $this->output->set_status_header(400)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . validation_errors(null, null)
            ]));
    }

    // Proses penyimpanan
    $this->load->model('Ujian_model');
    $success = $this->Ujian_model->simpan_jawaban(
        $this->input->post('id_soal'),
        $this->input->post('jawaban'),
        $this->input->post('ragu'),
        $this->input->post('sumber')
    );

    if ($success) {
        return $this->output->set_status_header(200)
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Jawaban berhasil disimpan'
            ]));
    } else {
        return $this->output->set_status_header(500)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan ke database'
            ]));
    }
}
public function ranking($id_ujian)
{
    $ranking = $this->db->select('nis, SUM(score) as total_score')
                        ->where(['id_ujian' => $id_ujian, 'is_selesai' => 1])
                        ->group_by('nis')
                        ->order_by('total_score', 'DESC')
                        ->get('tbl_jawaban_siswa')
                        ->result();

    $data['ranking'] = $ranking; 
    $data['ujian'] = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();

    $this->load->view('user/navu');
    $this->load->view('user/rankinng', $data);   
}

}