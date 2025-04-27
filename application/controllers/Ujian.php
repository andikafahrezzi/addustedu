<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ujian_model');
        if (!$this->session->userdata('nis')) {
            redirect('welcome');
        }
    }

    public function index()
    {
        $ujian = $this->Ujian_model->get_active_ujian();
        if (!$ujian) {
            echo "Belum ada ujian yang aktif.";
            return;
        }
        
        $data['ujian'] = $ujian;
        $data['soal'] = $this->Ujian_model->get_soal($ujian->id_ujian);
        $this->load->view('user', $data);
    }

    public function tambah_ujian()
    {
        $this->load->view('guru/tambah_ujian');
    }

    // Menyimpan ujian ke database
    public function simpan_ujian()
    {
        // Ambil data dari form input
        $data = [
            'nama_ujian' => $this->input->post('nama_ujian'),
            'tanggal_mulai' => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
            'durasi' => $this->input->post('durasi'),
            'status' => $this->input->post('status'),
            'id_materi' => $this->input->post('id_materi')
        ];

        // Simpan data ujian
        $this->Ujian_model->tambah_ujian($data);
        redirect('guru/tampilkan_ujian'); // Kembali ke halaman daftar ujian
    }

    // Menampilkan form untuk tambah soal
    public function tambah_soal($id_ujian)
    {
        $data['id_ujian'] = $id_ujian;
        $this->load->view('guru/tambah_soal', $data);
    }

    // Menyimpan soal ke database
    public function simpan_soal()
    {
        $data = [
            'id_ujian' => $this->input->post('id_ujian'),
            'pertanyaan' => $this->input->post('pertanyaan'),
            'pilihan_a' => $this->input->post('pilihan_a'),
            'pilihan_b' => $this->input->post('pilihan_b'),
            'pilihan_c' => $this->input->post('pilihan_c'),
            'pilihan_d' => $this->input->post('pilihan_d'),
            'kunci_jawaban' => $this->input->post('kunci_jawaban')
        ];

        // Simpan soal ke database
        $this->Ujian_model->tambah_soal($data);
        redirect('guru/tampilkan_soal/' . $data['id_ujian']); // Kembali ke halaman soal ujian
    }

    public function mulai($id_ujian)
{
    // Ambil NIS dari session
    $nis = $this->session->userdata('nis');
    $this->load->model('Ujian_model');

    $data['ujian'] = $this->Ujian_model->get_ujian_by_idS($id_ujian);
    
    // Ambil soal dari model
    $data['soal'] = $this->Ujian_model->get_soal_by_ujian($id_ujian);

    // Pastikan soal ditemukan
    if (empty($data['soal'])) {
        show_404();
    }

    // Kirimkan data soal dan nis ke view
    $data['nis'] = $nis;  // Menambahkan nis ke data yang diteruskan ke view

    $this->load->view('user/ujian', $data);  // Memuat view dengan data
}
public function submit_ujian()
{
    $nis = $this->session->userdata('nis');
    $id_ujian = $this->input->post('id_ujian');
    
    // Ambil soal berdasarkan ujian
    $soal = $this->Ujian_model->get_soal_by_ujian($id_ujian);

    if (empty($soal)) {
        show_404();  // Jika soal tidak ditemukan
    }

    // Proses jawaban
    foreach ($soal as $s) {
        $jawaban = $this->input->post('jawaban' . $s->id_soal);  // Mengambil jawaban
        $ragu = $this->input->post('ragu_' . $s->id_soal) ?? 0;  // Menandai jika ragu

        // Jika jawaban ada, simpan
        if ($jawaban !== null) {
            $data = [
                'nis' => $nis,
                'id_soal' => $s->id_soal,
                'jawaban' => $jawaban,
                'ragu_ragu' => $ragu
            ];

            // Insert atau update jawaban siswa
            $this->db->replace('tbl_jawaban_siswa', $data);
        }
    }

    // Menghapus sesi ujian dari localStorage (Client-side)
    $waktuUjianKey = 'waktu_ujian_' . $id_ujian;
    $this->session->set_flashdata('message', 'Ujian telah disubmit.');

    // Redirect ke halaman konfirmasi atau dashboard
    redirect('user');
}




}
