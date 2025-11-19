# 📘 AddustEdu – E-Learning (CodeIgniter 3)

AddustEdu adalah sistem e-learning berbasis **PHP CodeIgniter 3** yang mendukung proses pembelajaran daring untuk Admin, Guru, dan Siswa.
Fitur fokus: materi, pertemuan, forum, tugas, bank soal, quiz, dan ujian online.

---

## 🚀 Fitur Utama

* **Materi & Pertemuan** – Guru mengunggah materi dan menjadwalkannya ke pertemuan.
* **Forum Diskusi** – Forum otomatis per pertemuan, siswa dan guru dapat berkomentar.
* **Tugas Siswa** – Siswa mengupload tugas, guru memberi nilai & catatan.
* **Bank Soal** – Penyimpanan soal untuk dipakai pada ujian.
* **Soal Pribadi** – Guru dapat menambah soal di luar bank soal.
* **Ujian Online**

  * Soal dari *bank soal* & *soal pribadi*
  * Tersimpan di `ujian_soal`
* **Quiz** – Status *start*, *lanjutkan*, *selesai* + shuffle soal.
* **Multi-Role** – Admin, Guru, Siswa.

---

## 🔐 Akses Role

| Role  | URL                                        |
| ----- | ----------------                           |
| Admin | `http://localhost/addustedu/welcome/admin` |
| Guru  | `http://localhost/addustedu/welcome/guru`  |
| Siswa | `http://localhost/addustedu/welcome/`      |

---

## 🗂 Struktur Folder Penting

| Folder                      | Fungsi                               |
| --------------------------- | ------------------------------------ |
| `/application/controllers/` | Controller utama                     |
| `/application/models/`      | Logic & query                        |
| `/application/views/`       | Halaman untuk admin/guru/siswa       |
| `/database/`                | File SQL                             |
| `/assets/`                  | CSS, JS, vendor, template guru/siswa |

---

## 🧩 Tabel Inti

| Tabel                                  | Deskripsi                    |
| -------------------------------------- | ---------------------------- |
| `siswa`, `guru`                        | Data pengguna                |
| `mapel`, `guru_mapel`                  | Mata pelajaran & relasi guru |
| `materi`                               | Materi pembelajaran          |
| `pertemuan`                            | Jadwal pertemuan             |
| `forum`, `forum_komentar`              | Diskusi                      |
| `tugas`, `tugas_upload`, `tugas_nilai` | Tugas & penilaian            |
| `bank_soal`, `tbl_soal`                | Bank soal & soal pribadi     |
| `ujian`, `ujian_soal`, `ujian_jawaban` | Ujian                        |
| `quiz`, `quiz_jawaban`                 | Quiz                         |

---

## ⚙️ Instalasi Singkat

1. Clone repository

   ```bash
   git clone https://github.com/andikafahrezzi/addustedu
   ```
2. Import database dari folder `/database/`
3. Atur koneksi:

   * `application/config/database.php`
   * `application/config/config.php`
4. Jalankan:

   ```
   http://localhost/addustedu
   ```

---

## 🔑 Akun Testing (default)

| Role  | Username                                  | Password |
| ----- | ----------------------------------------- | -------- |
| Admin | [admin@gmail.com](mailto:admin@gmail.com) | admin    |
| Guru  | 12345678                                  | 12345678 |
| Siswa | 12345678                                  | 2310203  |

