<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kuisioner_model extends CI_Model {

    private $table = "kuisioner";

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
    // Ambil semua pertanyaan dari kuisioner
public function get_pertanyaan($kuisioner_id) {
    return $this->db->where('kuisioner_id', $kuisioner_id)
                    ->order_by('urutan', 'ASC')
                    ->get('kuisioner_pertanyaan')
                    ->result();
}

// Ambil pertanyaan by id
public function get_pertanyaan_by_id($id) {
    return $this->db->where('id', $id)
                    ->get('kuisioner_pertanyaan')
                    ->row();
}

// Insert pertanyaan
public function insert_pertanyaan($data) {
    return $this->db->insert('kuisioner_pertanyaan', $data);
}

// Update pertanyaan
public function update_pertanyaan($id, $data) {
    return $this->db->where('id', $id)
                    ->update('kuisioner_pertanyaan', $data);
}

// Delete pertanyaan
public function delete_pertanyaan($id) {
    return $this->db->where('id', $id)
                    ->delete('kuisioner_pertanyaan');
}
// Analisis per pertanyaan
public function analisis_pertanyaan($kuisioner_id, $pertanyaan_id, $tipe) {
    if ($tipe == 'skala') {
        // Hitung jumlah respon, rata-rata, min, max
        return $this->db->select('COUNT(*) as total_respon, 
                                  AVG(jawaban_skala) as rata_rata, 
                                  MIN(jawaban_skala) as nilai_min, 
                                  MAX(jawaban_skala) as nilai_max')
                        ->where('kuisioner_id', $kuisioner_id)
                        ->where('pertanyaan_id', $pertanyaan_id)
                        ->get('kuisioner_jawaban')
                        ->row();
    } elseif ($tipe == 'pilihan') {
        // Hitung distribusi pilihan
        return $this->db->select('jawaban_pilihan, COUNT(*) as total')
                        ->where('kuisioner_id', $kuisioner_id)
                        ->where('pertanyaan_id', $pertanyaan_id)
                        ->group_by('jawaban_pilihan')
                        ->get('kuisioner_jawaban')
                        ->result();
    } else {
        // Teks → ambil semua jawaban
        return $this->db->select('jawaban_text, created_at')
                        ->where('kuisioner_id', $kuisioner_id)
                        ->where('pertanyaan_id', $pertanyaan_id)
                        ->get('kuisioner_jawaban')
                        ->result();
    }
}
// ambil kuisioner aktif untuk user tertentu
public function get_kuisioner_aktif($user_type, $user_id) {
    return $this->db->select('k.*')
        ->from('kuisioner k')
        ->join('kuisioner_status s', 's.kuisioner_id = k.id AND s.user_type="'.$user_type.'" AND s.user_id="'.$user_id.'"', 'left')
        ->where('k.is_active', 1)
        ->where('(k.target="'.$user_type.'" OR k.target="all")')
        ->where('(s.is_completed IS NULL OR s.is_completed=0)')
        ->order_by('k.created_at','DESC')
        ->get()
        ->row();
}

// simpan jawaban
public function simpan_jawaban($data) {
    return $this->db->insert('kuisioner_jawaban', $data);
}

// update status selesai
public function update_status($user_type, $user_id, $kuisioner_id) {
    $exist = $this->db->where([
        'user_type' => $user_type,
        'user_id' => $user_id,
        'kuisioner_id' => $kuisioner_id
    ])->get('kuisioner_status')->row();

    if ($exist) {
        $this->db->where('id', $exist->id)->update('kuisioner_status', [
            'is_completed' => 1,
            'completed_at' => date('Y-m-d H:i:s')
        ]);
    } else {
        $this->db->insert('kuisioner_status', [
            'user_type' => $user_type,
            'user_id' => $user_id,
            'kuisioner_id' => $kuisioner_id,
            'is_completed' => 1,
            'completed_at' => date('Y-m-d H:i:s')
        ]);
    }
}

}
