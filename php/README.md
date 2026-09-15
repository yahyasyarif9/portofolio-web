# 📚 PRAKTIKUM 3 - PHP dengan MySQL
## Portfolio Management System

**Nama**: Haidar Yahya Syarif  
**NIM**: 2504140052  
**Program Studi**: Sistem Informasi - UNNES

---

## 🎯 Fitur Praktikum 3

✅ **Login System** dengan Cookie & Session  
✅ **Form Input Project** menggunakan $_REQUEST  
✅ **Database MySQL** dengan mysqli  
✅ **CRUD Operations** (Create, Read, Update, Delete)  

---

## 📁 Struktur File

```
php/
├── config.php              # Database config & helper functions
├── setup_database.php      # Setup database & tables (jalankan sekali)
├── login.php               # Halaman login (Cookie & Session)
├── logout.php              # Logout & clear session/cookie
├── dashboard.php           # Dashboard admin
├── add_project.php         # Form tambah project ($_REQUEST)
├── projects.php            # List semua projects
├── delete_project.php      # Hapus project
└── README.md               # Dokumentasi
```

---

## 🚀 Cara Setup

### 1. Install XAMPP
- Download & install XAMPP
- Start **Apache** dan **MySQL**

### 2. Setup Database
Buka browser dan akses:
```
http://localhost/portofolioku/php/setup_database.php
```

Script ini akan:
- Membuat database `portofolio_db`
- Membuat table `users` dan `projects`
- Insert default user

### 3. Login
```
http://localhost/portofolioku/php/login.php
```

**Default Credentials:**
- Username: `haidar`
- Password: `admin123`

---

## 💾 Database Structure

### Table: users
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- username (VARCHAR 50, UNIQUE)
- password (VARCHAR 255) -- hashed with password_hash()
- name (VARCHAR 100)
- email (VARCHAR 100)
- created_at (TIMESTAMP)
```

### Table: projects
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- title (VARCHAR 200)
- description (TEXT)
- technologies (VARCHAR 255)
- github_url (VARCHAR 255)
- demo_url (VARCHAR 255)
- image_url (VARCHAR 255)
- created_at (TIMESTAMP)
```

---

## 🔐 Cookie & Session Implementation

### Login dengan Session
```php
// Set session
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['name'] = $user['name'];
```

### Login dengan Cookie (Remember Me)
```php
// Set cookie untuk 30 hari
if ($remember) {
    setcookie('user_id', $user['id'], time() + (86400 * 30), '/');
    setcookie('username', $user['username'], time() + (86400 * 30), '/');
}
```

### Check Login
```php
function checkLoginCookie() {
    if (!isset($_SESSION['user_id'])) {
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['username'] = $_COOKIE['username'];
            return true;
        }
        return false;
    }
    return true;
}
```

---

## 📝 Form dengan $_REQUEST

### Penggunaan $_REQUEST
```php
// $_REQUEST dapat menerima data dari:
// - $_GET
// - $_POST
// - $_COOKIE

$title = sanitize($_REQUEST['title'] ?? '');
$description = sanitize($_REQUEST['description'] ?? '');
$technologies = sanitize($_REQUEST['technologies'] ?? '');
```

**Keuntungan $_REQUEST:**
- Flexible: bisa terima dari GET, POST, atau COOKIE
- Simplicity: satu variabel untuk semua method

**Note:** Dalam praktik production, lebih baik gunakan $_POST untuk form data dan $_GET untuk query parameters secara eksplisit untuk security.

---

## 🔗 MySQL dengan mysqli

### Connection
```php
$conn = mysqli_connect('localhost', 'root', '', 'portofolio_db');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
```

### Insert Data
```php
$sql = "INSERT INTO projects (user_id, title, description) 
        VALUES ($user_id, '$title', '$description')";

if (mysqli_query($conn, $sql)) {
    echo "Success!";
}
```

### Select Data
```php
$sql = "SELECT * FROM projects WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['title'];
}
```

### Delete Data
```php
$sql = "DELETE FROM projects WHERE id = $id";
mysqli_query($conn, $sql);
```

---

## 🎓 Konsep yang Dipelajari

### 1. Cookie & Session
- **Session**: Data disimpan di server, aman untuk data sensitif
- **Cookie**: Data disimpan di browser client, untuk "remember me"
- **Session ID** disimpan dalam cookie untuk link session

### 2. $_REQUEST vs $_POST vs $_GET
- **$_POST**: Form submission (secure, tidak terlihat di URL)
- **$_GET**: Query parameters (visible di URL)
- **$_REQUEST**: Gabungan POST, GET, dan COOKIE

### 3. MySQL dengan mysqli
- **mysqli_connect()**: Koneksi ke database
- **mysqli_query()**: Jalankan SQL query
- **mysqli_fetch_assoc()**: Ambil hasil sebagai array
- **mysqli_real_escape_string()**: Sanitize input (prevent SQL injection)

### 4. Security
- **Password Hashing**: `password_hash()` dan `password_verify()`
- **Input Sanitization**: `mysqli_real_escape_string()`, `htmlspecialchars()`
- **Session Security**: Check login status sebelum akses halaman admin

---

## 📸 Screenshot

1. **Login Page** - Form login dengan remember me checkbox
2. **Dashboard** - Stats dan list recent projects
3. **Add Project** - Form input project dengan $_REQUEST
4. **Projects List** - List semua projects dengan edit/delete

---

## 🔧 Troubleshooting

### Database Connection Error
- Pastikan XAMPP MySQL running
- Check username/password di `config.php`
- Check database sudah dibuat

### Session Not Working
- Check `session_start()` dipanggil sebelum output
- Check PHP session configuration

### Cookie Not Working
- Check browser tidak block cookies
- Check cookie path dan expire time

---

## ✅ Checklist Praktikum

- [x] Halaman login dengan cookie & session
- [x] Form input project menggunakan $_REQUEST
- [x] Simpan data ke database dengan mysqli
- [x] CRUD operations lengkap
- [x] Security (password hash, input sanitization)

---

## 📚 Referensi

- [PHP Manual - Sessions](https://www.php.net/manual/en/book.session.php)
- [PHP Manual - Cookies](https://www.php.net/manual/en/features.cookies.php)
- [PHP Manual - mysqli](https://www.php.net/manual/en/book.mysqli.php)
- [W3Schools PHP](https://www.w3schools.com/php/)

---

**Dibuat oleh:** Haidar Yahya Syarif  
**Tanggal:** 2026  
**Praktikum:** Pemrograman Web 3 - PHP & MySQL
