<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    protected $guru_data;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->session->set_flashdata('not-login', 'Gagal!');
        $this->load->model(['M_materi', 'Forum_model', 'Quiz_model', 'Tugas_model', 'M_siswa', 'Ujian_model', 'Bank_soal_model', 'M_guru']);  
        $this->load->library('form_validation');
        $this->load->helper('text');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') != 'guru') {
            redirect('welcome/guru');
        }
        
        // Ambil data guru yang login
        $nip = $this->session->userdata('nip');
        $this->guru_data = $this->M_guru->detail_guru($nip);
        
        if (!$this->guru_data) {
            $this->session->set_flashdata('error', 'Data guru tidak ditemukan');
            redirect('welcome/guru');
        }
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('guru', ['nip' => $this->session->userdata('nip')])->row_array();
        $this->load->view('guru/navug');
        $this->load->view('guru/index');
        $this->load->view('guru/footg');

    }

    public function add_materi()
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_mapel[]', 'Nama Mata Pelajaran', 'required');
    $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required|numeric');
    
    $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);

    if ($this->form_validation->run() == false) {
        $nip = $this->session->userdata('nip');
        $data['user'] = $this->M_materi->get_detail_guru($nip);
        $data['kelas'] = $this->db->get('kelas')->result();
        $this->load->view('guru/navug');
        $this->load->view('guru/add_materi', $data);
        // $this->load->view('guru/footg');
    } else {
        $nip      = $this->session->userdata('nip');
        $mapel    = $this->input->post('id_mapel');     // ✅ ini array
        $kelas    = $this->input->post('id_kelas');     // ✅ sesuai name form

        $pertemuan= $this->input->post('pertemuan');

        foreach ($this->input->post('id_mapel') as $id_mapel) {
            if ($this->M_materi->is_pertemuan_terpakai($id_mapel, $kelas, $pertemuan, $nip)) {
                $this->session->set_flashdata('error', '❌ Pertemuan ke-' . $pertemuan . ' untuk kelas ini dan mapel yang dipilih sudah digunakan.');
                redirect('guru/add_materi');
                return; // penting agar tidak lanjut insert
            }
        }


        // Upload video
        $video_input = $this->input->post('videourl', true);
        $video_embed = '';

        if (!empty($video_input)) {
            // 1. Konversi ke embed URL
            $video_embed = $this->convert_to_embed($video_input);

            if (empty($video_embed)) {
                $this->session->set_flashdata('error', 'Gagal mengkonversi URL video. Pastikan link benar.');
                redirect('guru/add_materi');
                return;
            }

            // 2. Validasi embed URL
            if (!$this->is_valid_embed_url($video_embed)) {
                $this->session->set_flashdata('error', 'Format embed video tidak valid');
                redirect('guru/add_materi');
                return;
            }
        }


        $this->load->library('upload');


        // Upload file materi
        $modul = '';
        if (!empty($_FILES['modul']['name'])) {
            $config_modul['upload_path']   = './assets/materi_modul/';
            $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
            $config_modul['max_size']      = 2048;
            $this->upload->initialize($config_modul);

            if ($this->upload->do_upload('modul')) {
                $upload_data = $this->upload->data();
                $modul = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                redirect('guru/add_materi');
            }
        }

        // Simpan ke database
        // Data untuk tabel 'materi' (sudah dinormalisasi)
        $id_mapel_array = $this->input->post('id_mapel');
    foreach ($id_mapel_array as $id_mapel) {
        // Data untuk tabel 'materi'
        $data_materi = [
            'id_guru'     => $nip,
            'id_mapel'    => $id_mapel,
            'id_kelas'    => $this->input->post('id_kelas'),
            'deskripsi'   => $this->input->post('deskripsi'),
            'linkform'   => $this->input->post('linkform'),
            'video'  => $video_embed,
            'modul' => $modul
        ];

        $this->db->insert('materi', $data_materi);
        $id_materi = $this->db->insert_id();

        // Insert ke tabel 'pertemuan' untuk setiap materi
        $data_pertemuan = [
            'id_materi'    => $id_materi,
            'id_kelas'     => $this->input->post('id_kelas'),
            'pertemuan_ke' => $this->input->post('pertemuan'),
            'tanggal'      => date('Y-m-d')
        ];

        $this->db->insert('pertemuan', $data_pertemuan);
    }

        $this->session->set_flashdata('success', 'Materi dan Pertemuan berhasil ditambahkan!');
        redirect('guru/data_materi');

    }
}
/**
 * Validates video URL format and domain with HTTPS check
 */
// Fungsi tambahan untuk validasi embed URL
private function is_valid_embed_url($url) {
    $patterns = [
        'youtube' => '/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+(\?.*)?$/',
        'vimeo'   => '/^https:\/\/player\.vimeo\.com\/video\/[0-9]+(\?.*)?$/',
        'drive'   => '/^https:\/\/drive\.google\.com\/file\/d\/[a-zA-Z0-9_-]+\/preview(\?.*)?$/'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url)) {
            return true;
        }
    }

    return false;
}
private function is_valid_video_url($url) {
    if (empty($url)) return true;
    
    $allowed_domains = [
        'youtube.com',
        'youtu.be',
        'vimeo.com',
        'drive.google.com'
    ];

    // 1. Basic URL validation
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }
    
    // 2. Force HTTPS and clean URL
    $url = $this->clean_video_url($url);

    // 3. Parse and validate components
    $parsed = parse_url($url);
    if (!isset($parsed['host'])) {
        return false;
    }

    // 4. Check against allowed domains
    foreach ($allowed_domains as $domain) {
        if (strpos($parsed['host'], $domain) !== false) {
            return true;
        }
    }

    return false;
}

private function clean_video_url($url) {
    // Remove tracking parameters and unnecessary query strings
    $url = preg_replace('/([&?])(si|feature|ab_channel)=[^&]+/', '', $url);
    $url = preg_replace('/&+$/', '', $url); // Remove trailing &
    
    // Force HTTPS
    if (strpos($url, 'https://') !== 0) {
        $url = 'https://' . str_replace(['http://', 'https://'], '', $url);
    }
    
    return $url;
}

private function convert_to_embed($url) {
    $url = $this->clean_video_url($url);
    $parsed = parse_url($url);
    $host = $parsed['host'] ?? '';

    // --------------------
    // YouTube
    // --------------------
    if (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) {
        $video_id = '';

        // Short link youtu.be
        if (strpos($host, 'youtu.be') !== false) {
            $video_id = substr($parsed['path'], 1);       // ambil path setelah /
            $video_id = preg_replace('/\?.*/', '', $video_id); // hapus query string
        }
        // Standard YouTube link
        else {
            parse_str($parsed['query'] ?? '', $query);
            $video_id = $query['v'] ?? '';

            // Handle /watch/VIDEO_ID style (jarang)
            if (empty($video_id) && isset($parsed['path'])) {
                preg_match('/\/watch\/([a-zA-Z0-9_-]+)/', $parsed['path'], $matches);
                $video_id = $matches[1] ?? '';
            }
        }

        // Bersihkan video ID dari karakter aneh
        $video_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $video_id);

        return $video_id ? 'https://www.youtube.com/embed/' . $video_id . '?rel=0&modestbranding=1' : '';
    }

    // --------------------
    // Vimeo
    // --------------------
    if (strpos($host, 'vimeo.com') !== false) {
        $video_id = substr($parsed['path'], 1);
        $video_id = preg_replace('/[^0-9]/', '', $video_id);
        return $video_id ? 'https://player.vimeo.com/video/' . $video_id : '';
    }

    // --------------------
    // Google Drive
    // --------------------
    if (strpos($host, 'drive.google.com') !== false) {
        preg_match('/\/file\/d\/([^\/]+)/', $url, $matches);
        return isset($matches[1]) ? 'https://drive.google.com/file/d/' . $matches[1] . '/preview' : '';
    }

    return '';
}
    private function _uploadImage()
    {
        $config['upload_path'] = './assets/materi_video';
        $config['allowed_types'] = 'mp4|mkv';
        $config['file_name'] = $this->product_id;
        $config['overwrite'] = true;
        $config['max_size'] = 0; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->data("file_name");
        }

        return "default.mp4";
    }

    public function data_materi()
{
    $this->load->model('m_materi');
    
    // Ambil NIP guru yang login dari session
    $nip = $this->session->userdata('nip');
    
    // Ambil data guru
    $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
    $data['materi_grouped'] = [];

foreach ($this->M_materi->tampil_materi_guru($nip) as $row) {
    $key = $row->nama_mapel . ' - ' . $row->nama_kelas;
    $data['materi_grouped'][$key][] = $row;
}

    // Ambil materi yang hanya dibuat oleh guru ini
    $data['materi'] = $this->m_materi->tampil_materi_guru($nip);
    
    $this->load->view('guru/navug');
    $this->load->view('guru/data_materi', $data);
    $this->load->view('guru/footg');
}

