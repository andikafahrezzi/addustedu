<?php

class Forum_model extends CI_Model {
    
    public function get_komentar_by_materi($id_materi) {
        $this->db->where('materi_id', $id_materi);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('forum_diskusi')->result();
    }

    public function tambah_komentar($data) {
        return $this->db->insert('forum_diskusi', $data);
    }

    public function add_forum($data) {
        return $this->db->insert('forum', $data);
    }

    public function add_comment($data) {
        return $this->db->insert('forum_komentar', $data);
    }
}
