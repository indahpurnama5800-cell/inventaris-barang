# 📦 Sistem Inventaris Barang

Sistem Inventaris Barang adalah aplikasi berbasis web yang dikembangkan menggunakan **Laravel 12** untuk membantu proses pengelolaan data inventaris secara lebih efektif dan efisien. Aplikasi ini menyediakan fitur manajemen barang, kategori, supplier, transaksi barang masuk dan keluar, serta pemantauan stok secara real-time.

---

## ✨ Fitur Utama

- 🔐 Login Admin
- 📊 Dashboard Inventaris
- 📦 Manajemen Data Barang (CRUD)
- 🗂️ Manajemen Kategori
- 🚚 Manajemen Supplier
- 📋 Manajemen Transaksi Barang Masuk & Keluar
- 🔍 Pencarian Data
- 📄 Pagination
- 📥 Import Data Excel/CSV
- 📤 Export Data Excel/CSV
- 📈 Grafik Ringkasan Inventaris
- 🔔 Notifikasi Stok Menipis
- 📝 Riwayat Aktivitas
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
- HTML5
- CSS3
- JavaScript

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
git clone https://github.com/indahpurnama5800-cell/inventaris-barang.git
```

### 2. Masuk ke Folder Project

```bash
cd inventaris-barang
```

### 3. Install Dependency

```bash
composer install
npm install
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

### 5. Generate Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

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

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

---

# 📷 Tampilan Aplikasi

## 🔐 Login

![Login](INVENTARIS%20BARANG/login.png)

---

## 📊 Dashboard

![Dashboard](INVENTARIS%20BARANG/dashboard.png)

---

## 📦 Data Barang

![Data Barang](INVENTARIS%20BARANG/databarang.png)

---

## 📋 Data Transaksi

![Data Transaksi](INVENTARIS%20BARANG/datatransaksi.png)

---

## 📝 Riwayat Aktivitas

![Riwayat Aktivitas](INVENTARIS%20BARANG/riwayataktivitas.png)

---

## 👤 Pengaturan Profil

![Pengaturan Profil](INVENTARIS%20BARANG/settingprofile.png)

---

## ✏️ Ubah Nama Pengguna

![Ubah Nama Pengguna](INVENTARIS%20BARANG/settingnamapengguna.png)

---

## 🔒 Ubah Kata Sandi

![Ubah Kata Sandi](INVENTARIS%20BARANG/ubahkatasandi.png)

---

## 👩‍💻 Developer

**Indah Purnama**

SMK Negeri 7 Pekanbaru

Jurusan Rekayasa Perangkat Lunak (RPL)

---

## 📄 Lisensi

Project ini dibuat untuk keperluan pembelajaran dan tugas sekolah.
