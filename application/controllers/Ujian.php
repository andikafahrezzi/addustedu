<?php
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
        if (!$sudah_mulai) {
            $waktu_mulai = date('Y-m-d H:i:s');
            $this->session->set_userdata('waktu_mulai_ujian', strtotime($waktu_mulai));

            // Simpan waktu mulai ke semua soal pada ujian ini
            $soal_ujian = $this->Ujian_model->get_all_soal_by_ujian($id_ujian);

            foreach ($soal_ujian as $s) {
                $id_soal = $s['id_soal'] ?? null;
                $bank_soal_id = $s['bank_soal_id'] ?? null;

                // Pastikan hanya salah satu yang tidak null
                $this->db->insert('tbl_jawaban_siswa', [
                    'nis' => $nis,
                    'id_ujian' => $id_ujian,
                    'id_soal' => $id_soal,
                    'bank_soal_id' => $bank_soal_id,
                    'sumber' => $s['sumber'],
                    'waktu_mulai_ujian' => $waktu_mulai
                ]);
            }
        }


        // Jika waktu habis, submit otomatis
        if ($sisa_waktu <= 0) {
            $this->submit_ujian();
            return;
        }
        // Hitung sisa waktu dari database, bukan session
        $waktu_mulai_row = $this->db
            ->select('MIN(waktu_mulai_ujian) AS waktu_mulai')
            ->from('tbl_jawaban_siswa')
            ->where(['nis' => $nis, 'id_ujian' => $id_ujian])
            ->get()->row();

        $waktu_mulai = strtotime($waktu_mulai_row->waktu_mulai ?? date('Y-m-d H:i:s'));
        $waktu_selesai = $waktu_mulai + ($ujian->durasi * 60);
        $sisa_waktu = $waktu_selesai - time();

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

    // Hitung skor PG langsung (jika ada)
    $this->Ujian_model->hitung_skor($id_ujian, $nis);

    // ✅ Tandai ujian sudah diselesaikan (meskipun nilai essay belum keluar)
    $this->db->where(['id_ujian' => $id_ujian, 'nis' => $nis]);
    $this->db->update('tbl_jawaban_siswa', [
        'is_selesai' => 1,
        'waktu_submit' => date('Y-m-d H:i:s') // opsional
    ]);

    // Hapus session ujian
    $this->session->unset_userdata('ujian_id');

    // Redirect ke hasil
    redirect('ujian/hasil/' . $id_ujian);
}