public function update_materi($id)
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required|numeric');
    $this->form_validation->set_rules('id_kelas', 'Kelas', 'required|numeric');
    $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required|numeric');
    $this->load->model(['M_materi', 'Forum_model', 'Quiz_model']);

    if ($this->form_validation->run() == false) {
        $nip = $this->session->userdata('nip');
        $data['user'] = $this->db->get_where('guru', ['nip' => $nip])->row_array();
        $data['materi'] = $this->M_materi->get_materi_by_ids($id);
        $data['kelas'] = $this->db->get('kelas')->result();
        $this->load->view('guru/navug');
        $this->load->view('guru/update_materi', $data);
        $this->load->view('guru/footg');
    } else {
        $this->load->library('upload');
        $nip = $this->session->userdata('nip');

        $id_mapel   = $this->input->post('id_mapel');
        $id_kelas   = $this->input->post('id_kelas');
        $pertemuan  = $this->input->post('pertemuan');

        // ✅ VALIDASI: Cek duplikat pertemuan di tabel 'pertemuan'
        $this->db->select('pertemuan.id');
        $this->db->from('pertemuan');
        $this->db->join('materi', 'materi.id = pertemuan.id_materi');
        $this->db->where([
            'pertemuan.pertemuan_ke' => $pertemuan,
            'materi.id_kelas'        => $id_kelas,
            'materi.id_mapel'        => $id_mapel,
            'materi.id_guru'         => $nip,
        ]);
        $this->db->where('materi.id !=', $id); // jangan validasi terhadap materi itu sendiri
        $cek_duplikat = $this->db->get()->row();

        if ($cek_duplikat) {
            $this->session->set_flashdata('error-per', 'Pertemuan ke-' . $pertemuan . ' untuk kelas dan mapel ini sudah ada.');
            redirect('guru/update_materi/' . $id);
        }

        // ✅ Upload video // fallback

        // ✅ Upload file materi
        $modul = $this->input->post('modul_lama'); // fallback
        if (!empty($_FILES['modul']['name'])) {
            $config_modul['upload_path']   = './assets/materi_modul/';
            $config_modul['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
            $config_modul['max_size']      = 2048;
            $this->upload->initialize($config_modul);

            if ($this->upload->do_upload('modul')) {
                $upload_data = $this->upload->data();
                $modul = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload file materi: ' . $this->upload->display_errors());
                redirect('guru/update_materi/' . $id);
            }
        }

        // ✅ Update tabel materi
        $data_materi = [
            'id_guru'    => $nip,
            'id_mapel'   => $id_mapel,
            'id_kelas'   => $id_kelas,
            'video'      => $this->input->post('videourl', true),
            'modul'      => $modul,
            'deskripsi'  => $this->input->post('deskripsi', true),
            'linkform'   => $this->input->post('linkform', true)
        ];
        $this->db->where('id', $id);
        $this->db->update('materi', $data_materi);

        // ✅ Update tabel pertemuan (berdasarkan id_materi)
        $this->db->where('id_materi', $id);
        $this->db->update('pertemuan', [
            'pertemuan_ke' => $pertemuan,
            'id_kelas'     => $id_kelas
        ]);

        $this->session->set_flashdata('success', 'Materi berhasil diperbarui!');
        redirect('guru');
    }
}


    
    public function materi_edit()
{
    $this->load->model('m_materi');
    $this->load->library('form_validation');

    // Validasi form input
    $this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required|numeric');
    $this->form_validation->set_rules('id_kelas', 'Kelas', 'required|numeric');
    $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required|numeric');

    if ($this->form_validation->run() == false) {
        $id = $this->input->post('id');
        $this->session->set_flashdata('error', validation_errors());
        redirect('guru/update_materi/' . $id);
        return;
    }

    // Ambil data input
    $id           = $this->input->post('id');
    $id_mapel     = $this->input->post('id_mapel');
    $id_kelas     = $this->input->post('id_kelas');
    $pertemuan_ke = $this->input->post('pertemuan');
    $nip          = $this->input->post('id_guru');
    $deskripsi    = $this->input->post('deskripsi');
    $linkform     = $this->input->post('linkform');
    $video        = $this->input->post('videourl');

    // 🔁 Validasi duplikat pertemuan
    $this->db->select('pertemuan.id');
    $this->db->from('pertemuan');
    $this->db->join('materi', 'materi.id = pertemuan.id_materi');
    $this->db->where([
        'pertemuan.pertemuan_ke' => $pertemuan_ke,
        'materi.id_kelas'        => $id_kelas,
        'materi.id_mapel'        => $id_mapel,
        'materi.id_guru'         => $nip
    ]);
    $this->db->where('materi.id !=', $id); // Hindari bentrok dengan dirinya sendiri
    $cek_duplikat = $this->db->get()->row();

    if ($cek_duplikat) {
        $this->session->set_flashdata('error-per', 'Pertemuan ke-' . $pertemuan_ke . ' sudah dipakai.');
        redirect('guru/update_materi/' . $id);
        return;
    }

    // ==================== VIDEO PROCESSING ====================
    $video_input = $this->input->post('videourl', true);
    $video_embed = '';

    if (!empty($video_input)) {
        // Step 1: Validate URL
        if (!$this->_validate_video_url($video_input)) {
            $this->session->set_flashdata('error', 'URL video tidak valid. Hanya YouTube/Vimeo/Google Drive yang didukung');
            redirect('guru/update_materi/' . $id);
            return;
        }

        // Step 2: Convert to embed URL
        $video_embed = $this->_convert_video_to_embed($video_input);
        if ($video_embed === false) {
            $this->session->set_flashdata('error', 'Gagal mengkonversi URL video');
            redirect('guru/update_materi/' . $id);
            return;
        }
    }


        $this->load->library('upload', $config);

    // ---------------- Upload Modul ----------------
    $modul = $this->input->post('modul_lama');
    if (!empty($_FILES['modul']['name'])) {
        $config['upload_path']   = './assets/materi_modul/';
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config['max_size']      = 5120;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('modul')) {
            $modul = $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('guru/update_materi/' . $id);
            return;
        }
    }

    // ---------------- Update ke tabel materi ----------------
    $data_materi = [
        'id_guru'   => $nip,
        'id_mapel'  => $id_mapel,
        'id_kelas'  => $id_kelas,
        'deskripsi' => $deskripsi,
        'linkform'  => $linkform,
        'video'     => $video_embed,
        'modul'     => $modul
    ];
    $this->m_materi->update_data(['id' => $id], $data_materi, 'materi');

    // ---------------- Update ke tabel pertemuan ----------------
    $cek_pertemuan = $this->db->get_where('pertemuan', ['id_materi' => $id])->row();

    if ($cek_pertemuan) {
        // ✅ Jika sudah ada, update
        $this->db->where('id_materi', $id);
        $this->db->update('pertemuan', [
            'pertemuan_ke' => $pertemuan_ke,
            'id_kelas'     => $id_kelas
        ]);
    } else {
        // 🆕 Jika belum ada, insert baru
        $this->db->insert('pertemuan', [
            'id_materi'    => $id,
            'id_kelas'     => $id_kelas,
            'pertemuan_ke' => $pertemuan_ke,
            'tanggal'      => date('Y-m-d')  // atau ambil dari input kalau mau custom
        ]);
    }


    $this->session->set_flashdata('success-edit', 'Materi berhasil diperbarui.');
    redirect('guru/data_materi');
}
/**
 * Validates video URL (reusable for add_materi)
 */
