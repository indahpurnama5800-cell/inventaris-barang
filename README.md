# 📦 Sistem Inventaris Barang

Sistem Inventaris Barang merupakan aplikasi berbasis web yang dikembangkan menggunakan **Laravel 12** untuk membantu pengelolaan inventaris secara efektif dan efisien. Aplikasi ini memudahkan pengguna dalam mengelola data barang, kategori, supplier, transaksi barang masuk dan keluar, serta memantau stok barang secara real-time melalui dashboard yang informatif.

---

# ✨ Fitur Utama

- 🔐 Login Admin
- 📊 Dashboard Inventaris
- 📦 CRUD Data Barang
- 🗂️ CRUD Data Kategori
- 🚚 CRUD Data Supplier
- 📋 CRUD Data Transaksi Barang Masuk & Keluar
- 🔍 Pencarian Data
- 📄 Pagination
- 📥 Import Data Excel (.xlsx/.csv)
- 📤 Export Data Excel (.xlsx/.csv)
- 📈 Grafik Ringkasan Inventaris
- 🔔 Notifikasi Stok Menipis
- 📝 Riwayat Aktivitas (Activity Log)
- 👤 Pengaturan Profil
- ✏️ Ubah Nama Pengguna
- 🔒 Ubah Kata Sandi

---

# 🛠️ Teknologi yang Digunakan

- Laravel 12
- PHP 8.2+
- MySQL
- Bootstrap 5
- AdminLTE
- HTML5
- CSS3
- JavaScript

---

# 📂 Struktur Menu

- Dashboard
- Data Barang
- Data Kategori
- Data Supplier
- Data Transaksi
- Riwayat Aktivitas
- Pengaturan Profil

---

# 🚀 Cara Menjalankan Project

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

### 6. Konfigurasi Database

Sesuaikan file **.env**:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_inventaris_barang
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migrasi Database

```bash
php artisan migrate --seed
```

### 8. Jalankan Server

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```
http://127.0.0.1:8000
```

---

# 📷 Tampilan Aplikasi

## 🔐 Login

![Login](images/login.png)

---

## 📊 Dashboard

![Dashboard](images/dashboard.png)

---

## 📦 Data Barang

![Data Barang](images/databarang.png)

---

## 📋 Data Transaksi

![Data Transaksi](images/datatransaksi.png)

---

## 📝 Riwayat Aktivitas

![Riwayat Aktivitas](images/riwayataktivitas.png)

---

## 👤 Pengaturan Profil

![Pengaturan Profil](images/settingprofile.png)

---

## ✏️ Ubah Nama Pengguna

![Ubah Nama Pengguna](images/settingnamapengguna.png)

---

## 🔒 Ubah Kata Sandi

![Ubah Kata Sandi](images/ubahkatasandi.png)

---

# 👨‍💻 Developer

**Indah Purnama**

SMK Negeri 7 Pekanbaru

Jurusan Rekayasa Perangkat Lunak (RPL)

---

# 📄 Lisensi

Project ini dibuat sebagai media pembelajaran dan untuk memenuhi tugas pengembangan aplikasi berbasis web menggunakan framework Laravel.
