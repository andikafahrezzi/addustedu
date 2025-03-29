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

    public function get_comments($materi_id) {
         return $this->db
        ->select('fd.*, s.nama as user')
        ->from('forum_diskusi fd')
        ->join('siswa s', 's.nis = fd.nis')
        ->where('fd.materi_id', $materi_id)
        ->where('fd.deleted_at IS NULL')
        ->order_by('fd.created_at', 'ASC')
        ->get();
        
        return $this->build_tree($comments);
    }
    
    private function build_tree($elements, $parent_id = null) {
        $branch = array();
        foreach ($elements as $element) {
            if ($element->parent_id == $parent_id) {
                $children = $this->build_tree($elements, $element->id);
                if ($children) {
                    $element->replies = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function update_comment($id, $data) {
        // Check if user can edit (30 minutes limit)
        $comment = $this->get_comment($id);
        $now = new DateTime();
        $lastEdit = new DateTime($comment->last_edit_time ?: $comment->created_at);
        $diff = $now->diff($lastEdit);
        
        if ($diff->i < 30 && $diff->h == 0 && $diff->days == 0) {
            return false; // Not enough time passed
        }
    
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['last_edit_time'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('comments', $data);
    }
    

    // Hapus method yang tidak digunakan
    // public function add_forum() dan add_comment() bisa dihapus jika tidak digunakan
}