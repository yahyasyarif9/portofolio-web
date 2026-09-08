# 📚 PEMBAHASAN WEBSITE PORTOFOLIO
## Praktikum 2 - Cascading Style Sheet (CSS)

**Nama**: Haidar Yahya Syarif  
**Program Studi**: Sistem Informasi  
**Universitas**: Universitas Negeri Semarang (UNNES)  
**Mata Kuliah**: Pemrograman Web

---

## 📋 DAFTAR ISI

1. [Pendahuluan](#pendahuluan)
2. [Struktur HTML](#struktur-html)
3. [Implementasi CSS](#implementasi-css)
4. [JavaScript Interactivity](#javascript-interactivity)
5. [Responsive Design](#responsive-design)
6. [Bootstrap Integration](#bootstrap-integration)
7. [Animasi dan Transisi](#animasi-dan-transisi)
8. [Best Practices](#best-practices)
9. [Kesimpulan](#kesimpulan)

---

## 1. PENDAHULUAN

### 1.1 Tujuan Pembuatan Website

Website portofolio ini dibuat untuk memenuhi requirement Praktikum 2 Pemrograman Web dengan fokus pada penerapan Cascading Style Sheet (CSS) untuk membuat tampilan web yang menarik, profesional, dan responsif.

### 1.2 Teknologi yang Digunakan

- **HTML5**: Struktur semantic dan konten website
- **CSS3**: Styling, layout, animasi, dan responsive design
- **JavaScript**: Interaktivitas dan dynamic effects
- **Bootstrap 5.3.2**: Framework CSS untuk komponen UI
- **Bootstrap Icons**: Icon library
- **Google Fonts (Poppins)**: Typography

### 1.3 Fitur Utama Website

✅ Layout lengkap dengan header, navigasi, sidebar, main content, dan footer  
✅ Responsive design untuk berbagai ukuran layar  
✅ Animasi running text (teks berjalan)  
✅ Smooth scrolling navigation  
✅ Hover effects dan transitions  
✅ Bootstrap components (buttons, badges, cards)  
✅ Custom CSS styling dengan tema biru profesional  

---

## 2. STRUKTUR HTML

### 2.1 HTML Semantic Elements

Website ini menggunakan semantic HTML5 untuk struktur yang jelas dan SEO-friendly:

```html
<header>    - Header section dengan hero content
<nav>       - Navigation bar
<aside>     - Sidebar dengan informasi tambahan
<main>      - Main content area
<section>   - Content sections (About, Skills, Projects)
<footer>    - Footer dengan informasi kontak
```

**Keuntungan Semantic HTML:**
- Meningkatkan aksesibilitas (accessibility)
- Lebih mudah dibaca dan di-maintain
- SEO optimization
- Struktur yang jelas untuk developer lain

### 2.2 Struktur Layout Keseluruhan

```
├── Header Section
│   ├── Profile Image (Circular)
│   ├── Hero Content (Nama, Deskripsi)
│   ├── Social Links (GitHub, LinkedIn, Instagram)
│   └── Call-to-Action Buttons
│
├── Running Text / Marquee
│   └── Animated scrolling text
│
├── Navigation Bar (Sticky)
│   └── Links: Home, About, Skills, Projects
│
├── Main Container (Grid Layout)
│   ├── Sidebar (col-lg-3)
│   │   ├── Quick Info Card
│   │   ├── Quick Links Navigation
│   │   └── Status Badge
│   │
│   └── Main Content (col-lg-9)
│       ├── About Section
│       ├── Skills Section
│       └── Projects Section
│
└── Footer
    ├── Personal Info
    └── Social Media Links
```

### 2.3 Meta Tags dan Head Section

```html
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

- **charset="UTF-8"**: Support untuk semua karakter termasuk bahasa Indonesia
- **viewport**: Penting untuk responsive design di mobile devices

### 2.4 External Resources

```html
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700">
```

**Mengapa menggunakan CDN?**
- Loading lebih cepat (cached)
- Tidak perlu download file
- Always up-to-date
- Mengurangi beban server

---

## 3. IMPLEMENTASI CSS

### 3.1 CSS Variables (Custom Properties)

Menggunakan CSS Variables untuk maintainability dan konsistensi:

```css
:root {
    --primary-blue: #0d6efd;
    --dark-blue: #0a58ca;
    --light-blue: #6ea8fe;
    --secondary-blue: #084298;
    --bg-light: #f8f9fa;
    --bg-white: #ffffff;
    --text-dark: #212529;
    --text-muted: #6c757d;
    --border-color: #dee2e6;
    --shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    --transition: all 0.3s ease-in-out;
}
```

**Keuntungan CSS Variables:**
- Mudah mengubah tema warna
- Konsistensi styling di seluruh website
- Lebih maintainable
- Dapat diubah dengan JavaScript (dynamic theming)

### 3.2 Typography dan Font

```css
body {
    font-family: 'Poppins', sans-serif;
    line-height: 1.6;
    color: var(--text-dark);
}
```

**Hierarchy Typography:**
- `h1` (hero-title): 3rem (48px)
- `h2` (section-title): 2.5rem (40px)
- `h4` (subsection): 1.3rem (20.8px)
- Body text: 1rem (16px)
- Small text: 0.9rem (14.4px)

### 3.3 Layout System

#### A. Flexbox untuk Header
```css
.header-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.social-links {
    display: flex;
    gap: 15px;
}
```

**Flexbox Benefits:**
- Alignment yang mudah
- Responsive by default
- Gap untuk spacing

#### B. CSS Grid untuk Contact Section
```css
.contact-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
}
```

**Grid Benefits:**
- Layout 2D (baris dan kolom)
- Auto-responsive dengan auto-fit
- Consistent spacing dengan gap

#### C. Bootstrap Grid untuk Main Layout
```html
<div class="row">
    <aside class="col-lg-3 sidebar">...</aside>
    <main class="col-lg-9 main-content">...</main>
</div>
```

**Bootstrap Grid System:**
- 12-column grid
- Responsive breakpoints (sm, md, lg, xl, xxl)
- Mobile-first approach

### 3.4 Box Model dan Spacing

```css
.content-section {
    padding: 40px;        /* Inner spacing */
    margin-bottom: 30px;  /* Outer spacing */
    border-radius: 15px;  /* Rounded corners */
}
```

**Box Model Components:**
1. Content - Konten aktual
2. Padding - Space di dalam border
3. Border - Garis pembatas
4. Margin - Space di luar border

### 3.5 Colors dan Gradients

#### A. Solid Colors
```css
.navbar {
    background-color: var(--primary-blue);
}
```

#### B. Linear Gradients
```css
.header-section {
    background: linear-gradient(135deg, 
                var(--primary-blue) 0%, 
                var(--secondary-blue) 100%);
}
```

**Gradient Direction:**
- 135deg = Diagonal dari kiri atas ke kanan bawah
- 0% = Starting point
- 100% = Ending point

#### C. Transparency
```css
.social-link {
    background: rgba(255, 255, 255, 0.2);  /* 20% opacity */
    backdrop-filter: blur(10px);           /* Glass effect */
}
```

### 3.6 Shadows dan Depth

```css
/* Box Shadow */
.content-section {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

/* Text Shadow */
.hero-title {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}
```

**Shadow Syntax:**
- horizontal-offset vertical-offset blur spread color

**Depth Levels:**
- Light shadow: `0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)`
- Medium shadow: `0 0.5rem 1rem rgba(0, 0, 0, 0.15)`
- Strong shadow: `0 1rem 3rem rgba(0, 0, 0, 0.175)`

### 3.7 Borders dan Border Radius

```css
.profile-image {
    border-radius: 50%;              /* Circular */
    border: 8px solid rgba(255, 255, 255, 0.3);
}

.content-section {
    border-radius: 15px;             /* Rounded corners */
}

.skill-badge {
    border-radius: 20px;             /* Pill shape */
}
```

---

## 4. JAVASCRIPT INTERACTIVITY

### 4.1 Smooth Scrolling

```javascript
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    });
});
```

**Fungsi:**
- Navigasi yang halus ke section yang dituju
- User experience yang lebih baik
- Menghindari jump yang kasar

### 4.2 Active Navigation Tracking

```javascript
window.addEventListener('scroll', () => {
    sections.forEach(section => {
        if (pageYOffset >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});
```

**Fungsi:**
- Highlight menu navigasi berdasarkan section yang sedang dilihat
- Visual feedback untuk user
- Improve navigation experience

### 4.3 Scroll Reveal Animation

```javascript
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
        }
    });
}, observerOptions);
```

**Intersection Observer API:**
- Detect ketika elemen muncul di viewport
- Lebih efficient daripada scroll event
- Trigger animasi saat elemen visible

### 4.4 Back to Top Button

```javascript
window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTop.classList.add('show');
    } else {
        backToTop.classList.remove('show');
    }
});

backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
```

**Fungsi:**
- Muncul setelah scroll 300px
- Quick navigation kembali ke atas
- Smooth animation

### 4.5 Dynamic Navbar Shadow

```javascript
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 0.5rem 1rem rgba(0, 0, 0, 0.25)';
    }
});
```

**Fungsi:**
- Shadow lebih tebal saat scroll
- Visual feedback untuk depth
- Sticky navbar lebih menonjol

---

## 5. RESPONSIVE DESIGN

### 5.1 Mobile-First Approach

CSS ditulis untuk mobile terlebih dahulu, kemudian ditambahkan media queries untuk layar lebih besar.

```css
/* Default: Mobile styles */
.hero-title {
    font-size: 1.8rem;
}

/* Tablet: 768px and up */
@media (min-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
}

/* Desktop: 992px and up */
@media (min-width: 992px) {
    .hero-title {
        font-size: 3rem;
    }
}
```

### 5.2 Breakpoints

```css
/* Small Mobile: max 575px */
@media (max-width: 575px) {
    .profile-image { width: 200px; }
}

/* Mobile: 576px - 767px */
@media (max-width: 767px) {
    .profile-image { width: 250px; }
}

/* Tablet: 768px - 991px */
@media (max-width: 991px) {
    .sidebar { position: static; }
}

