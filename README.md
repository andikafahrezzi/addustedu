
---

# 📘 AddustEdu – Web-Based E-Learning System (CodeIgniter 3)

**AddustEdu** is a structured and modular e-learning platform developed using **PHP CodeIgniter 3**.
The system supports digital learning workflows for **Administrators**, **Teachers**, and **Students**, providing essential modules for instructional content, assessments, and interaction.

---

## 🚀 Key Features

### Learning Management

* Upload and manage learning materials.
* Schedule materials into structured meetings.

### Discussion Forum

* Auto-generated discussion forums per meeting.
* Supports student–teacher interaction through threaded comments.

### Assignments

* Students upload assignment files through the portal.
* Teachers evaluate submissions and provide grades and feedback.

### Question Bank & Private Questions

* Centralized repository for reusable exam questions.
* Teachers may add private/custom questions outside the bank.
* All exam items are stored and linked through `ujian_soal`.

### Online Examinations

* Supports mixed question sources (bank + private).
* Handles exam sessions, student answers, and evaluation logic.

### Quiz Module

* Quiz progression: *start*, *continue*, *finished*.
* Supports randomized question order.

### Multi-Role Access

Dedicated interfaces for **Admin**, **Teacher**, and **Student**, each with role-specific workflows.

---

## 🔐 Role Access URLs

| Role    | URL                                        |
| ------- | ------------------------------------------ |
| Admin   | `http://localhost/addustedu/welcome/admin` |
| Teacher | `http://localhost/addustedu/welcome/guru`  |
| Student | `http://localhost/addustedu/welcome/`      |

---

## 🗂 Project Structure

| Directory                   | Description                             |
| --------------------------- | --------------------------------------- |
| `/application/controllers/` | Core application controllers            |
| `/application/models/`      | Data access & business logic            |
| `/application/views/`       | Interface templates for all user roles  |
| `/database/`                | SQL schema & sample data                |
| `/assets/`                  | Frontend resources (CSS, JS, templates) |

---

## 🧩 Core Database Entities

| Table                                  | Purpose                       |
| -------------------------------------- | ----------------------------- |
| `siswa`, `guru`                        | User data                     |
| `mapel`, `guru_mapel`                  | Subjects & teacher mapping    |
| `materi`                               | Learning materials            |
| `pertemuan`                            | Scheduled meetings            |
| `forum`, `forum_komentar`              | Discussion forums             |
| `tugas`, `tugas_upload`, `tugas_nilai` | Assignments & grading         |
| `bank_soal`, `tbl_soal`                | Question bank & private items |
| `ujian`, `ujian_soal`, `ujian_jawaban` | Examination system            |
| `quiz`, `quiz_jawaban`                 | Quiz module                   |

---

## ⚙️ Installation Guide

1. Clone the repository:

   ```bash
   git clone https://github.com/andikafahrezzi/addustedu
   ```

2. Import the SQL file from the `/database/` directory.

3. Configure the system:

   * `application/config/database.php`
   * `application/config/config.php`

4. Launch the application:

   ```
   http://localhost/addustedu
   ```

---

## 🔑 Default Test Accounts

| Role    | Username                                  | Password |
| ------- | ----------------------------------------- | -------- |
| Admin   | [admin@gmail.com](mailto:admin@gmail.com) | admin    |
| Teacher | 12345678                                  | 12345678 |
| Student | 12345678                                  | 23102003 |

---
