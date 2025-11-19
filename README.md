# AddustEdu 🎓 — Web E-Learning (CodeIgniter 3)

**AddustEdu** adalah Learning Management System (LMS) berbasis **PHP CodeIgniter 3** yang dibuat untuk mendukung proses belajar-mengajar secara daring — cocok untuk PKBM, sekolah, dan lembaga kursus. README ini menekankan fitur nyata yang tersedia di repository, cara menjalankan secara lokal, dan catatan penting konfigurasi.

> Catatan: isi README ini berdasarkan isi repository publik `andikafahrezzi/addustedu`. Untuk detail file referensi, lihat file dan folder di root repo. :contentReference[oaicite:1]{index=1}

---

## 🎯 Fitur (yang tersedia di repo)
- Multi-role: **Admin**, **Guru**, **Siswa** (login & pendaftaran). :contentReference[oaicite:2]{index=2}  
- **Materi**: upload materi per kelas/mapel (pdf, video, dokumen). :contentReference[oaicite:3]{index=3}  
- **Pertemuan**: penjadwalan materi per pertemuan (tanggal, pertemuan ke-n). :contentReference[oaicite:4]{index=4}  
- **Forum Diskusi**: forum per materi; siswa dapat berkomentar dan melihat penulis komentar. :contentReference[oaicite:5]{index=5}  
- **Tugas Siswa**: guru memberi tugas, siswa upload, guru melihat pengumpulan & memberi nilai/catatan. :contentReference[oaicite:6]{index=6}  
- **Bank Soal**: penyimpanan soal untuk digunakan kembali pada ujian. (Tabel `bank_soal` / struktur terkait ada di repo). :contentReference[oaicite:7]{index=7}  
- **Ujian Online**: pembuatan ujian oleh guru dengan soal yang diambil dari bank soal atau soal pribadi (`ujian`, `ujian_soal`, `tbl_soal`). :contentReference[oaicite:8]{index=8}  
- **Quiz**: mekanisme quiz dengan status (start / lanjutkan / selesai) dan fitur shuffle soal (tersedia di kode). :contentReference[oaicite:9]{index=9}

---

## 📁 Struktur penting (root repo)
- `application/` — kode CodeIgniter (controllers, models, views). :contentReference[oaicite:10]{index=10}  
- `database/` — file database / schema (import DB untuk menjalankan). :contentReference[oaicite:11]{index=11}  
- `assets/` — gambar, css, js, vendor (tema & library). :contentReference[oaicite:12]{index=12}  
- `README.md`, `TODO.TXT` — dokumentasi & daftar tugas. :contentReference[oaicite:13]{index=13}

---

## Prasyarat
- PHP 7.x / 8.x  
- Web server (XAMPP, Laragon, MAMP)  
- MySQL / MariaDB  
- Composer (opsional, bila menggunakan vendor)  
- Browser modern  
- Pastikan `php.ini` diatur `upload_max_filesize` & `post_max_size` sesuai kebutuhan (upload materi/tugas). :contentReference[oaicite:14]{index=14}

---

## Instalasi (langkah teruji untuk lingkungan lokal)

1. Clone repo:
   ```bash
   git clone https://github.com/andikafahrezzi/addustedu.git
   cd addustedu