/* Desktop: 992px and up */
/* Default styles apply */
```

**Bootstrap Breakpoints:**
- xs: < 576px (Extra small)
- sm: ≥ 576px (Small)
- md: ≥ 768px (Medium)
- lg: ≥ 992px (Large)
- xl: ≥ 1200px (Extra large)
- xxl: ≥ 1400px (Extra extra large)

### 5.3 Responsive Images

```css
.profile-image,
.project-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
```

**object-fit values:**
- `cover`: Mengisi container, crop jika perlu
- `contain`: Fit di dalam container
- `fill`: Stretch untuk mengisi (default)

### 5.4 Responsive Typography

```css
/* Desktop */
.hero-title { font-size: 3rem; }

/* Tablet */
@media (max-width: 991px) {
    .hero-title { font-size: 2.5rem; }
}

/* Mobile */
@media (max-width: 767px) {
    .hero-title { font-size: 2rem; }
}

/* Small Mobile */
@media (max-width: 575px) {
    .hero-title { font-size: 1.8rem; }
}
```

### 5.5 Flexible Layouts

```css
/* Flexbox: Auto wrap on small screens */
.header-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

/* Grid: Auto columns based on available space */
.contact-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
}
```

### 5.6 Viewport Meta Tag

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

**Fungsi:**
- `width=device-width`: Lebar viewport = lebar device
- `initial-scale=1.0`: Zoom level default 1x
- Penting untuk mobile responsive

---

## 6. BOOTSTRAP INTEGRATION

### 6.1 Bootstrap Grid System

```html
<div class="container-fluid">
    <div class="row">
        <aside class="col-lg-3">Sidebar</aside>
        <main class="col-lg-9">Main Content</main>
    </div>
</div>
```

**Grid Classes:**
- `container`: Fixed width, centered
- `container-fluid`: Full width
- `row`: Wrapper untuk columns
- `col-{breakpoint}-{size}`: Column size

### 6.2 Bootstrap Components

#### A. Buttons
```html
<a href="#" class="btn btn-primary btn-lg">
    <i class="bi bi-github me-2"></i>GitHub
</a>
```

**Button Variants:**
- `btn-primary`: Biru utama
- `btn-success`: Hijau
- `btn-danger`: Merah
- `btn-outline-primary`: Outline only

**Button Sizes:**
- `btn-sm`: Small
- Default: Medium
- `btn-lg`: Large

#### B. Badges
```html
<span class="badge bg-primary">HTML5</span>
<span class="badge bg-success">PHP</span>
<span class="badge bg-danger">MySQL</span>
```

**Badge Colors:**
- `bg-primary`, `bg-success`, `bg-danger`, `bg-warning`, `bg-info`, `bg-secondary`

#### C. Cards
```html
<div class="card">
    <img src="..." class="card-img-top">
    <div class="card-body">
        <h4 class="card-title">Title</h4>
        <p class="card-text">Description</p>
    </div>
