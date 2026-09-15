# PEMBAHASAN PRAKTIKUM 3
## PHP dengan MySQL - Cookie & Session

**Nama**: Haidar Yahya Syarif  
**NIM**: 2504140052  
**Program Studi**: Sistem Informasi - UNNES  
**Mata Kuliah**: Pemrograman Web

---

## 2. PEMBAHASAN

### 2.1. Struktur File PHP

Website portofolio ini dikembangkan menjadi aplikasi PHP dengan integrasi database MySQL. Berikut adalah struktur file yang dibuat:

#### File Konfigurasi dan Utilitas
- **config.php** → File konfigurasi database yang menghubungkan PHP dengan MySQL (database: `portofolio_db`). File ini juga berisi helper functions seperti `isLoggedIn()`, `sanitize()`, dan `requireLogin()`.

#### File Autentikasi
- **login.php** → Halaman login admin yang menggunakan `$_POST`/`$_REQUEST` untuk menerima input, `$_SESSION` untuk menyimpan status login, dan `setcookie()` untuk fitur "Remember Me".
- **logout.php** → Menghapus session dengan `session_destroy()` dan menghapus cookie dengan `setcookie()` (expired time).

#### File Manajemen Project
- **add_project.php** → Form input project menggunakan `$_REQUEST`. Halaman ini hanya bisa diakses jika sudah login (diproteksi dengan `requireLogin()`).
- **delete_project.php** → Menghapus data project berdasarkan ID yang dikirim melalui URL (`$_GET['id']`). Dilengkapi dengan validasi kepemilikan project.
- **projects.php** → Halaman daftar semua project milik user yang sedang login.
- **dashboard.php** → Halaman dashboard admin yang menampilkan statistik dan recent projects.

#### File Database Setup
- **setup_database.php** → Script untuk setup database otomatis. Membuat database `portofolio_db`, tabel `users` dan `projects`, serta insert default user.

#### File Portofolio Public
- **index.php** → Halaman utama portofolio yang menampilkan data project dari database secara dinamis.
- **get_projects_html.php** → Helper file yang generate HTML untuk menampilkan projects dari database.

---

### 2.2. Konsep Session dan Cookie

#### Session (Server-Side Storage)
Session digunakan untuk menyimpan status login user di server. Implementasi:

```php
// Memulai session
session_start();

// Menyimpan data login
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['name'] = $user['name'];
$_SESSION['login_time'] = time();
```

**Karakteristik Session:**
- Bersifat **server-side**, data disimpan di server
- Lebih **aman** karena tidak bisa diakses/dimanipulasi oleh user
- Otomatis hilang saat browser ditutup atau session expired
- Session ID disimpan dalam cookie di browser

#### Cookie (Client-Side Storage)
Cookie digunakan untuk fitur "Remember Me" agar user tetap login selama 30 hari:

```php
// Set cookie untuk 30 hari
if ($remember) {
    $expire_time = time() + (86400 * 30); // 30 days
    setcookie('user_id', $user['id'], $expire_time, '/');
    setcookie('username', $user['username'], $expire_time, '/');
}
```

**Karakteristik Cookie:**
- Bersifat **client-side**, data disimpan di browser user
- Dapat diakses oleh JavaScript (kecuali HTTPOnly cookie)
- Memiliki expiration time yang bisa diatur
- Lebih rentan terhadap manipulation

#### Integrasi Session dan Cookie
Fungsi `checkLoginCookie()` mengintegrasikan session dan cookie:

```php
function checkLoginCookie() {
    // Cek session dulu
    if (!isset($_SESSION['user_id'])) {
        // Jika session tidak ada, cek cookie
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
            // Restore session dari cookie
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['username'] = $_COOKIE['username'];
            return true;
        }
        return false;
    }
    return true;
}
```

#### Proteksi Halaman Admin
Setiap halaman admin memeriksa status login:

```php
function requireLogin() {
    if (!checkLoginCookie()) {
        header('Location: login.php');
        exit();
    }
}

// Di setiap halaman admin
requireLogin();
```

Jika user belum login, akan dialihkan ke `login.php` menggunakan `header("Location: ...")`.

---

### 2.3. Koneksi Database dan MySQLi

