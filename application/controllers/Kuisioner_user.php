<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuisioner_user extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Kuisioner_model');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Pragma: no-cache');
        if (!$this->session->userdata('logged_in')) {
            redirect('welcome');
        }
        
    }

    // tampil form kuisioner
    public function fill($kuisioner_id) {
        $user_type = $this->session->userdata('role');
        $user_id   = $this->session->userdata('id');

        $data['kuisioner']   = $this->Kuisioner_model->get_by_id($kuisioner_id);
        $data['pertanyaan']  = $this->Kuisioner_model->get_pertanyaan($kuisioner_id);

        // jika sudah selesai, langsung ke dashboard
        $cek = $this->db->where([
    'user_type'    => $user_type,
    'user_id'      => $user_id,
    'kuisioner_id' => $kuisioner_id,
    'is_completed' => 1
    ])->get('kuisioner_status')->row();

    if ($cek) {
        $this->session->set_flashdata('info', 'Anda sudah mengisi kuisioner ini.');
        redirect($user_type); // siswa → ke dashboard siswa, guru → ke dashboard guru
    }

        
        $this->load->view('template/kuisioner', $data);
        
    }

    // simpan hasil
public function submit($kuisioner_id) {
    $user_type = $this->session->userdata('user_type');
    if ($user_type == 'siswa') {
        $user_id = $this->session->userdata('nis');
    } elseif ($user_type == 'guru') {
        $user_id = $this->session->userdata('nip');
    } else {
        show_error("User type tidak valid");
    }

    // cek apakah sudah pernah isi
    $cek = $this->db->where([
        'user_type'    => $user_type,
        'user_id'      => $user_id,
        'kuisioner_id' => $kuisioner_id,
        'is_completed' => 1
    ])->get('kuisioner_status')->row();

    if ($cek) {
        $this->session->set_flashdata('info', 'Anda sudah mengisi kuisioner ini.');
        redirect($user_type == 'siswa' ? 'user' : 'guru');
        return;
    }

    // simpan jawaban
    $pertanyaan = $this->Kuisioner_model->get_pertanyaan($kuisioner_id);
    foreach ($pertanyaan as $p) {
        $field   = "pertanyaan_".$p->id;
        $jawaban = $this->input->post($field);

        $data = [
            'kuisioner_id'  => $kuisioner_id,
            'pertanyaan_id' => $p->id,
            'user_type'     => $user_type,
            'user_id'       => $user_id,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        if ($p->tipe_jawaban == 'skala') {
            $data['jawaban_skala'] = (int)$jawaban;
        } elseif ($p->tipe_jawaban == 'pilihan') {
            $data['jawaban_pilihan'] = $jawaban;
        } else {
            $data['jawaban_text'] = $jawaban;
        }

        $this->Kuisioner_model->simpan_jawaban($data);
    }

    // update status selesai
    $this->Kuisioner_model->update_status($user_type, $user_id, $kuisioner_id);

    $this->session->set_flashdata('success', 'Terima kasih, kuisioner berhasil dikirim');
    redirect($user_type == 'siswa' ? 'user' : 'guru'); // balik ke dashboard sesuai role
}


}