</div>
```

#### D. Navigation
```html
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
        </li>
    </ul>
</nav>
```

**Navbar Classes:**
- `navbar-expand-lg`: Collapse pada lg breakpoint
- `navbar-dark`: Dark theme
- `sticky-top`: Sticky positioning

### 6.3 Bootstrap Utilities

#### A. Spacing
```html
<div class="mb-4">    <!-- margin-bottom: 1.5rem -->
<div class="mt-5">    <!-- margin-top: 3rem -->
<div class="p-3">     <!-- padding: 1rem -->
```

**Spacing Scale:**
- 0 = 0
- 1 = 0.25rem (4px)
- 2 = 0.5rem (8px)
- 3 = 1rem (16px)
- 4 = 1.5rem (24px)
- 5 = 3rem (48px)

#### B. Display
```html
<div class="d-flex">              <!-- display: flex -->
<div class="d-none d-md-block">   <!-- hidden on mobile -->
```

#### C. Text Alignment
```html
<div class="text-center">         <!-- text-align: center -->
<div class="text-md-end">         <!-- align right on medium+ -->
```

### 6.4 Bootstrap Icons

```html
<i class="bi bi-github"></i>
<i class="bi bi-linkedin"></i>
<i class="bi bi-envelope-fill"></i>
```

**Icon Sizing:**
```css
.bi { font-size: 1.5rem; }        /* Default */
.bi-lg { font-size: 2rem; }       /* Large */
```

---

## 7. ANIMASI DAN TRANSISI

### 7.1 CSS Transitions

```css
.project-card {
    transition: all 0.3s ease-in-out;
}

.project-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}
```

**Transition Properties:**
- `property`: all, transform, opacity, color, dll
- `duration`: 0.3s, 500ms, dll
- `timing-function`: ease, linear, ease-in-out, cubic-bezier
- `delay`: 0s, 0.5s, dll

**Timing Functions:**
- `ease`: Slow start, fast middle, slow end
- `linear`: Constant speed
- `ease-in`: Slow start
- `ease-out`: Slow end
- `ease-in-out`: Slow start and end

### 7.2 CSS Transforms

```css
/* Translate (Move) */
transform: translateY(-10px);

/* Scale (Zoom) */
transform: scale(1.05);

/* Rotate */
transform: rotate(3deg);