#### Koneksi Database
Koneksi ke database menggunakan `mysqli_connect()` dengan parameter:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portofolio_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8");
```

**Penjelasan Parameter:**
- `DB_HOST` → Server database (localhost untuk lokal)
- `DB_USER` → Username database (default: root)
- `DB_PASS` → Password database (kosong di XAMPP default)
- `DB_NAME` → Nama database yang digunakan

#### Struktur Database

**Tabel `users`:**
```sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Tabel `projects`:**
```sql
CREATE TABLE projects (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    technologies VARCHAR(255),
    github_url VARCHAR(255),
    demo_url VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### Query yang Digunakan

**1. INSERT - Menyimpan Data Project:**
```php
$sql = "INSERT INTO projects (user_id, title, description, technologies, github_url, demo_url, image_url) 
        VALUES ($user_id, '$title', '$description', '$technologies', '$github_url', '$demo_url', '$image_url')";

if (mysqli_query($conn, $sql)) {
    echo "Project berhasil ditambahkan!";
} else {
    echo "Error: " . mysqli_error($conn);
}
```

**2. SELECT - Menampilkan Data:**
```php
// Ambil semua project user
$sql = "SELECT * FROM projects WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// Loop hasil query
while ($row = mysqli_fetch_assoc($result)) {
    echo $row['title'];
    echo $row['description'];
}
```

**3. DELETE - Menghapus Data:**
```php
$id = (int)$_GET['id'];
$sql = "DELETE FROM projects WHERE id = $id AND user_id = $user_id";

if (mysqli_query($conn, $sql)) {
    echo "Project berhasil dihapus!";
}
```

**4. Authentication - Login User:**
```php
$sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Login berhasil
        $_SESSION['user_id'] = $user['id'];
    }
}
```

---

### 2.4. Variabel $_REQUEST

Sesuai requirement praktikum, form input project menggunakan `$_REQUEST` yang dapat menangkap data dari method POST, GET, maupun COOKIE.

#### Implementasi $_REQUEST

**Di file add_project.php:**
```php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menggunakan $_REQUEST
    $title = sanitize($_REQUEST['title'] ?? '');
    $description = sanitize($_REQUEST['description'] ?? '');
    $technologies = sanitize($_REQUEST['technologies'] ?? '');
    $github_url = sanitize($_REQUEST['github_url'] ?? '');
    $demo_url = sanitize($_REQUEST['demo_url'] ?? '');
    $image_url = sanitize($_REQUEST['image_url'] ?? '');
    
    // Validasi dan simpan ke database
    if (!empty($title) && !empty($description)) {
        // Insert to database
    }
}
```

#### Perbedaan $_POST, $_GET, dan $_REQUEST

| Variabel | Source | Visibility | Use Case |
|----------|--------|------------|----------|
| `$_POST` | Form POST | Hidden in URL | Form submission (secure) |
| `$_GET` | URL parameters | Visible in URL | Filters, pagination |
| `$_REQUEST` | POST + GET + COOKIE | Mixed | Flexible input handling |

**Keuntungan $_REQUEST:**
- **Flexible**: Dapat menerima dari berbagai sumber
- **Simplicity**: Satu variabel untuk semua method
- **Compatibility**: Bekerja dengan form POST atau GET

**Catatan Keamanan:**
Dalam production, lebih baik menggunakan `$_POST` dan `$_GET` secara eksplisit untuk keamanan dan clarity. Namun untuk pembelajaran, `$_REQUEST` menunjukkan fleksibilitas PHP.

---

### 2.5. Keamanan Aplikasi

#### 1. Proteksi Halaman Admin dengan Session
```php
function requireLogin() {
    if (!checkLoginCookie()) {
        header('Location: login.php');
        exit();
    }
}

// Di setiap halaman admin
require_once 'config.php';
requireLogin();
```

Halaman `add_project.php`, `dashboard.php`, `projects.php` hanya bisa diakses setelah login.

#### 2. Password Hashing
Password tidak disimpan dalam bentuk plain text, tetapi di-hash menggunakan `password_hash()`:

```php
// Saat registrasi/setup
$password = password_hash('admin123', PASSWORD_DEFAULT);

