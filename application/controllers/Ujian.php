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
    // Cek apakah sudah selesai
    $sudah_selesai = $this->db->get_where('tbl_jawaban_siswa', [
        'nis' => $nis,
        'id_ujian' => $id_ujian,
        'is_selesai' => 1
    ])->row();

    if($sudah_selesai){
        redirect('ujian/hasil/'.$id_ujian);
    }

    // Lanjutkan dengan logika awal
    $data['ujian'] = $this->Ujian_model->get_ujian_by_idS($id_ujian);
    $data['soal'] = $this->Ujian_model->get_soal_by_ujian($id_ujian);

    if (empty($data['soal'])) {
        show_404();
    }
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
public function kerjakan($id_ujian)
{
    $nis = $this->session->userdata('nis');

    // Cek apakah sudah selesai
    $sudah_selesai = $this->db->get_where('tbl_jawaban_siswa', [
        'nis' => $nis,
        'id_ujian' => $id_ujian,
        'is_selesai' => 1
    ])->row();

    if($sudah_selesai){
        redirect('ujian/hasil/'.$id_ujian);
    }

    $data['ujian'] = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();
    $data['soal'] = $this->db->get_where('tbl_soal', ['id_ujian' => $id_ujian])->result();
    $data['nis'] = $nis;
    $this->load->view('ujian/kerjakan', $data);
}

public function submit_ujian()
{
    $nis = $this->session->userdata('nis');
    $id_ujian = $this->input->post('id_ujian');
    $this->db->where(['nis' => $nis, 'id_ujian' => $id_ujian]);
    $this->db->update('tbl_jawaban_siswa', [
        'is_selesai' => 1,
        // field lainnya...
        ]);

    $soal = $this->db->get_where('tbl_soal', ['id_ujian' => $id_ujian])->result();
    $jumlah_soal = count($soal);
    $jumlah_benar = 0;

    foreach($soal as $s){
        $jawaban_siswa = $this->input->post('jawaban'.$s->id_soal);
        $ragu_ragu = $this->input->post('ragu_'.$s->id_soal); // Perhatikan underscore
        
        if(!empty($jawaban_siswa)){
            if($jawaban_siswa == $s->kunci_jawaban){
                $jumlah_benar++;
            }

            $this->db->replace('tbl_jawaban_siswa', [
                'nis' => $nis,
                'id_ujian' => $id_ujian,
                'id_soal' => $s->id_soal,
                'jawaban' => $jawaban_siswa,
                'ragu_ragu' => $ragu_ragu ? 1 : 0
            ]);
        }
    }

    // Hitung skor dan simpan hasil
    $score = ($jumlah_benar / $jumlah_soal) * 100;
    
    $this->db->where(['nis' => $nis, 'id_ujian' => $id_ujian]);
    $this->db->update('tbl_jawaban_siswa', [
        'is_selesai' => 1,
        'jumlah_benar' => $jumlah_benar,
        'jumlah_salah' => $jumlah_soal - $jumlah_benar,
        'score' => $score,
        'tanggal_submit' => date('Y-m-d H:i:s')
    ]);

    redirect('ujian/hasil/'.$id_ujian);
}


public function hasil($id_ujian)
{
    $nis = $this->session->userdata('nis');

    $hasil = $this->db->select('jumlah_benar, jumlah_salah, score, tanggal_submit')
                      ->where(['nis' => $nis, 'id_ujian' => $id_ujian, 'is_selesai' => 1])
                      ->group_by('nis')
                      ->get('tbl_jawaban_siswa')
                      ->row();

    if(!$hasil){
        redirect('ujian/kerjakan/'.$id_ujian);
    }

    $data['hasil'] = $hasil;
    $data['ujian'] = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();
    $this->load->view('user/navu');
    $this->load->view('user/hasil', $data);
    
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
