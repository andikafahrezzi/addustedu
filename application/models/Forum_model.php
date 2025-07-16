<?php
class Forum_model extends CI_Model {
    
    /**
     * Mendapatkan komentar beserta balasannya secara recursive
     */
   

    /**
     * Menambahkan komentar baru
    

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
    
    public function get_forum_by_materi($id_pertemuan) {
        $this->db->where('id_pertemuan', $id_pertemuan);
        return $this->db->get('forum_diskusi')->result();
    }

public function get_comments($id_pertemuan) {
    $this->db->select('fd.*, 
        IF(fd.user_type = "siswa", s.nama, g.nama_guru) as user,
        fd.user_type');
    $this->db->from('forum_diskusi fd');
    $this->db->join('siswa s', 'fd.user_type = "siswa" AND s.nis = fd.user_id', 'left');
    $this->db->join('guru g', 'fd.user_type = "guru" AND g.nip = fd.user_id', 'left');
    $this->db->where('fd.id_pertemuan', $id_pertemuan); // ✅ perbaikan di sini
    $this->db->where('fd.deleted_at IS NULL');
    $this->db->order_by('fd.created_at', 'ASC');
    $query = $this->db->get();

    $comments = $query->result();
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
public function get_comment($id) {
    $this->db->select('fd.*, 
        IF(fd.user_type = "siswa", s.nama, g.nama_guru) as user,
        fd.user_type');
    $this->db->from('forum_diskusi fd');
    $this->db->join('siswa s', 'fd.user_type = "siswa" AND s.nis = fd.user_id', 'left');
    $this->db->join('guru g', 'fd.user_type = "guru" AND g.nip = fd.user_id', 'left');
    $this->db->where('fd.id', $id);
    return $this->db->get()->row();
}

public function can_edit_comment($comment_id, $user_type, $user_id) {
    if (empty($comment_id) || empty($user_type) || empty($user_id)) {
        return false;
    }

    $comment = $this->get_comment($comment_id);
    
    if (!$comment || !is_object($comment)) {
        return false;
    }

    // Guru bisa edit semua komentar atau hanya miliknya sendiri
    // Siswa hanya bisa edit komentar mereka sendiri
log_message('debug', 'UserType: ' . $user_type . ', UserID: ' . $user_id . ', CommentID: ' . $comment_id);
    return ($user_type === 'guru') || 
           (property_exists($comment, 'user_type') && 
            property_exists($comment, 'user_id') &&
            $comment->user_type === $user_type && 
            $comment->user_id == $user_id);
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
   
  public function get_komentar_by_materi($id_pertemuan) {
    // Ambil semua komentar untuk materi ini sekaligus
    $this->db->select('fd.*, 
        IF(fd.user_type = "siswa", s.nama, g.nama_guru) as user_name,
        fd.user_type,
        s.image as siswa_foto,
        g.image as guru_foto');
    $this->db->from('forum_diskusi fd');
    $this->db->join('siswa s', 'fd.user_type = "siswa" AND s.nis = fd.user_id', 'left');
    $this->db->join('guru g', 'fd.user_type = "guru" AND g.nip = fd.user_id', 'left');
    $this->db->where('fd.id_pertemuan', $id_pertemuan);
    $this->db->where('fd.deleted_at IS NULL');
    $this->db->order_by('fd.created_at', 'ASC');
    $query = $this->db->get();
    
    $all_comments = $query->result();
    
    // Bangun hierarki komentar
    return $this->build_comment_hierarchy($all_comments);
}

private function build_comment_hierarchy($comments, $parent_id = null, $level = 0) {
    $result = array();
    
    foreach ($comments as $comment) {
        if ($comment->parent_id == $parent_id) {
            // Simpan level untuk indentasi
            $comment->level = $level;
            // Cari replies untuk komentar ini (rekursif)
            $comment->replies = $this->build_comment_hierarchy($comments, $comment->id, $level + 1);
            $result[] = $comment;
        }
    }
    
    return $result;
}

public function tambah_komentar($data) {
    $data['created_at'] = date('Y-m-d H:i:s');
    return $this->db->insert('forum_diskusi', $data);
}

public function edit_komentar($id, $data) {
    $data['updated_at'] = date('Y-m-d H:i:s');
    $this->db->where('id', $id);
    return $this->db->update('forum_diskusi', $data);
}

public function hapus_komentar($id) {
    $this->db->where('id', $id);
    return $this->db->update('forum_diskusi', ['deleted_at' => date('Y-m-d H:i:s')]);
}




    

    public function getGuruByMateri($materi_id) {
        $this->db->select('g.nip, g.nama_guru, g.email');
        $this->db->from('materi m');
        $this->db->join('guru g', 'm.id_guru = g.nip');
        $this->db->where('m.id', $materi_id);
        return $this->db->get()->row();
    }
    // Hapus method yang tidak digunakan
    // public function add_forum() dan add_comment() bisa dihapus jika tidak digunakan
}