// Saat login
if (password_verify($input_password, $stored_password)) {
    // Password benar
}
```

**PASSWORD_DEFAULT** menggunakan algoritma bcrypt yang aman.

#### 3. Input Sanitization
Semua input dari user disanitize untuk mencegah XSS dan SQL Injection:

```php
function sanitize($data) {
    global $conn;
    $data = trim($data);                          // Hapus whitespace
    $data = stripslashes($data);                  // Hapus backslashes
    $data = htmlspecialchars($data);              // Convert HTML special chars
    $data = mysqli_real_escape_string($conn, $data); // Escape SQL chars
    return $data;
}
```

#### 4. Validasi Kepemilikan Data
Sebelum menghapus project, sistem memeriksa apakah project milik user yang sedang login:

```php
// Check if project belongs to current user
$check_sql = "SELECT * FROM projects WHERE id = $id AND user_id = {$user['id']}";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // Boleh hapus
    $delete_sql = "DELETE FROM projects WHERE id = $id AND user_id = {$user['id']}";
} else {
    // Tidak boleh hapus
    header('Location: projects.php?error=not_found');
}
```

#### 5. Konfirmasi JavaScript
Tombol hapus dilengkapi konfirmasi untuk mencegah penghapusan tidak sengaja:

```html
<a href="delete_project.php?id=<?= $project['id'] ?>" 
   onclick="return confirm('Yakin ingin menghapus project ini?')">
    Delete
</a>
```

#### 6. Prepared Statements (Rekomendasi Improvement)
Untuk keamanan lebih baik, gunakan prepared statements:

```php
// Instead of:
$sql = "SELECT * FROM users WHERE username = '$username'";

// Use:
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
```

---

### 2.6. Fitur-Fitur Aplikasi

#### 1. Login System
- Username/Password authentication
- Password hashing dengan bcrypt
- Session untuk status login
- Cookie untuk "Remember Me" (30 hari)
- Auto-login dari cookie

#### 2. Dashboard Admin
- Statistik: Total projects, days active
- Recent projects list
- Quick actions (edit, delete)
- User profile display

#### 3. Project Management
- **Add Project**: Form input dengan validation
- **View Projects**: List semua projects dengan pagination
- **Edit Project**: Update project data (dapat ditambahkan)
- **Delete Project**: Hapus project dengan konfirmasi
- **Dynamic Display**: Projects tampil otomatis di portofolio

#### 4. Public Portfolio
- Halaman publik (`index.php`) menampilkan projects dari database
- Dynamic loading menggunakan PHP
- Responsive design dengan Bootstrap
- SEO-friendly dengan meta tags

---

### 2.7. Alur Kerja Aplikasi

#### Flow Login:
```
1. User buka login.php
2. Input username & password
3. Submit form (POST)
4. PHP verify username & password di database
5. Jika benar:
   - Set $_SESSION['user_id']
   - Jika remember me: setcookie()
   - Redirect ke dashboard.php
6. Jika salah:
   - Tampilkan error message
```

#### Flow Add Project:
```
1. User login terlebih dahulu
2. Akses add_project.php (check session)
3. Isi form project
4. Submit form (POST → $_REQUEST)
5. PHP sanitize input
6. Validasi data (tidak boleh kosong)
7. INSERT INTO database
8. Redirect ke dashboard.php
9. Project muncul di index.php secara otomatis
```

#### Flow Delete Project:
```
1. User klik tombol Delete
2. Konfirmasi JavaScript
3. Redirect ke delete_project.php?id=X
4. PHP check session
5. Validate project ownership
6. DELETE FROM database
7. Redirect kembali ke projects.php
```

---

### 2.8. Integrasi dengan Portofolio Statis

#### Konversi HTML ke PHP
File `index.html` dikonversi menjadi `index.php` untuk:
- Dapat mengeksekusi kode PHP
- Mengambil data dari database
- Menampilkan projects secara dinamis

#### Dynamic Projects Display
```php
<?php
// Include config
@include 'php/config.php';

// Get projects from database
$sql = "SELECT * FROM projects ORDER BY created_at DESC LIMIT 10";
$result = @mysqli_query($conn, $sql);