/* Multiple transforms */
transform: translateY(-5px) scale(1.1) rotate(2deg);
```

### 7.3 CSS Keyframe Animations

#### A. Running Text Animation
```css
@keyframes scroll-text {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.running-text {
    animation: scroll-text 20s linear infinite;
}
```

**Animation Properties:**
- `animation-name`: scroll-text
- `animation-duration`: 20s
- `animation-timing-function`: linear
- `animation-iteration-count`: infinite
- `animation-direction`: normal, reverse, alternate

#### B. Fade In Animations
```css
@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.sidebar {
    animation: fadeInLeft 0.8s ease-out;
}
```

#### C. Pulse Animation
```css
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.pulse-dot {
    animation: pulse 2s infinite;
}
```

### 7.4 Hover Effects

#### A. Card Hover
```css
.project-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}
```

#### B. Button Hover
```css
.btn-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
```

#### C. Image Overlay
```css
.project-overlay {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.project-card:hover .project-overlay {
    opacity: 1;
}
```

#### D. Icon Rotation
```css
.contact-icon {
    transition: transform 0.3s ease-in-out;
}

.contact-info-item:hover .contact-icon {
    transform: scale(1.1) rotate(10deg);
}
```

### 7.5 Performance Optimization

```css
/* Use transform and opacity for smooth animations */
/* GPU-accelerated properties */
.element {
    transform: translateZ(0);  /* Force GPU acceleration */
    will-change: transform;     /* Hint browser about changes */
}
```

**Best Practices:**
- Gunakan `transform` dan `opacity` untuk animasi smooth
- Hindari animasi pada `width`, `height`, `top`, `left`
- Gunakan `will-change` untuk hint browser
- Limit animation duration (0.2s - 0.5s optimal)

---

## 8. BEST PRACTICES

### 8.1 Code Organization

#### A. File Structure
```
portofolioku/
├── index.html          # Main HTML file
├── style.css           # Custom CSS
├── script.js           # JavaScript
├── images/             # Image assets
│   ├── profile.jpeg
│   ├── topup-game.png
│   ├── simple-html.png
│   └── portfolio-web.png
├── README.md           # Documentation
└── .gitignore          # Git ignore file
```

#### B. CSS Organization
```css
/* 1. CSS Variables */
:root { ... }

/* 2. Global Styles */
*, body, html { ... }

/* 3. Layout Sections */
.header-section { ... }
.navbar { ... }
.sidebar { ... }
.main-content { ... }
.footer { ... }

/* 4. Components */
.project-card { ... }
.skill-badge { ... }

/* 5. Animations */
@keyframes fadeIn { ... }

/* 6. Media Queries */
@media (max-width: 768px) { ... }
```

### 8.2 Naming Conventions

#### A. BEM Methodology (Block Element Modifier)
```css
/* Block */
.project-card { ... }

/* Element */
.project-card__image { ... }
.project-card__title { ... }

/* Modifier */
.project-card--featured { ... }
```

#### B. Descriptive Class Names
```css
/* Good ✅ */
.hero-title
.contact-info-grid
.social-link

/* Bad ❌ */
.title1
.grid2
.link
```

### 8.3 Accessibility (A11y)

#### A. Semantic HTML
```html
<header>, <nav>, <main>, <aside>, <footer>
<h1>, <h2>, <h3> (Proper heading hierarchy)
<button> for buttons, <a> for links
```

#### B. Alt Text untuk Images
```html
<img src="profile.jpeg" alt="Haidar Yahya Syarif">
<img src="topup-game.png" alt="TopUp Game System Screenshot">
```

#### C. ARIA Labels
```html
<button aria-label="Back to top">↑</button>
<nav aria-label="Main navigation">...</nav>
```

#### D. Keyboard Navigation
```css
/* Focus visible for keyboard users */
a:focus-visible,
button:focus-visible {
    outline: 3px solid var(--primary-blue);
    outline-offset: 2px;
}
```

#### E. Color Contrast
- Pastikan contrast ratio minimal 4.5:1 untuk teks normal
- 3:1 untuk teks besar (18px+ atau 14px+ bold)
- Gunakan tools seperti WebAIM Contrast Checker

### 8.4 Performance Optimization

#### A. Image Optimization
- Compress images (TinyPNG, ImageOptim)
- Use appropriate formats (JPEG untuk foto, PNG untuk grafis)
- Implement lazy loading untuk images

#### B. CSS Optimization
```css
/* Use shorthand properties */
margin: 10px 20px 15px 5px;  /* Instead of 4 separate properties */
font: 600 1rem/1.6 'Poppins', sans-serif;

/* Combine selectors */
.card, .sidebar, .footer {
    box-shadow: var(--shadow);
}
```

#### C. JavaScript Optimization
- Minimize DOM manipulation
- Use event delegation
- Debounce scroll events

### 8.5 Browser Compatibility

#### A. Vendor Prefixes
```css
.element {
    -webkit-transform: translateY(-10px);
    -moz-transform: translateY(-10px);
    -ms-transform: translateY(-10px);
    transform: translateY(-10px);
}
```

#### B. Fallbacks
```css
.header-section {
    background: #0d6efd;  /* Fallback */
    background: linear-gradient(135deg, #0d6efd 0%, #084298 100%);
}
```

### 8.6 Code Comments

```css
/* ===================================
   Section Header
   =================================== */

/* Subsection explanation */
.class-name {
    property: value;  /* Inline comment for specific property */
}
```

### 8.7 Validation

- **HTML Validation**: https://validator.w3.org/
- **CSS Validation**: https://jigsaw.w3.org/css-validator/
- **Accessibility Check**: https://wave.webaim.org/

---

## 9. KESIMPULAN

### 9.1 Pencapaian

Website portofolio ini telah berhasil memenuhi semua requirement praktikum:

✅ **Layout Lengkap**
- Header dengan hero section
- Sticky navigation bar
- Sidebar dengan quick info dan links
- Main content dengan multiple sections
- Footer dengan informasi kontak

✅ **CSS Styling**
- Custom CSS dengan tema biru profesional
- CSS Variables untuk maintainability
- Flexbox dan CSS Grid untuk layout
- Shadows, borders, dan visual effects

✅ **Responsive Design**
- Mobile-first approach
- Media queries untuk berbagai breakpoints
- Bootstrap grid system
- Responsive typography dan images

✅ **Animasi**
- Running text dengan CSS keyframes
- Hover effects dan transitions
- Scroll reveal animations
- Smooth scrolling

✅ **Bootstrap Integration**
- Buttons, badges, dan cards
- Navigation components
- Grid system
- Utility classes

### 9.2 Pembelajaran

Melalui praktikum ini, telah dipelajari:

1. **HTML Structure**
   - Semantic HTML5 elements
   - Proper document structure
   - Accessibility considerations

2. **CSS Fundamentals**
   - Selectors dan specificity
   - Box model
   - Display dan positioning
   - Flexbox dan Grid

3. **Advanced CSS**
   - CSS Variables
   - Animations dan transitions
   - Transforms
   - Gradients dan shadows

4. **Responsive Design**
   - Media queries
   - Mobile-first approach
   - Flexible layouts
   - Viewport configuration

5. **Bootstrap Framework**
   - Grid system
   - Components
   - Utilities
   - Customization

6. **JavaScript Basics**
   - DOM manipulation
   - Event listeners
   - Intersection Observer API
   - Smooth animations

7. **Best Practices**
   - Code organization
   - Naming conventions
   - Performance optimization
   - Accessibility

### 9.3 Pengembangan Selanjutnya

Fitur-fitur yang dapat ditambahkan di masa depan:

1. **Dark Mode Toggle**
   - Switch tema light/dark
   - Persist user preference
   - Smooth transition

2. **Contact Form**
   - Form validation
   - Email integration
   - Success/error handling

3. **Blog Section**
   - Dynamic content loading
   - Search functionality
   - Categories dan tags

4. **Project Filtering**
   - Filter by technology
   - Search projects
   - Sort options

5. **Animations Enhancement**
   - More scroll animations
   - Parallax effects
   - Loading animations

6. **Performance**
   - Lazy loading images
   - Code minification
   - Progressive Web App (PWA)

7. **Backend Integration**
   - Database untuk projects
   - CMS untuk content management
   - Analytics tracking

### 9.4 Refleksi

Pembuatan website portofolio ini memberikan pemahaman mendalam tentang:

- Pentingnya **semantic HTML** untuk struktur yang baik
- Kekuatan **CSS** dalam mengubah tampilan website
- **Responsive design** sebagai keharusan di era mobile
- **Bootstrap** sebagai tools yang mempercepat development
- **JavaScript** untuk interaktivity dan user experience
- **Best practices** untuk code yang maintainable

Website ini tidak hanya memenuhi requirement akademis, tetapi juga menjadi portfolio personal yang dapat digunakan untuk menunjukkan kemampuan kepada calon employer atau client.

---

## 📚 REFERENSI

### Dokumentasi Official
1. **MDN Web Docs** - https://developer.mozilla.org/
   - HTML, CSS, JavaScript documentation
   
2. **Bootstrap Documentation** - https://getbootstrap.com/docs/5.3/
   - Grid system, components, utilities
   
3. **CSS-Tricks** - https://css-tricks.com/
   - CSS techniques dan tips
   
4. **W3Schools** - https://www.w3schools.com/
   - Tutorials dan references

### Tools dan Resources
1. **Google Fonts** - https://fonts.google.com/
2. **Bootstrap Icons** - https://icons.getbootstrap.com/
3. **Can I Use** - https://caniuse.com/ (Browser compatibility)
4. **ColorHunt** - https://colorhunt.co/ (Color palettes)

### Modul Praktikum
1. Modul 04 - Cascading Style Sheet
2. Modul 05 - Desain Web CSS
3. Modul 06 - Desain Web Responsif

---

**Disusun oleh:**  
Haidar Yahya Syarif  
Sistem Informasi - UNNES  
2024

**Repository GitHub:**  
https://github.com/yahyasyarif9/portofolio-web

---

*Dokumen ini dibuat sebagai bagian dari dokumentasi Praktikum Pemrograman Web dan dapat digunakan sebagai referensi untuk pembelajaran lebih lanjut.*
