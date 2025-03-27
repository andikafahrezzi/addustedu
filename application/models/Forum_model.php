<?php
class Forum_model extends CI_Model {
    
    /**
     * Mendapatkan komentar beserta balasannya secara recursive
     */
    public function get_komentar_by_materi($materi_id, $parent_id = null) 
    {
        $this->db->where('materi_id', $materi_id);
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('tanggal', 'ASC');
        
        $query = $this->db->get('forum_diskusi');
        $comments = $query->result();

        if ($comments) {
            foreach ($comments as $comment) {
                // Dapatkan balasan secara recursive
                $comment->replies = $this->get_komentar_by_materi($materi_id, $comment->id);
            }
        }

        return $comments;
    }

    /**
     * Menambahkan komentar baru
     */
    public function tambah_komentar($data) {
        return $this->db->insert('forum_diskusi', $data);
    }

    /**
     * Fungsi tambahan untuk mendapatkan jumlah komentar
     */
    public function count_komentar($materi_id)
    {
        $this->db->where('materi_id', $materi_id);
        return $this->db->count_all_results('forum_diskusi');
    }
    public function hapus_forum_by_materi($materi_id) {
        // Validasi input
        if(!is_numeric($materi_id)) return false;
        
        $this->db->where('materi_id', $materi_id);
        return $this->db->delete('forum_diskusi');
    }
    
    public function get_forum_by_materi($materi_id) {
        $this->db->where('materi_id', $materi_id);
        return $this->db->get('forum_diskusi')->result();
    }
    

    // Hapus method yang tidak digunakan
    // public function add_forum() dan add_comment() bisa dihapus jika tidak digunakan
}