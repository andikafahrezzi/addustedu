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

    // Ambil semua jawaban siswa
    $jawaban_siswa = $this->db->get_where('tbl_jawaban_siswa', [
        'id_ujian' => $id_ujian,
        'nis' => $nis
    ])->result();

    $jumlah_benar = 0;
    $total_soal_pg = 0;
    $total_nilai_essay = 0;
    $jumlah_soal_essay = 0;
    $tanggal_submit = null;
    $ada_essay_belum_dinilai = false;

    foreach ($jawaban_siswa as $jawaban) {
        // Ambil data soal dari sumbernya
        if ($jawaban->sumber == 'bank_soal') {
            $soal = $this->db->get_where('bank_soal', ['id_soal' => $jawaban->bank_soal_id])->row();
        } else {
            $soal = $this->db->get_where('tbl_soal', ['id_soal' => $jawaban->id_soal])->row();
        }

        // Cek PG
        if ($soal && $soal->tipe_soal == 'pilihan') {
            $total_soal_pg++;
            if ($jawaban->jawaban == $soal->kunci_jawaban) {
                $jumlah_benar++;
            }
        }

        // Cek Essay
        if ($soal && $soal->tipe_soal == 'essay') {
            if (is_null($jawaban->nilai_essay)) {
                $ada_essay_belum_dinilai = true;
            } else {
                $total_nilai_essay += floatval($jawaban->nilai_essay);
                $jumlah_soal_essay++;
            }
        }

        if (!$tanggal_submit) {
            $tanggal_submit = $jawaban->waktu_submit;
        }
    }

    // ❌ TOLAK jika masih ada essay belum dinilai
    if ($ada_essay_belum_dinilai) {
        $this->session->set_flashdata('warning', 'Mohon tunggu, nilai essay Anda belum dinilai oleh guru.');
        redirect('user/dashboard'); // atau redirect ke halaman lain yang sesuai
        return;
    }

    $nilai_pg = $total_soal_pg > 0 ? ($jumlah_benar / $total_soal_pg) * 100 : 0;
    $rata_essay = $jumlah_soal_essay > 0 ? $total_nilai_essay / $jumlah_soal_essay : 0;
    $total_nilai = ($nilai_pg * 0.7) + ($rata_essay * 0.3);

    $data['ujian'] = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();

    $data['hasil'] = (object)[
        'total_pg' => number_format($nilai_pg, 2),
        'total_nilai_essay' => number_format($rata_essay, 2),
        'total_nilai' => number_format($total_nilai, 2),
        'jumlah_benar' => $jumlah_benar,
        'jumlah_salah' => $total_soal_pg - $jumlah_benar,
        'score' => $total_nilai,
        'tanggal_submit' => $tanggal_submit
    ];

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

    if (!$this->input->is_ajax_request()) {
        return $this->output->set_status_header(403)
            ->set_output(json_encode(['status' => 'error', 'message' => 'Forbidden']));
    }

    $tipe_soal = $this->input->post('tipe_soal');

    

    $this->form_validation->set_rules('id_soal', 'ID Soal', 'required|numeric');
    $this->form_validation->set_rules('sumber', 'Sumber Soal', 'required|in_list[tbl_soal,bank_soal]');
    $this->form_validation->set_rules('tipe_soal', 'Tipe Soal', 'required|in_list[pilihan,essay]');
    $this->form_validation->set_rules('ragu', 'Ragu-ragu', 'required|in_list[0,1]');

    if ($tipe_soal == 'pilihan') {
        $this->form_validation->set_rules('jawaban', 'Jawaban', 'required|in_list[A,B,C,D]');
    } else if ($tipe_soal == 'essay') {
        $this->form_validation->set_rules('jawaban', 'Jawaban Essay', 'required');
    } else {
        return $this->output->set_status_header(400)
            ->set_output(json_encode(['status' => 'error', 'message' => 'Tipe soal tidak valid']));
    }

    if (!$this->form_validation->run()) {
        return $this->output->set_status_header(400)
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . validation_errors(null, null)
            ]));
    }

    $this->load->model('Ujian_model');
    $success = $this->Ujian_model->simpan_jawaban(
        $this->input->post('id_soal'),
        $this->input->post('jawaban'),
        $this->input->post('ragu'),
        $this->input->post('sumber'),
        $tipe_soal
    );

    if ($success) {
        return $this->output->set_status_header(200)
            ->set_output(json_encode(['status' => 'success', 'message' => 'Jawaban berhasil disimpan']));
    } else {
        return $this->output->set_status_header(500)
            ->set_output(json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database']));
    }
}

public function ranking($id_ujian)
{
    // Ambil semua siswa yang sudah selesai ujian
    $this->db->select('tbl_jawaban_siswa.*', false);
    $this->db->from('tbl_jawaban_siswa');
    $this->db->where('id_ujian', $id_ujian);
    $this->db->where('is_selesai', 1);
    $jawaban_all = $this->db->get()->result();

    $ranking_data = [];

    foreach ($jawaban_all as $jawaban) {
        $nis = $jawaban->nis;

        // Inisialisasi jika belum ada
        if (!isset($ranking_data[$nis])) {
            $ranking_data[$nis] = [
                'nis' => $nis,
                'nama' => '', // diisi nanti
                'jumlah_benar' => 0,
                'jumlah_salah' => 0,
                'nilai_pg' => 0,
                'nilai_essay_total' => 0,
                'jumlah_essay' => 0,
                'total_nilai' => 0
            ];
        }

        // Ambil nama siswa (sekali saja)
        if (empty($ranking_data[$nis]['nama'])) {
            $siswa = $this->db->get_where('siswa', ['nis' => $nis])->row();
            $ranking_data[$nis]['nama'] = $siswa ? $siswa->nama : 'Unknown';
        }

        // Ambil data soal
        if ($jawaban->sumber == 'bank_soal') {
            $soal = $this->db->get_where('bank_soal', ['id_soal' => $jawaban->bank_soal_id])->row();
        } else {
            $soal = $this->db->get_where('tbl_soal', ['id_soal' => $jawaban->id_soal])->row();
        }

        if (!$soal) continue;

        if ($soal->tipe_soal == 'pilihan') {
            if ($jawaban->jawaban == $soal->kunci_jawaban) {
                $ranking_data[$nis]['jumlah_benar']++;
            } else {
                $ranking_data[$nis]['jumlah_salah']++;
            }
        }

        if ($soal->tipe_soal == 'essay') {
            if (!is_null($jawaban->nilai_essay)) {
                $ranking_data[$nis]['nilai_essay_total'] += floatval($jawaban->nilai_essay);
                $ranking_data[$nis]['jumlah_essay']++;
            }
        }
    }

    // Hitung nilai total semua siswa
    foreach ($ranking_data as &$data) {
        $total_pg = $data['jumlah_benar'] + $data['jumlah_salah'];
        $nilai_pg = $total_pg > 0 ? ($data['jumlah_benar'] / $total_pg) * 100 : 0;
        $rata_essay = $data['jumlah_essay'] > 0 ? $data['nilai_essay_total'] / $data['jumlah_essay'] : 0;

        $data['nilai_pg'] = $nilai_pg;
        $data['total_nilai'] = ($nilai_pg * 0.7) + ($rata_essay * 0.3);
    }

    // Urutkan manual berdasarkan total_nilai DESC
    usort($ranking_data, function ($a, $b) {
        return $b['total_nilai'] <=> $a['total_nilai'];
    });

    $data['ranking'] = $ranking_data;
    $data['ujian'] = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();

    $this->load->view('user/navu');
    $this->load->view('user/rankinng', $data);
}


}