// Loop and display
while ($project = mysqli_fetch_assoc($result)) {
    echo "<div class='project-card'>";
    echo "<h4>" . htmlspecialchars($project['title']) . "</h4>";
    echo "<p>" . htmlspecialchars($project['description']) . "</p>";
    echo "</div>";
}
?>
```

#### Fallback Handling
Jika database tidak tersedia, website tetap berfungsi (menampilkan pesan info) tanpa error:

```php
@include 'php/config.php'; // @ untuk suppress error
if (isset($conn)) {
    // Query database
} else {
    // Tampilkan fallback content
    echo "Belum ada project...";
}
```

---

### 2.9. Kelebihan dan Kekurangan

#### Kelebihan:
✅ **Dynamic Content**: Projects dapat di-manage tanpa edit kode  
✅ **User Authentication**: Login system yang aman  
✅ **Session & Cookie**: User experience yang baik  
✅ **Database Integration**: Data tersimpan permanent  
✅ **Responsive Design**: Mobile-friendly  
✅ **Security**: Password hashing, input sanitization  

#### Kekurangan & Improvement:
❌ **No Edit Feature**: Belum ada fitur edit project (bisa ditambahkan)  
❌ **No Image Upload**: Image URL manual (bisa tambah upload)  
❌ **No Pagination**: Semua projects ditampilkan (bisa tambah pagination)  
❌ **No User Registration**: Hanya 1 user default  
❌ **SQL Injection Risk**: Belum menggunakan prepared statements  

---

### 2.10. Testing dan Validasi

#### Test Cases:
1. ✅ Login dengan credentials benar → Berhasil masuk dashboard
2. ✅ Login dengan credentials salah → Error message muncul
3. ✅ Remember me checkbox → Cookie tersimpan 30 hari
4. ✅ Add project dengan data lengkap → Tersimpan di database
5. ✅ Add project dengan data kosong → Validation error
6. ✅ Delete project → Terhapus dari database dan tampilan
7. ✅ Akses admin tanpa login → Redirect ke login.php
8. ✅ Logout → Session dan cookie terhapus
9. ✅ Projects muncul di index.php → Dynamic dari database
10. ✅ Responsive di mobile → Layout menyesuaikan

---

## 3. KESIMPULAN

Praktikum 3 ini berhasil mengimplementasikan:

1. **Cookie & Session Management**
   - Session untuk menyimpan status login
   - Cookie untuk fitur "Remember Me"
   - Integrasi session dan cookie untuk UX yang baik

2. **Form dengan $_REQUEST**
   - Form input project menggunakan `$_REQUEST`
   - Dapat menerima data dari POST/GET/COOKIE
   - Flexible dan mudah digunakan

3. **Database Integration dengan MySQLi**
   - Koneksi database dengan `mysqli_connect()`
   - CRUD operations (Create, Read, Delete)
   - Query SQL untuk manajemen data
   - Password hashing untuk keamanan

4. **Dynamic Web Application**
   - Portofolio statis menjadi dynamic
   - Projects di-manage melalui admin panel
   - Otomatis update di halaman publik

5. **Security Implementation**
   - Session-based authentication
   - Password hashing dengan bcrypt
   - Input sanitization
   - Access control untuk halaman admin

Website portofolio ini tidak hanya memenuhi requirement praktikum, tetapi juga menjadi aplikasi web yang fungsional dan dapat digunakan untuk mengelola portfolio personal secara profesional.

---

## 4. REFERENSI

1. **PHP Manual - Sessions**  
   https://www.php.net/manual/en/book.session.php

2. **PHP Manual - Cookies**  
   https://www.php.net/manual/en/features.cookies.php

3. **PHP Manual - MySQLi**  
   https://www.php.net/manual/en/book.mysqli.php

4. **W3Schools PHP Tutorial**  
   https://www.w3schools.com/php/

5. **PHP Security Best Practices**  
   https://www.php.net/manual/en/security.php

6. **Modul Praktikum TE UM**
   - Modul 09: Cookie dan Session
   - Modul 10: PHP MySQL
   - Modul 11: CRUD Operations

---

**Disusun oleh:**  
Haidar Yahya Syarif (2504140052)  
Sistem Informasi - UNNES  
Praktikum Pemrograman Web 3  
2024