private function _validate_video_url($url) {
    if (empty($url)) return true;

    $allowed_domains = [
        'youtube.com',
        'youtu.be',
        'vimeo.com',
        'drive.google.com'
    ];

    // Basic URL structure check
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    // Extract domain
    $parsed = parse_url($url);
    $host = $parsed['host'] ?? '';

    // Check against whitelist
    foreach ($allowed_domains as $domain) {
        if (strpos($host, $domain) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Converts video URL to embed format (reusable for add_materi)
 */
private function _convert_video_to_embed($url) {
    $parsed = parse_url($url);
    $host = $parsed['host'] ?? '';

    // YouTube
    if (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) {
        if (strpos($host, 'youtu.be') !== false) {
            $video_id = substr($parsed['path'], 1);
        } else {
            parse_str($parsed['query'] ?? '', $query);
            $video_id = $query['v'] ?? '';
        }
        return $video_id ? 'https://www.youtube.com/embed/'.$video_id.'?rel=0' : false;
    }

    // Vimeo
    if (strpos($host, 'vimeo.com') !== false) {
        $video_id = substr($parsed['path'], 1);
        return is_numeric($video_id) ? 'https://player.vimeo.com/video/'.$video_id : false;
    }

    // Google Drive
    if (strpos($host, 'drive.google.com') !== false) {
        preg_match('/\/file\/d\/([^\/]+)/', $url, $matches);
        return isset($matches[1]) ? 'https://drive.google.com/file/d/'.$matches[1].'/preview' : false;
    }

    return false;
}
public function delete_materi($id)
{
    $this->load->model('M_materi');
    $this->load->helper('file');

    $materi = $this->db->get_where('materi', ['id' => $id])->row();

    if (!$materi) {
        $this->session->set_flashdata('error', 'Data materi tidak ditemukan.');
        redirect('guru/data_materi');
        return;
    }

    // Hapus file video jika ada
    if ($materi->video && file_exists('./assets/materi_video/' . $materi->video)) {
        unlink('./assets/materi_video/' . $materi->video);
    }

    // Hapus file modul jika ada
    if ($materi->modul && file_exists('./assets/materi_modul/' . $materi->modul)) {
        unlink('./assets/materi_modul/' . $materi->modul);
    }

    // 🔁 Hapus dulu data dari tabel 'pertemuan' yang mengacu ke materi ini
    $this->db->where('id_materi', $id);
    $this->db->delete('pertemuan');

    // Baru kemudian hapus data materi
    $this->M_materi->delete_data(['id' => $id], 'materi');

    $this->session->set_flashdata('success', 'Data materi berhasil dihapus.');
    redirect('guru/data_materi');
}




    //QUIZ
public function data_quiz()
{
    $nip = $this->session->userdata('nip');
    $quizzes = $this->Quiz_model->get_quizzes_by_guru($nip);

    $grouped = [];
    foreach ($quizzes as $q) {
        $grouped[$q->tingkat][$q->nama_mapel][$q->nama_kelas][] = $q;
    }

    $data['quizzes_grouped'] = $grouped;

    $this->load->view('guru/navug');
    $this->load->view('guru/data_quiz', $data);
    $this->load->view('guru/footg');
}


    public function buat_quiz_guru()
    {
        $this->load->model('Quiz_model');
        $nip = $this->session->userdata('nip');
        
        // Validasi form
        $this->form_validation->set_rules('id_pertemuan', 'pertemuan', 'required');
        $this->form_validation->set_rules('judul', 'Judul Quiz', 'required|max_length[100]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[500]');
        $this->form_validation->set_rules('waktu_pengerjaan', 'Waktu Pengerjaan', 'required|numeric');
        $this->form_validation->set_rules('attempts', 'Percobaan Maksimal', 'required|numeric');
        
        if ($this->form_validation->run()) {
            $quiz_data = [
                'id_pertemuan' => $this->input->post('id_pertemuan'),
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'waktu_pengerjaan' => $this->input->post('waktu_pengerjaan'),
                'attempts' => $this->input->post('attempts'),
                'shuffle_questions' => $this->input->post('shuffle_questions') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $quiz_id = $this->Quiz_model->create_quiz($quiz_data);
            
            $this->session->set_flashdata('success', 'Quiz berhasil dibuat!');
            redirect('guru/kelola_quiz/'.$quiz_id);
        }
        
        $data['materi_list'] = $this->Quiz_model->get_materi_options($nip);
        
        // Debug path view
        $view_path = APPPATH.'views/guru/add_quiz.php';
        if (!file_exists($view_path)) {
            show_error("View file not found: ".$view_path, 500, "View Error");
        }
        
        $this->load->view('guru/navug');
        $this->load->view('guru/add_quiz', $data);
        $this->load->view('guru/footg');
    }
    public function hapus_soal($id_soal)
{
    $nip = $this->session->userdata('nip'); // NIP guru dari session
    $this->load->model('Quiz_model');

    // Cek kepemilikan soal
    $soal = $this->Quiz_model->get_soal_by_id_and_guru($id_soal, $nip);
    if (!$soal) {
        $this->session->set_flashdata('error', 'Soal tidak ditemukan atau Anda tidak memiliki akses.');
        redirect('guru/data_quiz'); // halaman fallback
        return;
    }

    // Hapus soal (model akan juga menghapus jawaban terkait)
    $deleted = $this->Quiz_model->hapus_soalquiz($id_soal);
    if ($deleted) {
        $this->session->set_flashdata('success', 'Soal berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus soal.');
    }

    // Redirect kembali ke kelola quiz menggunakan quiz_id (alias di select)
    redirect('guru/kelola_quiz/'.$soal->quiz_id);
}



    // Store new quiz
    public function store() {
        $nip = $this->session->userdata('nip');
        
        // Validate form input
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('materi_id', 'Materi', 'required');
        $this->form_validation->set_rules('waktu_pengerjaan', 'Waktu Pengerjaan', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            // Verify that the materi belongs to this teacher
            $materi_id = $this->input->post('materi_id');
            $materi_options = $this->Quiz_model->get_materi_options($nip);
            $valid_materi = array_column($materi_options, 'id');
            
            if (!in_array($materi_id, $valid_materi)) {
                $this->session->set_flashdata('error', 'Materi tidak valid');
                redirect('guru/data_quiz');
            }
            
            $data = [
                'materi_id' => $materi_id,
                'judul' => $this->input->post('judul'),
                'deskripsi' => $this->input->post('deskripsi'),
                'waktu_pengerjaan' => $this->input->post('waktu_pengerjaan'),
                'attempts' => $this->input->post('attempts'),
                'shuffle_questions' => $this->input->post('shuffle_questions') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->Quiz_model->create_quiz($data)) {
                $this->session->set_flashdata('success', 'Quiz berhasil dibuat');
                redirect('guru/data_quiz');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat quiz');
                redirect('guru/add_quiz');
            }
        }
    }

    // Edit quiz form
    public function edit_quiz($id) {
        $nip = $this->session->userdata('nip');
        $data['quizzes'] = $this->Quiz_model->get_quizzes_by_guru($nip);
        $data['quiz'] = $this->Quiz_model->get_quiz_by_guru($id, $nip);
        $data['materi_options'] = $this->Quiz_model->get_materi_options($nip);
        
        if (empty($data['quiz'])) {
            show_404();
        }
        $this->load->view('guru/navug');
        $this->load->view('guru/update_quiz', $data);
        $this->load->view('guru/footg');
    }
    // Update quiz
public function update($id) {
    $nip = $this->session->userdata('nip');

    // Pastikan ini request POST, kalau bukan redirect ke edit
    if ($this->input->method() !== 'post') {
        redirect('guru/edit_quiz/'.$id);
        return;
    }

    // Verifikasi kepemilikan quiz oleh guru
    $quiz = $this->Quiz_model->get_quiz_by_guru($id, $nip);
    if (empty($quiz)) {
        show_404();
    }

    // Validasi form lengkap
    $this->form_validation->set_rules('judul', 'Judul', 'required');
    $this->form_validation->set_rules('waktu_pengerjaan', 'Waktu Pengerjaan', 'required|numeric');
    $this->form_validation->set_rules('attempts', 'Percobaan Maksimal', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
        // Tampilkan ulang form edit dengan error
        return $this->edit_quiz($id);
    } 

    // Ambil data dari input POST
    $data = [
        'judul' => $this->input->post('judul'),
        'deskripsi' => $this->input->post('deskripsi'),
        'waktu_pengerjaan' => $this->input->post('waktu_pengerjaan'),
        'attempts' => $this->input->post('attempts'),
        'shuffle_questions' => $this->input->post('shuffle_questions') ? 1 : 0,
    ];

    // Update data di model
    if ($this->Quiz_model->update_quiz($id, $nip, $data)) {
        $this->session->set_flashdata('success', 'Quiz berhasil diperbarui');
    } else {
        $this->session->set_flashdata('error', 'Gagal memperbarui quiz');
    }

    // Redirect kembali ke daftar quiz
    redirect('guru/data_quiz');
}

    public function kelola_quiz($quiz_id)
{
    $this->load->model('Quiz_model');
    
    // Tambahkan soal baru
    if ($this->input->post('pertanyaan')) {
        $this->tambah_soal($quiz_id);
    }
    
    $data['quiz'] = $this->Quiz_model->get_quiz_with_questions($quiz_id);
    
    if(empty($data['quiz'])) {
        show_404();
    }
    
    
    $this->load->view('guru/navug');  
    $this->load->view('guru/kelola_quiz', $data);
    $this->load->view('guru/footg');
}
private function tambah_soal($quiz_id)
{
    $this->load->model('Quiz_model');

    // Ambil input
    $tipe = $this->input->post('tipe');
    $pertanyaan = trim($this->input->post('pertanyaan'));
    $poin = (int) $this->input->post('poin', true);

    // Validasi minimal
    if (empty($pertanyaan) || $poin <= 0) {
        $this->session->set_flashdata('error', 'Pertanyaan dan poin wajib diisi.');
        return;
    }

    $data = [
        'quiz_id' => $quiz_id,
        'pertanyaan' => $pertanyaan,
        'tipe' => $tipe,
        'poin' => $poin ?: 1
    ];

    if ($tipe == 'pilihan') {
        $opsi_a = trim($this->input->post('opsi_a'));
        $opsi_b = trim($this->input->post('opsi_b'));
        $opsi_c = trim($this->input->post('opsi_c'));
        $opsi_d = trim($this->input->post('opsi_d'));
        $jawaban = $this->input->post('jawaban');

        // Validasi pilihan ganda
        if (empty($opsi_a) || empty($opsi_b) || empty($opsi_c) || empty($opsi_d)) {
            $this->session->set_flashdata('error', 'Semua opsi dan jawaban benar wajib diisi.');
            return;
        }

        $data['opsi_a'] = $opsi_a;
        $data['opsi_b'] = $opsi_b;
        $data['opsi_c'] = $opsi_c;
        $data['opsi_d'] = $opsi_d;
        $data['jawaban'] = $jawaban;
    }

    $this->Quiz_model->tambah_soal($data);
    $this->session->set_flashdata('success', 'Soal berhasil ditambahkan!');
}


    // Delete quiz
    public function delete($id) {
        $nip = $this->session->userdata('nip');
        
        if ($this->Quiz_model->delete_quiz($id, $nip)) {
            $this->session->set_flashdata('success', 'Quiz berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus quiz');
        }
        
        redirect('quiz');
    }
    public function lihat_tugas($id_pertemuan) {
        $data['submissions'] = $this->Tugas_model->get_submissions($id_pertemuan);
        $this->load->view('guru/navug'); 
        $this->load->view('guru/lihat_tugas', $data);
        $this->load->view('guru/footg');
    }

    // Beri nilai/catatan
    public function beri_nilai($submission_id) {
        $this->form_validation->set_rules('nilai', 'Nilai', 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        
        if ($this->form_validation->run()) {
            $data = [
                'nilai' => $this->input->post('nilai'),
                'catatan' => $this->input->post('catatan')
            ];
            
            if ($this->Tugas_model->update_nilai($submission_id, $data)) {
                $this->session->set_flashdata('success', 'Nilai berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui nilai');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function delete_quiz($id)
    {
        $this->load->model('Quiz_model');
        
        // Pastikan $id adalah integer, bukan array
        $id = (int) $id;
    
        $this->Quiz_model->delete_quiz($id);
        $this->session->set_flashdata('success', 'Quiz berhasil dihapus.');
        redirect('guru/data_quiz'); // sesuaikan dengan route kamu
    }
    

    public function data_pesertaquiz($quiz_id) {
    $nip = $this->session->userdata('nip');
    $data['pesertaquiz'] = $this->Quiz_model->get_pesertaquiz($quiz_id, $nip);
    
    $this->load->view('guru/navug'); 
    $this->load->view('guru/data_pesertaquiz', $data);
    $this->load->view('guru/footg');
}
public function delete_pesertaquiz($id) {
    $this->load->model('Quiz_model');

    // Optional: Cek apakah data ada sebelum hapus
    $quiz = $this->db->get_where('quiz_siswa', ['id' => $id])->row();

    if ($quiz) {
        $this->Quiz_model->delete_quiz_siswa($id);
        $this->session->set_flashdata('success', 'Data quiz siswa berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Data quiz siswa tidak ditemukan.');
    }

    // Redirect ke halaman sebelumnya atau halaman daftar peserta
    redirect($_SERVER['HTTP_REFERER']); 
}


    // Hapus tugas (oleh admin/guru)
    public function hapus_tugas($id)
    {
        // Pastikan ID valid
        if (!is_numeric($id)) {
            show_404();
        }
    
        // Hapus tugas dari tabel 'tugas'
        $this->db->where('id', $id);
        $this->db->delete('tugas_siswa');
    
        // Cek jika penghapusan sukses
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Tugas berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tugas.');
        }
    
        // Redirect kembali ke halaman tugas
        redirect($_SERVER['HTTP_REFERER']);
    }
    
public function daftar_tugas() {
    $this->load->model('Tugas_model');
$guru_id = $this->session->userdata('nip');
$data['materi_list'] = [];

$pertemuan_list = $this->Tugas_model->get_pertemuan_by_gurus($guru_id);

foreach ($pertemuan_list as $row) {
    $tugas = $this->Tugas_model->get_tugas_per_materi($row->id_pertemuan, $guru_id);

    $tingkat = $row->tingkat;
    $mapel = $row->nama_mapel;
    $kelas = $row->nama_kelas;

    $data['materi_list'][$tingkat][$mapel][$kelas][] = [
        'pertemuan_ke' => $row->pertemuan_ke,
        'judul_materi' => $row->judul_materi,
        'tugas' => $tugas
    ];
}


    $this->load->view('guru/navug'); 
    $this->load->view('guru/daftar_tugas_siswa', $data);
    $this->load->view('guru/footg');
}

public function download_tugas($id)
{
    $this->load->model('Tugas_model');

    $tugas = $this->Tugas_model->get_tugas_by_id($id);

    if (!$tugas) {
        show_404(); // Tidak ditemukan
        return;
    }

    $path = FCPATH . $tugas->file_path;
    $original_name = $tugas->original_filename;

    if (file_exists($path)) {
        $this->load->helper('download');
        force_download($original_name, file_get_contents($path));
    } else {
        $this->session->set_flashdata('error', 'File tidak ditemukan.');
        redirect($_SERVER['HTTP_REFERER']);
    }
}


    public function edit_profile()
{
    $nip = $this->session->userdata('nip');
    $data['guru'] = $this->db->get_where('guru', ['nip' => $nip])->row();

    $this->load->view('guru/navug');
    $this->load->view('guru/profile', $data);
    $this->load->view('guru/footg');
}

    
public function update_profile()
{
    $nip = $this->input->post('nip');
    $nama_guru = $this->input->post('nama_guru');
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $this->form_validation->set_rules('nama_guru', 'Nama Guru', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    if (!empty($password)) {
        $this->form_validation->set_rules('password', 'Password', 'min_length[8]');
    }

    // Jalankan validasi form
    if ($this->form_validation->run() == FALSE) {
        $data['guru'] = $this->db->get_where('guru', ['nip' => $nip])->row();
        $this->load->view('guru/navug');
        $this->load->view('guru/profile', $data);
        $this->load->view('guru/footg');
        return;
    }

    // Cek email sudah dipakai guru lain
    $emailCheck = $this->db->get_where('guru', [
        'email' => $email,
        'nip !=' => $nip
    ])->row();

    if ($emailCheck) {
        $this->session->set_flashdata('error', 'Email sudah digunakan oleh guru lain.');
        redirect('guru/edit_profile');
        return;
    }

    // Siapkan data update
    $updateData = [
        'nama_guru' => $nama_guru,
        'email' => $email
    ];

    if (!empty($password)) {
        $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    // Simpan perubahan
    $this->M_siswa->update_profile_guru($nip, $updateData);
    $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
    redirect('guru/edit_profile');
}



    
    public function email_check($email)
    {
        $nip = $this->input->post('nip');
        $this->db->where('email', $email);
        $this->db->where('nip !=', $nip); // pengecualian untuk dirinya sendiri
        $query = $this->db->get('guru');
    
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'Email ini sudah digunakan oleh siswa lain.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
public function tambah_ujian()
{
$nip = $this->session->userdata('nip');
$guru = $this->db->get_where('guru', ['nip' => $nip])->row();

if (!$guru) {
    $this->session->set_flashdata('error', 'Data guru tidak ditemukan. Silahkan login ulang.');
    redirect('login');
    return;
}

$guru_id = $guru->nip; // kolom yang ada di tabel guru
$mapel_guru = $this->db->get_where('guru_mapel', ['id_guru' => $guru_id])->result();
// sesuaikan kolom
$mapel_guru = $this->db->get_where('guru_mapel', ['id_guru' => $guru_id])->result();


    // Ambil semua soal untuk setiap mapel guru
    $bank_soal = [];
    foreach ($mapel_guru as $mg) {
        $soal = $this->Bank_soal_model->get_soal_by_mapel($mg->id_mapel);
        $bank_soal = array_merge($bank_soal, $soal);
    }

    // Ambil data materi (sesuaikan model)
    $materi_list = $this->Ujian_model->get_materi_options($nip);

    // Kirim ke view
    $data = [
        'guru' => $guru,
        'bank_soal' => $bank_soal,
        'materi_list' => $materi_list,
        'title' => 'Tambah Ujian Baru'
    ];

    $this->load->view('guru/navug', $data); 
    $this->load->view('guru/add_ujian', $data);
    $this->load->view('guru/footg');
}

public function get_soal_by_pertemuan_ajax()
{
    $id_pertemuan = $this->input->post('id_pertemuan');

    $this->db->select('bank_soal.*, mata_pelajaran.nama_mapel');
    $this->db->from('bank_soal');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = bank_soal.id_mapel');
    $this->db->join('materi', 'materi.id_mapel = mata_pelajaran.id');
    $this->db->join('pertemuan', 'pertemuan.id_materi = materi.id');
    $this->db->where('pertemuan.id', $id_pertemuan);
    $this->db->group_by('bank_soal.id_soal'); // untuk jaga-jaga jika join menimbulkan duplikat
    $this->db->order_by('bank_soal.created_at', 'DESC');

    $soal = $this->db->get()->result();

    echo json_encode($soal);
}

public function simpan_ujian()
{
    $this->form_validation->set_rules('nama_ujian', 'Nama Ujian', 'required');
    $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
    $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
    $this->form_validation->set_rules('durasi', 'Durasi', 'required|numeric');

    if ($this->form_validation->run() === FALSE) {
        $this->tambah_ujian();
        return;
    }

    $this->db->trans_start();

    try {
        $bobot_pg = intval($this->input->post('bobot_pg'));
        $bobot_essay = intval($this->input->post('bobot_essay'));

        if (($bobot_pg + $bobot_essay) !== 100) {
            $this->session->set_flashdata('error', 'Total bobot PG + Essay harus 100%.');
            $this->tambah_ujian(); return;
        }

        // Data utama ujian
        $ujian_data = [
            'nama_ujian'      => $this->input->post('nama_ujian'),
            'tanggal_mulai'   => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
            'durasi'          => $this->input->post('durasi'),
            'status'          => $this->input->post('status') ?? 'aktif',
            'id_pertemuan'       => $this->input->post('id_pertemuan'),
            'nip_guru'        => $this->session->userdata('nip'),
            'bobot_pg'        => $bobot_pg,
            'bobot_essay'     => $bobot_essay
        ];

        // Simpan ujian
        $this->db->insert('tbl_ujian', $ujian_data);
        $ujian_id = $this->db->insert_id();

        // Cek apakah menggunakan bank soal
        if ($this->input->post('sumber_soal') === 'bank_soal') {
            $soal_ids = $this->input->post('soal_ids');

            if (empty($soal_ids)) {
                throw new Exception('Pilih minimal 1 soal dari bank soal');
            }

            foreach ($soal_ids as $soal_id) {
                $soal_exists = $this->db->where('id_soal', $soal_id)
                                        ->count_all_results('bank_soal') > 0;
                if (!$soal_exists) {
                    throw new Exception('Soal dengan ID ' . $soal_id . ' tidak ditemukan di bank soal');
                }

                // Simpan ke tabel ujian_soal dengan sumber
                $this->db->insert('ujian_soal', [
                    'ujian_id' => $ujian_id,
                    'soal_id'  => null,
                    'bank_soal_id' => $soal_id,
                    'sumber'   => 'bank_soal'
                ]);
            }
        }

        $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Gagal menyimpan ujian');
            }

        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Gagal menyimpan data ujian.');
        }

        $this->session->set_flashdata('success', 'Ujian berhasil dibuat.');
        
    } catch (Exception $e) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('error', $e->getMessage());
        $this->tambah_ujian();
        return;
    }

    redirect('guru/tampilkan_soal/' . $ujian_id);
}

    // Menampilkan form untuk tambah soal
    public function tambah_soal_ujian($id_ujian)
    {
        $data['id_ujian'] = $id_ujian;
        $this->load->view('guru/navug'); 
        $this->load->view('guru/tambah_soal', $data);
        $this->load->view('guru/footg');
    }

    // Menyimpan soal ke database
    public function simpan_soal()
{
    $ujian_id = $this->input->post('id_ujian');

    // Data soal pribadi
    $soal_data = [
        'id_ujian' => $this->input->post('id_ujian'),
        'pertanyaan'     => $this->input->post('pertanyaan'),
        'pilihan_a'      => $this->input->post('pilihan_a'),
        'pilihan_b'      => $this->input->post('pilihan_b'),
        'pilihan_c'      => $this->input->post('pilihan_c'),
        'pilihan_d'      => $this->input->post('pilihan_d'),
        'kunci_jawaban'  => $this->input->post('kunci_jawaban'), // Anda bisa sesuaikan// Default, atau bisa dari input// Jika Anda menyimpan guru
    ];

    // Simpan ke tbl_soal
    $this->db->insert('tbl_soal', $soal_data);
    $soal_id = $this->db->insert_id(); // AMBIL ID soal yang baru dimasukkan

    // Simpan relasi ke tabel ujian_soal
    $this->db->insert('ujian_soal', [
        'ujian_id' => $ujian_id,
        'soal_id'  => $soal_id,
        'bank_soal_id' => null,
        'sumber'   => 'tbl_soal'
    ]);

    // Redirect kembali ke halaman lihat soal
    $this->session->set_flashdata('success', 'Soal pribadi berhasil ditambahkan ke ujian.');
    redirect('guru/tampilkan_soal/' . $ujian_id);
}

    // Menampilkan daftar ujian yang dibuat oleh guru
public function tampilkan_ujian()
{
    $nip = $this->session->userdata('nip');
    echo "NIP dari session: " . $nip . "<br>"; // Debug session
    
    $ujian_raw = $this->Ujian_model->get_ujian_by_gurus($nip);

    $ujian_raw = $this->Ujian_model->get_ujian_by_gurus($nip);

    $data['ujian_terstruktur'] = [];

    if (!empty($ujian_raw)) {
        foreach ($ujian_raw as $u) {
            // Pastikan field ini ada di hasil query
            $tingkat = isset($u['tingkat']) ? $u['tingkat'] : 'Unknown';
            $mapel = isset($u['nama_mapel']) ? $u['nama_mapel'] : 'Unknown';
            $kelas = isset($u['nama_kelas']) ? $u['nama_kelas'] : 'Unknown';
            
            $data['ujian_terstruktur'][$tingkat][$mapel][$kelas][] = $u;
        }
    } else {
        $data['error'] = "Tidak ada data ujian ditemukan";
    }

    $this->load->view('guru/navug'); 
    $this->load->view('guru/data_ujian', $data);
    $this->load->view('guru/footg');
}

    // Menampilkan soal berdasarkan ujian
    public function tampilkan_soal($ujian_id)
{
    // Ambil data soal dari bank_soal
    $this->db->select('us.*, bs.pertanyaan, bs.pilihan_a, bs.pilihan_b, bs.pilihan_c, bs.pilihan_d');
    $this->db->from('ujian_soal us');
    $this->db->join('bank_soal bs', 'bs.id_soal = us.bank_soal_id');
    $this->db->where('us.ujian_id', $ujian_id);
    $this->db->where('us.sumber', 'bank_soal');
    $bank_soal = $this->db->get()->result();

    // Ambil data soal dari soal pribadi guru
    $this->db->select('us.*, ts.pertanyaan, ts.pilihan_a, ts.pilihan_b, ts.pilihan_c, ts.pilihan_d');
    $this->db->from('ujian_soal us');
    $this->db->join('tbl_soal ts', 'ts.id_soal = us.soal_id');
    $this->db->where('us.ujian_id', $ujian_id);
    $this->db->where('us.sumber', 'tbl_soal');
    $pribadi_soal = $this->db->get()->result();

    $data['ujian_id'] = $ujian_id;
    $data['bank_soal'] = $bank_soal;
    $data['pribadi_soal'] = $pribadi_soal;

    $this->load->view('guru/navug');
    $this->load->view('guru/tampil_soal', $data);
    $this->load->view('guru/footg');
}


    public function edit_ujian($id_ujian)
{
    // Pastikan user sudah login
    $nip = $this->session->userdata('nip');
    
    // Ambil data ujian berdasarkan id
    $ujian = $this->Ujian_model->get_ujian_by_id($id_ujian);
    
    // Pastikan ujian ditemukan
    if ($ujian) {
        // Ambil daftar materi untuk pilihan pada dropdown
        $data['materi_list'] = $this->Ujian_model->get_materi_optionss($nip);
        // Kirim data ujian dan materi ke view
        $data['ujian'] = $ujian;
        $this->load->view('guru/navug');
        $this->load->view('guru/edit_ujian', $data);
        $this->load->view('guru/footg');
    } else {
        // Jika ujian tidak ditemukan, redirect ke halaman sebelumnya atau halaman error
        redirect('guru/data_ujian');
    }
}

public function simpan_edit_ujian($id_ujian)
{
    $bobot_pg = intval($this->input->post('bobot_pg'));
    $bobot_essay = intval($this->input->post('bobot_essay'));

    if (($bobot_pg + $bobot_essay) !== 100) {
            $this->session->set_flashdata('error', 'Total bobot PG + Essay harus 100%.');
            $this->tambah_ujian(); return;
    }

    // Ambil data dari form
    $data = array(
        'nama_ujian' => $this->input->post('nama_ujian'),
        'tanggal_mulai' => $this->input->post('tanggal_mulai'),
        'tanggal_selesai' => $this->input->post('tanggal_selesai'),
        'durasi' => $this->input->post('durasi'),
        'status' => $this->input->post('status'),
        'id_pertemuan' => $this->input->post('id_pertemuan'),
        'bobot_pg'        => $bobot_pg,
        'bobot_essay'     => $bobot_essay
    );
    
    // Simpan perubahan data ujian
    $this->Ujian_model->update_ujian($id_ujian, $data);

    // Redirect ke daftar ujian atau halaman lainnya
    redirect('guru/tampilkan_ujian');
}

    // Mengedit soal
    public function edit_soal($id_soal)
    {
        $soal = $this->Ujian_model->get_soal_by_id($id_soal);
        if ($this->input->post()) {
            $data = [
                'pertanyaan' => $this->input->post('pertanyaan'),
                'pilihan_a' => $this->input->post('pilihan_a'),
                'pilihan_b' => $this->input->post('pilihan_b'),
                'pilihan_c' => $this->input->post('pilihan_c'),
                'pilihan_d' => $this->input->post('pilihan_d'),
                'kunci_jawaban' => $this->input->post('kunci_jawaban')
            ];

            if ($this->Ujian_model->edit_soal($id_soal, $data)) {
                redirect('guru/tampilkan_soal/' . $soal['id_ujian']);
            } else {
                echo "Gagal mengedit soal.";
            }
        } else {
            $this->load->view('guru/navug');
            $this->load->view('guru/edit_soal', ['soal' => $soal]);
            $this->load->view('guru/footg');
        }
    }

    // Menghapus soal
public function hapus_ujian($id_ujian)
{
    $this->load->model('Ujian_model');

    if ($this->Ujian_model->hapus_ujian($id_ujian)) {
        $this->session->set_flashdata('success', 'Ujian berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus ujian.');
    }

    redirect('guru/tampilkan_ujian'); // ganti sesuai halaman daftar ujian kamu
}



    
    // BANK SOAL - GURU
public function bank_soal()
{
    $nip = $this->session->userdata('nip');

    $this->db->select('
        bank_soal.*,
        mata_pelajaran.nama_mapel,
        IF(bank_soal.user_type = "guru", guru.nama_guru, "Admin") AS pembuat
    ');
    $this->db->from('bank_soal');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = bank_soal.id_mapel', 'left');
    $this->db->join('guru', 'guru.nip = bank_soal.created_by AND bank_soal.user_type = "guru"', 'left');
    $this->db->order_by('bank_soal.id_soal', 'DESC');

    $data['bank_soal'] = $this->db->get()->result();

    // Ambil daftar mapel yang diajarkan guru ini
    $data['mapel_diajarkan'] = $this->Bank_soal_model->get_mapel_by_nip($nip);

    $this->load->view('guru/navug');
    $this->load->view('guru/bank_soal', $data);
    $this->load->view('guru/footg');
}






public function add_bank_soal()
{
    $data['title'] = 'Tambah Soal';

    // Ambil semua mata pelajaran dari guru yang sedang login
    $nip = $this->session->userdata('nip');
    $this->db->select('mata_pelajaran.id, mata_pelajaran.nama_mapel');
    $this->db->from('guru_mapel');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.id = guru_mapel.id_mapel');
    $this->db->where('guru_mapel.id_guru', $nip);
    $data['list_mapel'] = $this->db->get()->result();

    // Validasi
    $this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required');
    $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');
    $this->form_validation->set_rules('tipe_soal', 'Tipe Soal', 'required');

    if ($this->input->post('tipe_soal') == 'pilihan') {
        $this->form_validation->set_rules('kunci_jawaban', 'Kunci Jawaban', 'required');
    }

    if ($this->form_validation->run() === FALSE) {
        $this->load->view('guru/navug', $data);
        $this->load->view('guru/add_bank_soal', $data);
        $this->load->view('guru/footg');
    } else {
        $post_data = $this->input->post();
        $data_insert = [
            'pertanyaan' => $post_data['pertanyaan'],
            'tipe_soal' => $post_data['tipe_soal'],
            'tingkat_kesulitan' => $post_data['tingkat_kesulitan'],
            'tipe_kognitif' => $post_data['tipe_kognitif'],
            'created_by' => $nip,
            'user_type' => 'guru',
            'id_mapel' => $post_data['id_mapel']
        ];

        if ($post_data['tipe_soal'] == 'pilihan') {
            $data_insert['pilihan_a'] = $post_data['pilihan_a'];
            $data_insert['pilihan_b'] = $post_data['pilihan_b'];
            $data_insert['pilihan_c'] = $post_data['pilihan_c'];
            $data_insert['pilihan_d'] = $post_data['pilihan_d'];
            $data_insert['kunci_jawaban'] = $post_data['kunci_jawaban'];
        }

        $this->Bank_soal_model->tambah_soal($data_insert);
        $this->session->set_flashdata('success', 'Soal berhasil ditambahkan');
        redirect('guru/bank_soal');
    }
}

    
public function edit_bank_soal($id_soal)
{
    if (!is_numeric($id_soal)) {
        show_404();
    }

    $soal = $this->Bank_soal_model->get_detail_soal($id_soal);
    
    if (!$soal) {
        show_404();
    }

    // Cek: Jika soal bukan milik guru (admin atau guru lain), tolak edit
    if ($soal->user_type === 'admin') {
        $this->session->set_flashdata('error', 'Soal ini dibuat oleh admin dan tidak dapat diedit oleh guru');
        redirect('guru/bank_soal');
    }

    // Cek: Jika soal dibuat guru lain
    if ($soal->user_type === 'guru' && $soal->created_by != $this->guru_data->nip) {
        $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengedit soal ini');
        redirect('guru/bank_soal');
    }

    $data = [
        'title' => 'Edit Soal',
        'soal' => $soal,
        'mapel_diajar' => $this->Bank_soal_model->get_mapel_by_nips($this->session->userdata('nip')),
        'kategori' => $this->Bank_soal_model->get_kategori(),
        'id_mapel' => $this->guru_data->id_mapel
    ];

    $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');
    $this->form_validation->set_rules('tipe_soal', 'Tipe Soal', 'required|in_list[pilihan,essay]');

    if ($this->input->post('tipe_soal') === 'pilihan') {
        $this->form_validation->set_rules('pilihan_a', 'Pilihan A', 'required');
        $this->form_validation->set_rules('pilihan_b', 'Pilihan B', 'required');
        $this->form_validation->set_rules('pilihan_c', 'Pilihan C', 'required');
        $this->form_validation->set_rules('pilihan_d', 'Pilihan D', 'required');
        $this->form_validation->set_rules('kunci_jawaban', 'Kunci Jawaban', 'required|in_list[a,b,c,d]');
    }

    if ($this->form_validation->run() === FALSE) {
        $this->load->view('guru/navug', $data);
        $this->load->view('guru/edit_bank_soal', $data);
        $this->load->view('guru/footg');
    } else {
        $post_data = $this->input->post();
        $update_data = [
            'id_mapel' => $post_data['id_mapel'],
            'pertanyaan' => $post_data['pertanyaan'],
            'tipe_soal' => $post_data['tipe_soal'],
            'tingkat_kesulitan' => $post_data['tingkat_kesulitan'],
            'tipe_kognitif' => $post_data['tipe_kognitif'],
        ];

        if ($post_data['tipe_soal'] === 'pilihan') {
            $update_data['pilihan_a'] = $post_data['pilihan_a'];
            $update_data['pilihan_b'] = $post_data['pilihan_b'];
            $update_data['pilihan_c'] = $post_data['pilihan_c'];
            $update_data['pilihan_d'] = $post_data['pilihan_d'];
            $update_data['kunci_jawaban'] = $post_data['kunci_jawaban'];
        } else {
            $update_data['pilihan_a'] = null;
            $update_data['pilihan_b'] = null;
            $update_data['pilihan_c'] = null;
            $update_data['pilihan_d'] = null;
            $update_data['kunci_jawaban'] = null;
        }

        if ($this->Bank_soal_model->update_soal($id_soal, $update_data)) {
            $this->session->set_flashdata('success', 'Soal berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui soal');
        }
        redirect('guru/bank_soal');
    }
}


    
    public function hapus_bank_soal($id_soal) {
        // Cek kepemilikan soal
        $soal = $this->Bank_soal_model->get_detail_soal($id_soal);
        
        if (!$soal || 
            $soal->created_by != $this->guru_data->nip || 
            $soal->user_type != 'guru' ||
            $soal->id_mapel != $this->guru_data->id_mapel) {
            show_error('Anda tidak memiliki akses untuk menghapus soal ini', 403);
        }
        
        $this->Bank_soal_model->hapus_soal($id_soal);
        $this->session->set_flashdata('success', 'Soal berhasil dihapus');
        redirect('guru/bank_soal');
    }

    public function buat_ujian() {
        // Ambil mapel yang diajarkan guru
        $nip = $this->session->userdata('nip');
        $guru = $this->db->get_where('guru', ['nip' => $nip])->row();
        
        $data['title'] = 'Buat Ujian';
        $data['mapel'] = $guru->nama_mapel;
        $data['bank_soal'] = $this->Bank_soal_model->get_soal_by_mapel($guru->nama_mapel);
        
        $this->load->view('guru/navug', $data);
        $this->load->view('guru/buat_ujian', $data);
        $this->load->view('guru/footg');
    }
    
    public function simpan_ujian_bk() {
        $this->form_validation->set_rules('judul_ujian', 'Judul Ujian', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu Pengerjaan', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $this->buat_ujian();
        } else {
            // Simpan data ujian
            $ujian_data = [
                'judul' => $this->input->post('judul_ujian'),
                'mapel' => $this->input->post('mapel'),
                'waktu' => $this->input->post('waktu'),
                'guru_id' => $this->session->userdata('nip'),
                'soal_source' => 'bank_soal',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('tbl_ujian', $ujian_data);
            $ujian_id = $this->db->insert_id();
            
            // Hubungkan soal yang dipilih
            $soal_ids = $this->input->post('soal_ids');
            foreach ($soal_ids as $soal_id) {
                $this->db->insert('ujian_soal', [
                    'ujian_id' => $ujian_id,
                    'soal_id' => $soal_id
                ]);
            }
            
            $this->session->set_flashdata('success', 'Ujian berhasil dibuat dari bank soal');
            redirect('guru/ujian');
        }
    }
    // application/controllers/guru/Forum_guru.php

    public function belajar($id_pertemuan) {
    $this->load->model(['M_materi', 'Forum_model', 'Quiz_model', 'Tugas_model']);
    $nip = $this->session->userdata('nip');
    $role = $this->session->userdata('user_type');
    $current_user = ($role === 'siswa') 
        ? $this->session->userdata('nis') 
        : $this->session->userdata('nip');

    $data['materi'] = $this->M_materi->get_materi_by_pertemuan($id_pertemuan); // ✅
    if (!$data['materi']) {
        show_404();
        return;
    }

    // Ambil data user
    $data['user'] = ($role === 'siswa') 
        ? $this->db->get_where('siswa', ['nis' => $current_user])->row_array()
        : $this->db->get_where('guru', ['nip' => $current_user])->row_array();

    // Ambil data forum dengan penanganan error
    $forum_data = $this->Forum_model->get_komentar_by_materi($id_pertemuan);
    $data['forum'] = is_array($forum_data) ? $forum_data : array();

    // Data tambahan
    $data['quizzes'] = $this->Quiz_model->get_quizzes_by_materi($id_pertemuan) ?: array();
    $data['materi_id'] = $this->M_materi->get_all_materi_id($nip) ?: array();
    $data['current_user'] = [
        'type' => $role,
        'identifier' => $current_user
    ];

    if ($role === 'siswa') {
        $data['tugas_saya'] = $this->Tugas_model->get_tugas_siswa($current_user, $id) ?: array();
    }

    $this->load->view('guru/navug', $data);
    $this->load->view($role . '/tampil_materi', $data);
        $this->load->view('guru/footg');
}


public function tambah_komentar() {
    $user_type = $this->session->userdata('user_type');
    $user_id = ($user_type === 'siswa') ? $this->session->userdata('nis') : $this->session->userdata('nip');

    $this->form_validation->set_rules('komentar', 'Komentar', 'required');
    $this->form_validation->set_rules('id_pertemuan', 'ID Pertemuan', 'required|numeric');
    $this->form_validation->set_rules('parent_id', 'Parent ID', 'numeric');

    if ($this->form_validation->run()) {
        $data = [
            'user_type'    => $user_type,
            'user_id'      => $user_id,
            'id_pertemuan' => $this->input->post('id_pertemuan'),
            'komentar'     => $this->input->post('komentar'),
            'parent_id'    => $this->input->post('parent_id') ?: NULL,
            'created_at'   => date('Y-m-d H:i:s')
        ];

        if ($this->Forum_model->tambah_komentar($data)) {
            $this->session->set_flashdata('success', 'Komentar berhasil ditambahkan');
            $this->session->set_flashdata('scroll_to', $this->db->insert_id());
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan komentar');
        }
    } else {
        $this->session->set_flashdata('error', validation_errors());
    }

    redirect(($user_type === 'siswa' ? 'siswa' : 'guru') . '/belajar/' . $this->input->post('id_pertemuan'));
}


    public function edit_komentar() {
        $this->form_validation->set_rules('comment_id', 'Comment ID', 'required');
        $this->form_validation->set_rules('komentar', 'Komentar', 'required|trim');

        if ($this->form_validation->run()) {
            $comment_id = $this->input->post('comment_id');
            $nip = $this->session->userdata('nip');
            
            // Verifikasi kepemilikan komentar
            $comment = $this->db->get_where('forum_diskusi', [
                'id' => $comment_id,
                'user_id' => $nip
            ])->row();

            if ($comment) {
                $this->Forum_model->edit_komentar($comment_id, [
                    'komentar' => $this->input->post('komentar'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                $this->session->set_flashdata('success', 'Komentar berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', 'Anda tidak memiliki izin mengedit komentar ini');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hapus_komentar($comment_id) {
    $user_type = $this->session->userdata('user_type');
    $user_id = ($user_type === 'guru') ? $this->session->userdata('nip') : $this->session->userdata('nis');

    // Ambil data komentar
    $comment = $this->db->get_where('forum_diskusi', ['id' => $comment_id])->row();

    // Jika komentar ditemukan
    if ($comment) {
        // ✅ Guru boleh hapus komentar siapa pun
        // ✅ Siswa hanya boleh hapus komentarnya sendiri
        if ($user_type === 'guru' || $comment->user_id == $user_id) {
            $this->Forum_model->hapus_komentar($comment_id);
            $this->session->set_flashdata('success', 'Komentar berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin menghapus komentar ini');
        }
    } else {
        $this->session->set_flashdata('error', 'Komentar tidak ditemukan');
    }

    redirect($_SERVER['HTTP_REFERER']);
}





public function daftar_nilai_essay($id_ujian = null)
{
    if (!$this->session->userdata('nip')) {
        redirect('welcome');
    }
    if (!$id_ujian) {
        show_404(); // atau redirect('guru/ujian') jika mau redirect
    }
    $nip = $this->session->userdata('nip');

    // Ambil semua jawaban essay untuk ujian ini
    $this->db->select('
        j.id_jawaban,
        j.jawaban_essay,
        j.nilai_essay,
        j.catatan_essay,
        j.id_ujian,
        j.nis,
        s.nama AS nama_siswa,
        COALESCE(ts.pertanyaan, bs.pertanyaan) AS pertanyaan,
        COALESCE(ts.tipe_soal, bs.tipe_soal) AS tipe_soal,
        u.nama_ujian
    ');
    $this->db->from('tbl_jawaban_siswa j');
    $this->db->join('siswa s', 's.nis = j.nis');
    $this->db->join('tbl_soal ts', 'ts.id_soal = j.id_soal', 'left');
    $this->db->join('bank_soal bs', 'bs.id_soal = j.bank_soal_id', 'left');
    $this->db->join('tbl_ujian u', 'u.id_ujian = j.id_ujian');

    $this->db->where('j.id_ujian', $id_ujian); // ✅ Ambil hanya jawaban ujian ini
    $this->db->where('COALESCE(ts.tipe_soal, bs.tipe_soal) =', 'essay');

    $this->db->order_by('j.id_jawaban', 'DESC');

    $data['jawaban_essay'] = $this->db->get()->result();

    $this->load->view('guru/navug', $data);
    $this->load->view('guru/data_essay', $data);
    $this->load->view('guru/footg');
}



public function beri_nilai_essay()
{
    $id_jawaban = $this->input->post('id_jawaban');
    $nilai_essay = $this->input->post('nilai_essay');
    $catatan = $this->input->post('catatan_essay');
    $id_ujian = $this->input->post('id_ujian');

    if ($id_jawaban && is_numeric($nilai_essay)) {
        $this->db->where('id_jawaban', $id_jawaban);
        $this->db->update('tbl_jawaban_siswa', [
            'nilai_essay' => $nilai_essay,
            'catatan_essay' => $catatan
        ]);

        $this->load->model('Ujian_model');
        $this->Ujian_model->update_nilai_akhir($id_jawaban);

        $this->session->set_flashdata('success', 'Nilai essay berhasil disimpan.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menyimpan nilai. Pastikan nilai valid.');
    }

    redirect('guru/daftar_nilai_essay/' . $id_ujian);
}

public function data_pesertaujian($ujian_id) {
    $this->load->model('Ujian_model');

    $data['peserta'] = $this->Ujian_model->get_peserta_ujian($ujian_id);
    $data['ujian_id'] = $ujian_id;

    $this->load->view('guru/navug');
    $this->load->view('guru/data_pesertaujian', $data);
    $this->load->view('guru/footg');
}


}