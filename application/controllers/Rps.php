<?php
class Rps extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Rps_model');
        $this->load->helper(array('form','url'));
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'guru') {
            redirect('welcome/guru');
        }
    }

    // Halaman daftar RPS
public function data_rps()
{
    // Ambil ID guru yang login dari session
    $id_guru = $this->session->userdata('nip');

    // Data user
    $data['user'] = $this->db->get_where('guru', ['nip' => $id_guru])->row_array();
    $data['rps_grouped'] = [];

    foreach ($this->Rps_model->tampil_rps_guru($id_guru) as $row) {
        $key = $row->nama_mapel . ' - ' . $row->nama_kelas;
        $data['rps_grouped'][$key][] = $row;
    }

    // Semua RPS guru
    $data['rps_list'] = $this->Rps_model->tampil_rps_guru($id_guru);

    $this->load->view('guru/navug');
    $this->load->view('guru/data_rps', $data);
    $this->load->view('guru/footg');
}


    // Form upload RPS
    public function upload_rps() {
        $id_guru = $this->session->userdata('nip');
        $data['mapel_list'] = $this->Rps_model->get_mapel_by_guru($id_guru);
        $data['kelas_list'] = $this->Rps_model->get_kelas_list();
        $this->load->view('guru/navug');
        $this->load->view('guru/kelola_rps', $data);
        $this->load->view('guru/footg');
    }

    // Proses upload
    public function proses_upload() {
        $id_guru = $this->session->userdata('nip');
        $guru_mapel_id = $this->input->post('guru_mapel_id');
        $kelas_id = $this->input->post('kelas_id');
        $semester = $this->input->post('semester');

        $config['upload_path'] = './assets/rps_uploads/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size'] = 5120; // 5 MB
        $config['file_name'] = 'RPS_'.$id_guru.'_'.$guru_mapel_id.'_'.$kelas_id.'_'.time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_rps')) {
            $file_data = $this->upload->data();
            $saved = $this->Rps_model->save_rps($guru_mapel_id, $kelas_id, $file_data['file_name'], $semester);
            if ($saved) {
                $this->session->set_flashdata('success','RPS berhasil diupload.');
            } else {
                $this->session->set_flashdata('error','Gagal menyimpan data ke database.');
            }
        } else {
            $this->session->set_flashdata('error',$this->upload->display_errors());
        }

        redirect('rps/data_rps');
    }
      public function update_rps($id_rps) {
        $id_guru = $this->session->userdata('nip');
        $data['rps'] = $this->Rps_model->get_rps($id_rps);
        $data['mapel_list'] = $this->Rps_model->get_mapel_by_guru($id_guru);
        $data['kelas_list'] = $this->Rps_model->get_kelas_list();
        $this->load->view('guru/navug');
        $this->load->view('guru/update_rps', $data);
        $this->load->view('guru/footg');
    }

    // Proses update
    public function proses_update($id_rps) {
        $guru_mapel_id = $this->input->post('guru_mapel_id');
        $kelas_id = $this->input->post('kelas_id');
        $semester = $this->input->post('semester');

        $data = [
            'guru_mapel_id' => $guru_mapel_id,
            'kelas_id' => $kelas_id,
            'semester' => $semester
        ];

        // Cek apakah ada file baru
        if (!empty($_FILES['file_rps']['name'])) {
            $config['upload_path'] = './assets/rps_uploads/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 5120;
            $config['file_name'] = $this->session->userdata('id_guru') . '_' . $guru_mapel_id . '_' . time();
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file_rps')) {
                $file_data = $this->upload->data();
                $data['file_rps'] = $file_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('rps/update_rps/'.$id_rps);
            }
        }

        $this->Rps_model->update_rps($id_rps, $data);
        $this->session->set_flashdata('success', 'RPS berhasil diupdate.');
        redirect('rps/data_rps');
    }

    // Hapus RPS
    public function delete_rps($id)
    {
        $rps = $this->Rps_model->get_rps_by_id($id);
        if (!$rps) {
            $this->session->set_flashdata('error', 'RPS tidak ditemukan.');
            redirect('rps/data_rps');
        }

        // Hapus file fisik
        $file_path = './assets/rps_uploads/' . $rps->file_rps;
        if (file_exists($file_path)) unlink($file_path);

        // Hapus data di database
        $this->Rps_model->delete_rps($id);
        $this->session->set_flashdata('success', 'RPS berhasil dihapus.');
        redirect('rps/data_rps');
    }

}
