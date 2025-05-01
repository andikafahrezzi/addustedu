<?php
if (!function_exists('get_kategori_name')) {
    function get_kategori_name($id_kategori) {
        $CI =& get_instance();
        $CI->load->model('Bank_soal_model');
        $kategori = $CI->Bank_soal_model->get_kategori();
        
        foreach ($kategori as $k) {
            if ($k->id_kategori == $id_kategori) {
                return $k->nama_kategori;
            }
        }
        
        return 'Tidak Diketahui';
    }
}

if (!function_exists('can_edit_soal')) {
    function can_edit_soal($id_soal, $user_type, $user_id) {
        $CI =& get_instance();
        $CI->load->model('Bank_soal_model');
        $soal = $CI->Bank_soal_model->get_detail_soal($id_soal);
        
        // Admin bisa edit semua soal
        if ($user_type == 'admin') return true;
        
        // Guru hanya bisa edit soal yang dibuatnya sendiri
        return ($soal->created_by == $user_id && $soal->user_type == 'guru');
    }
}