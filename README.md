# 📦 Sistem Inventaris Barang

Sistem Inventaris Barang adalah aplikasi berbasis web yang dikembangkan menggunakan **Laravel 12** untuk membantu proses pengelolaan data inventaris secara lebih efektif dan efisien. Aplikasi ini menyediakan fitur manajemen barang, kategori, supplier, transaksi barang masuk dan keluar, serta pemantauan stok secara real-time.

---

## ✨ Fitur Utama

- 🔐 Login Admin
- 📊 Dashboard Informasi Inventaris
- 📦 Manajemen Data Barang (CRUD)
- 🗂️ Manajemen Kategori Barang
- 🚚 Manajemen Supplier
- 📋 Manajemen Transaksi Barang Masuk & Keluar
- 🔍 Pencarian Data
- 📄 Pagination
- 📥 Import Data Excel/CSV
- 📤 Export Data Excel/CSV
- 📈 Grafik Ringkasan Inventaris
- 🔔 Notifikasi Stok Menipis
- 📝 Riwayat Aktivitas (Activity Log)
- 👤 Pengaturan Profil
- ✏️ Ubah Nama Pengguna
- 🔒 Ubah Kata Sandi

---

## 🛠️ Teknologi yang Digunakan

- Laravel 12
- PHP 8.2+
- MySQL
- Bootstrap 5
- AdminLTE
- JavaScript
- HTML5
- CSS3

---

## 📂 Struktur Fitur

- Dashboard
- Data Barang
- Data Kategori
- Data Supplier
- Data Transaksi
- Riwayat Aktivitas
- Pengaturan Profil

---

## 🚀 Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/inventaris-barang.git
```

### 2. Masuk ke Folder Project

```bash
cd inventaris-barang
```

### 3. Install Dependency

```bash
composer install
```

```bash
npm install
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Atur Database pada File `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_inventaris_barang
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migrasi

```bash
php artisan migrate --seed
```

### 8. Jalankan Project

```bash
php artisan serve
```

---

# 📷 Tampilan Aplikasi

## 🔐 Login

![Login](screenshots/login.png)

---

## 📊 Dashboard

![Dashboard](screenshots/dashboard.png)

---

## 📦 Data Barang

![Data Barang](screenshots/databarang.png)

---

## 📋 Data Transaksi

![Data Transaksi](screenshots/datatransaksi.png)

---

## 📝 Riwayat Aktivitas

![Riwayat Aktivitas](screenshots/riwayataktivitas.png)

---

## 👤 Pengaturan Profil

![Pengaturan Profil](screenshots/settingprofile.png)

---

## ✏️ Ubah Nama Pengguna

![Ubah Nama Pengguna](screenshots/settingnamapengguna.png)

---

## 🔒 Ubah Kata Sandi

![Ubah Kata Sandi](screenshots/ubahkatasandi.png)

---

## 👨‍💻 Developer

Indah Purnama

SMK Negeri 7 Pekanbaru

Jurusan Rekayasa Perangkat Lunak (RPL)

---

## 📄 Lisensi

Project ini dibuat untuk keperluan pembelajaran dan tugas sekolah.
