Nama : Rizky Rivaldy.
Nim : C2C023067.
Kelas : B.
Dosen Pengampu : Dr. Dhendra Marutho, S.Kom., M.Kom.

# Laporan UAS Keamanan Data & Informasi
---

##  Deskripsi Project
Aplikasi web simulasi yang dirancang untuk mendemonstrasikan celah keamanan umum pada aplikasi web (Vulnerabilities) serta teknik mitigasi yang tepat (Secure Coding). Aplikasi ini memiliki dua mode lingkungan:
1.   **Vulnerable Mode:** Lingkungan yang sengaja dibuat tidak aman untuk simulasi serangan.
2.   **Secure Mode:** Lingkungan yang telah diamankan dengan standar keamanan web.

---
##  1. Deskripsi Kerentanan (Soal 1)

### A. Authentication Bypass (Login)
* **Masalah:** Sistem tidak membatasi jumlah percobaan login (*No Rate Limiting*) dan memberikan pesan error yang terlalu spesifik ("Password salah bro").
* **Risiko:** Memungkinkan serangan *Brute Force* dan *User Enumeration* untuk mengambil alih akun admin.

### B. Cross-Site Scripting (Reflected XSS)
* **Masalah:** Input pengguna pada kolom komentar langsung ditampilkan kembali (*echo*) ke browser tanpa filter.
* **Risiko:** Penyerang dapat menyisipkan skrip berbahaya (JavaScript) untuk mencuri *session cookies* atau melakukan *phishing* terhadap pengguna lain.

### C. Local File Inclusion (LFI)
* **Masalah:** Parameter URL `?file=` diproses langsung oleh fungsi `include()` tanpa validasi jalur direktori.
* **Risiko:** Penyerang dapat menggunakan teknik *Path Traversal* (`../`) untuk membaca file sensitif server atau kode sumber aplikasi.

---

##  2. Teknik Mitigasi (Soal 2)

### A. Pengamanan Login
* **Rate Limiting (Anti-Brute Force):** Menggunakan PHP Session untuk menghitung kegagalan login. Jika gagal 3 kali berturut-turut, akun dikunci (*Lockout*) selama 30 detik dengan fitur hitung mundur.
* **Generic Error Message:** Mengubah pesan error menjadi "Kredensial tidak valid" agar penyerang tidak mengetahui validitas username.
* **CSRF Token:** Menambahkan token unik pada form untuk mencegah serangan lintas situs.

### B. Sanitasi Input (XSS Prevention)
* **Output Encoding:** Menggunakan fungsi bawaan PHP `htmlspecialchars($input, ENT_QUOTES, 'UTF-8')` sebelum menampilkan data ke layar.
* **Cara Kerja:** Fungsi ini mengubah karakter berbahaya seperti `<` dan `>` menjadi entitas HTML (`&lt;`, `&gt;`), sehingga browser membacanya sebagai teks biasa, bukan kode eksekusi.

### C. Whitelisting File (LFI Prevention)
* **Strict Whitelisting:** Mendefinisikan daftar file yang diizinkan dalam array (misal: `['intro.txt', 'readme.txt']`).
* **Validasi:** Sistem mengecek input pengguna menggunakan fungsi `in_array()`. Jika file yang diminta tidak ada dalam daftar putih, akses ditolak ("Access Denied").

---

##  3. Analisis Risiko Singkat (Soal 3)

Berikut adalah analisis risiko pada aplikasi sebelum dilakukan perbaikan (Mode Vulnerable):

### Login (Brute Force)
* **Dampak:** CRITICAL (Akses Admin Penuh).
* **Kemungkinan:** TINGGI (Password lemah & tanpa limitasi).
* **Prioritas Perbaikan:** Utama (P1).

### File Viewer (LFI)
* **Dampak:** TINGGI (Kebocoran Source Code/Config).
* **Kemungkinan:** SEDANG (Perlu menebak struktur folder).
* **Prioritas Perbaikan:** Kedua (P2).

### Komentar (XSS)
* **Dampak:** SEDANG (Client-side attack).
* **Kemungkinan:** TINGGI (Mudah dieksekusi via link).
* **Prioritas Perbaikan:** Ketiga (P3).

---

##  Bukti Pengujian
(Screenshot pengujian manual terdapat pada folder /screenshots atau dokumen laporan )

1.  **Login:** Validasi *Lockout* setelah 3x gagal pada mode Secure.
2.  **XSS:** Input `<script>` tereksekusi di Vuln, namun menjadi teks biasa di Secure.
3.  **LFI:** Akses `../index.php` berhasil di Vuln, namun muncul "AKSES DITOLAK" di Secure.

---

##  Link GitHub
Kode sumber lengkap proyek ini dapat diakses di: https://github.com/vallx86/uas_keamanan_data.git


