<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {
    public function error_404()
    {
        $this->output->set_status_header('404');
        $this->load->view('errors/cli/error_404'); // ini file yang sudah kamu buat
    }
    public function test_db_error()
{
    $query = $this->db->query('SELECT * FROM tabel_yang_salah_banget');
}

}