public function hasil($id_ujian)
{
    $nis = $this->session->userdata('nis');

    // Ambil ujian & bobot
    $ujian = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();
    if (!$ujian) {
        show_error("Ujian tidak ditemukan.");
    }

    $bobot_pg = isset($ujian->bobot_pg) ? $ujian->bobot_pg : 70;
    $bobot_essay = isset($ujian->bobot_essay) ? $ujian->bobot_essay : 30;

    // Ambil semua soal dari ujian_soal
    $soal_pg_total = 0;
    $soal_essay_total = 0;
    $soal_map = []; // key: sumber_id => tipe_soal

    $ujian_soal = $this->db->get_where('ujian_soal', ['ujian_id' => $id_ujian])->result();
    foreach ($ujian_soal as $s) {
        $id = $s->sumber === 'bank_soal' ? $s->bank_soal_id : $s->soal_id;
        $tabel = $s->sumber === 'bank_soal' ? 'bank_soal' : 'tbl_soal';
        $soal = $this->db->select('tipe_soal')->get_where($tabel, ['id_soal' => $id])->row();

        if ($soal) {
            $key = $s->sumber . '_' . $id;
            $soal_map[$key] = $soal->tipe_soal;

            if ($soal->tipe_soal === 'pilihan') $soal_pg_total++;
            if ($soal->tipe_soal === 'essay')   $soal_essay_total++;
        }
    }

    // Ambil semua jawaban siswa
    $jawaban_siswa = $this->db->get_where('tbl_jawaban_siswa', [
        'id_ujian' => $id_ujian,
        'nis' => $nis
    ])->result();

    $jumlah_benar = 0;
    $total_nilai_essay = 0;
    $essay_belum_dinilai = false;
    $tanggal_submit = null;

    foreach ($jawaban_siswa as $jawaban) {
        $key = $jawaban->sumber . '_' . ($jawaban->sumber === 'bank_soal' ? $jawaban->bank_soal_id : $jawaban->id_soal);
        $tipe = $soal_map[$key] ?? null;

        if ($tipe === 'pilihan') {
            // Ambil kunci jawaban
            $soal = $jawaban->sumber === 'bank_soal'
                ? $this->db->get_where('bank_soal', ['id_soal' => $jawaban->bank_soal_id])->row()
                : $this->db->get_where('tbl_soal', ['id_soal' => $jawaban->id_soal])->row();

            if ($soal && $jawaban->jawaban == $soal->kunci_jawaban) {
                $jumlah_benar++;
            }
        }

        if ($tipe === 'essay') {
            if (is_null($jawaban->nilai_essay)) {
                $essay_belum_dinilai = true;
            } else {
                $total_nilai_essay += floatval($jawaban->nilai_essay);
            }
        }

        if (!$tanggal_submit) {
            $tanggal_submit = $jawaban->waktu_submit;
        }
    }

    // Hitung nilai
    $nilai_pg = $soal_pg_total > 0 ? ($jumlah_benar / $soal_pg_total) * 100 : 0;
    $rata_essay = $soal_essay_total > 0 ? $total_nilai_essay / $soal_essay_total : 0;

    $total_nilai = ($nilai_pg * ($bobot_pg / 100)) + ($rata_essay * ($bobot_essay / 100));

    // Peringatan jika ada essay belum dinilai
    $pesan_essay = $essay_belum_dinilai
        ? '⚠️ Beberapa soal essay belum dinilai oleh guru. Nilai akhir bersifat sementara.'
        : '';

    // View data
    $data['ujian'] = $ujian;
    $data['id_ujian'] = $id_ujian;
    $data['hasil'] = (object)[
        'total_pg' => number_format($nilai_pg, 2),
        'total_nilai_essay' => number_format($rata_essay, 2),
        'total_nilai' => number_format($total_nilai, 2),
        'jumlah_benar' => $jumlah_benar,
        'jumlah_salah' => $soal_pg_total - $jumlah_benar,
        'score' => $total_nilai,
        'tanggal_submit' => $tanggal_submit,
        'peringatan_essay' => $pesan_essay
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
    // Ambil data ujian & bobot
    $ujian = $this->db->get_where('tbl_ujian', ['id_ujian' => $id_ujian])->row();
    if (!$ujian) show_404();

    $bobot_pg = $ujian->bobot_pg ?? 70;
    $bobot_essay = $ujian->bobot_essay ?? 30;

    // Ambil semua soal dari ujian_soal
    $soal_pg_total = 0;
    $soal_essay_total = 0;
    $soal_map = []; // key: sumber_id → tipe_soal

    $ujian_soal = $this->db->get_where('ujian_soal', ['ujian_id' => $id_ujian])->result();
    foreach ($ujian_soal as $s) {
        $id = $s->sumber === 'bank_soal' ? $s->bank_soal_id : $s->soal_id;
        $tabel = $s->sumber === 'bank_soal' ? 'bank_soal' : 'tbl_soal';
        $soal = $this->db->select('id_soal, tipe_soal, kunci_jawaban')->get_where($tabel, ['id_soal' => $id])->row();

        if ($soal) {
            $key = $s->sumber . '_' . $id;
            $soal_map[$key] = [
                'tipe_soal' => $soal->tipe_soal,
                'kunci_jawaban' => $soal->kunci_jawaban,
                'sumber' => $s->sumber,
                'id_soal' => $id
            ];

            if ($soal->tipe_soal == 'pilihan') $soal_pg_total++;
            if ($soal->tipe_soal == 'essay')   $soal_essay_total++;
        }
    }

    // Ambil semua siswa yang sudah menyelesaikan ujian
    $this->db->where(['id_ujian' => $id_ujian, 'is_selesai' => 1]);
    $jawaban_all = $this->db->get('tbl_jawaban_siswa')->result();

    // Kelompokkan jawaban per siswa
    $jawaban_per_siswa = [];
    foreach ($jawaban_all as $j) {
        $key = $j->nis;
        if (!isset($jawaban_per_siswa[$key])) {
            $jawaban_per_siswa[$key] = [];
        }
        $jawaban_per_siswa[$key][] = $j;
    }

    $ranking_data = [];

    foreach ($jawaban_per_siswa as $nis => $jawaban_list) {
        $jumlah_benar = 0;
        $nilai_essay_total = 0;
        $essay_dinilai = 0;

        // Mapping jawaban untuk lookup cepat
        $jawaban_map = [];
        foreach ($jawaban_list as $jawaban) {
            $soal_key = $jawaban->sumber . '_' . ($jawaban->sumber === 'bank_soal' ? $jawaban->bank_soal_id : $jawaban->id_soal);
            $jawaban_map[$soal_key] = $jawaban;
        }

        foreach ($soal_map as $key => $info) {
            $tipe = $info['tipe_soal'];
            $jawaban = $jawaban_map[$key] ?? null;

            if ($tipe === 'pilihan') {
                if ($jawaban && $jawaban->jawaban == $info['kunci_jawaban']) {
                    $jumlah_benar++;
                }
                // else dianggap salah
            } elseif ($tipe === 'essay') {
                if ($jawaban && !is_null($jawaban->nilai_essay)) {
                    $nilai_essay_total += floatval($jawaban->nilai_essay);
                    $essay_dinilai++;
                } else {
                    $nilai_essay_total += 0; // tidak diisi = 0
                }
            }
        }

        $nilai_pg = $soal_pg_total > 0 ? ($jumlah_benar / $soal_pg_total) * 100 : 0;
        $rata_essay = $soal_essay_total > 0 ? $nilai_essay_total / $soal_essay_total : 0;
        $total_nilai = ($nilai_pg * ($bobot_pg / 100)) + ($rata_essay * ($bobot_essay / 100));

        $siswa = $this->db->get_where('siswa', ['nis' => $nis])->row();

        $ranking_data[] = [
            'nis' => $nis,
            'nama' => $siswa ? $siswa->nama : 'Unknown',
            'jumlah_benar' => $jumlah_benar,
            'jumlah_salah' => $soal_pg_total - $jumlah_benar,
            'nilai_pg' => number_format($nilai_pg, 2),
            'rata_essay' => number_format($rata_essay, 2),
            'total_nilai' => number_format($total_nilai, 2),
        ];
    }

    // Urutkan berdasarkan total_nilai DESC
    usort($ranking_data, fn($a, $b) => $b['total_nilai'] <=> $a['total_nilai']);

    $data['ranking'] = $ranking_data;
    $data['ujian'] = $ujian;

    $this->load->view('user/navu');
    $this->load->view('user/rankinng', $data);
}


}