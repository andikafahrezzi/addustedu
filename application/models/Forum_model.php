<?php

class Forum_model extends CI_Model {
    
    public function get_komentar_by_materi($id_materi, $parent_id = NULL) {
        $this->db->where('materi_id', $id_materi);
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('tanggal', 'ASC');
        $this->db->distinct(); // Pastikan data unik
        $query = $this->db->get('forum_diskusi');
        $result = $query->result();
        

        return $result;

    }
    Public function get_komentar($materi_id, $parent_id = NULL) {
        foreach ($result as &$komen) {
            $komen->replies = $this->get_komentar($materi_id, $komen->id); // Ambil reply
        }

        
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
