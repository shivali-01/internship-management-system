# Company Internship Portal

A full-featured **PHP + MySQL** web platform that lets companies **Register, Login, and Manage Internship Listings** with complete **CRUD (Create, Read, Update, Delete)** operations. Built with a clean responsive UI, secure password hashing, session-based authentication, and an OOP-based PDO database layer.

---

## 📁 Project Structure

```
company internship portal/
├── config/
│   ├── config.php          # Site & DB configuration
│   └── database.php        # PDO Database class (OOP approach)
├── includes/
│   ├── header.php          # Shared header + navbar
│   ├── footer.php          # Shared footer
│   └── functions.php       # Helper functions (validation, sanitize, flash messages, etc.)
├── database/
│   └── schema.sql          # MySQL tables (companies, internships)
├── assets/
│   ├── css/style.css       # Full responsive UI design
│   └── js/script.js        # Client-side validation & interactions
├── index.php               # Home / Landing page
├── register.php            # Company Registration page
├── login.php               # Company Login page
├── logout.php              # Session destroy + redirect
├── dashboard.php           # Dashboard: VIEW all internships + stats
├── add_internship.php      # ADD new internship (full form + validation)
├── edit_internship.php     # MODIFY existing internship
├── view_internship.php     # VIEW single internship details
└── delete_internship.php   # DELETE internship (with confirmation)
```

---

## ✨ Key Features

### 🔐 Authentication
- **Company Registration** with full server-side + client-side validation
- **Company Login** with secure password hashing (`password_hash` / `password_verify`)
- **Session management** (`requireLogin()` protects all dashboard pages)
- Session-based flash messages for success/error notifications
- Auto-redirect logged-in users away from login/register pages

### 📝 Full CRUD for Internships
| Operation | File | Description |
|-----------|------|-------------|
| **ADD**    | `add_internship.php`  | Full form with validation (title, location, duration, stipend, last date, description, skills, vacancies, type, status) |
| **VIEW**   | `dashboard.php` + `view_internship.php`  | List view in dashboard with stats table + single-page detailed view |
| **MODIFY / EDIT** | `edit_internship.php`  | Pre-populated form to update all internship fields |
| **DELETE** | `delete_internship.php`  | Delete internship with JS confirmation dialog |

### 📊 Dashboard Statistics
- **Total Internships** posted by the company
- **Active Listings** currently open
- **Expiring in 7 Days** — warnings for deadlines approaching
- Data table with full listing info + action buttons

### 🛡️ Security & Validation
- **Input Sanitization** (`sanitize()`) — prevents XSS attacks
- **PDO Prepared Statements** — prevents SQL injection
- **Email & Phone Validation** (`validateEmail()`, `validatePhone()`)
- **Server-Side Form Validation** on every POST request
- **Password Hashing** with PHP's native bcrypt

### 🎨 UI/UX
- Fully responsive CSS design (mobile, tablet, desktop)
- Clean gradient hero section on landing page
- Modern card-based stats & tables
- Flash message alerts (success/error)
- Status badges (Active / Inactive / Expired)
- Currency & date formatting helpers

---

## 🛠️ Technologies Used

| Layer | Tech |
|-------|------|
| **Backend**   | PHP 7.4+ (OOP PDO for DB) |
| **Database**  | MySQL 5.7+ / MariaDB 10.2+ |
| **Frontend**  | HTML5, CSS3, JavaScript (Vanilla JS) |
| **Server**    | Apache (XAMPP / WAMP / MAMP / LAMP stack) |
| **Auth**      | PHP Sessions + bcrypt password hashing |

---

## ✅ Prerequisites

Make sure you have installed:

1. **PHP** 7.4 or newer
2. **MySQL** 5.7+ or **MariaDB** 10.2+
3. **Apache** web server
4. **XAMPP / WAMP / MAMP / LAMP** (recommended all-in-one stack)
   - Download XAMPP: https://www.apachefriends.org/
   - Download WAMP: http://www.wampserver.com/

---

## 🚀 Installation & Setup

### Step 1 — Place Project in Web Root

Copy the entire `company internship portal` folder into your web server's document root:

| OS / Stack | Path |
|------------|------|
| XAMPP (Windows) | `C:\xampp\htdocs\` |
| WAMP (Windows)  | `C:\wamp64\www\` |
| XAMPP (macOS)   | `/Applications/XAMPP/htdocs/` |
| LAMP (Linux)    | `/var/www/html/` |

> 💡 You can rename the folder (e.g., to `internship-portal`) to avoid spaces in URLs.

### Step 2 — Create MySQL Database

1. Open the **XAMPP / WAMP Control Panel** and start **Apache** + **MySQL**.
2. Open **phpMyAdmin** in your browser:  
   👉 `http://localhost/phpmyadmin`
3. Click **New** (left sidebar) → create a database:
   - **Database name**: `internship_portal`
   - **Collation**: `utf8mb4_general_ci`
   - Click **Create**
4. Select the `internship_portal` database → click the **Import** tab
5. Choose the file `database/schema.sql` from the project folder
6. Click **Go** — you will see 2 tables created: `companies` and `internships` ✅

### Step 3 — Configure the App

Open [config.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/config/config.php) and update the settings:

```php
// Database Configuration
define('DB_HOST', 'localhost');    // DB host (usually localhost)
define('DB_USER', 'root');         // DB username (XAMPP default: root)
define('DB_PASS', '');             // DB password (XAMPP default: empty)
define('DB_NAME', 'internship_portal'); // DB name from Step 2

// Site Configuration
define('SITE_NAME', 'Internship Portal');
define('BASE_URL', 'http://localhost/internship-portal'); // ⚠️ UPDATE THIS
```

> ⚠️ **Critical**: Make sure `BASE_URL` matches your actual folder path. Examples:
> - Folder `htdocs/internship-portal` → `http://localhost/internship-portal`
> - Folder `htdocs/company internship portal` → `http://localhost/company%20internship%20portal`

---

## ▶️ How to Run

1. **Start Servers**
   - Open XAMPP/WAMP Control Panel
   - Start **Apache** and **MySQL** (both should show "Running" in green)

2. **Open the App**
   - Open your browser (Chrome / Firefox / Edge)
   - Go to your `BASE_URL`, e.g.:
     ```
     http://localhost/internship-portal
     ```
   - You should see the landing page: **"Find & Post Internship Opportunities"**

3. **Register a Company Account**
   - Click **Register Your Company**
   - Fill the form: Company Name, Email, Password, Phone (10 digits), Address, Industry
   - Optional fields: Description, Website
   - Click **Register**

4. **Login & Manage Internships**
   - Login with your registered email & password
   - You'll land on the **Company Dashboard**
   - Click **+ Post New Internship** → fill details → **Post Internship**
   - Use the **View / Edit / Delete** buttons in the dashboard table

---

## 📄 Pages Reference

| Page | File | Access | Description |
|------|------|--------|-------------|
| Home | [index.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/index.php) | Public | Landing page with hero + feature cards |
| Register | [register.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/register.php) | Guests only | Create a company account |
| Login | [login.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/login.php) | Guests only | Login to the dashboard |
| Logout | [logout.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/logout.php) | Logged-in | Destroy session, redirect home |
| Dashboard | [dashboard.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/dashboard.php) | Logged-in | Stats cards + all internships table |
| Add Internship | [add_internship.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/add_internship.php) | Logged-in | Full form to create new internship |
| Edit Internship | [edit_internship.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/edit_internship.php) | Logged-in | Update existing internship |
| View Internship | [view_internship.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/view_internship.php) | Logged-in | Detailed view of one internship |
| Delete Internship | [delete_internship.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/delete_internship.php) | Logged-in | Delete internship with JS confirm |

---

## 🗄️ Database Schema

### Table: `companies`
Stores all registered company accounts.

| Column | Type | Details |
|--------|------|---------|
| `id` | INT | PK, Auto Increment |
| `company_name` | VARCHAR(255) | NOT NULL |
| `email` | VARCHAR(255) | NOT NULL, UNIQUE |
| `password` | VARCHAR(255) | NOT NULL (bcrypt hash) |
| `phone` | VARCHAR(20) | NOT NULL |
| `address` | TEXT | NOT NULL |
| `industry` | VARCHAR(100) | NOT NULL |
| `description` | TEXT | NULL |
| `website` | VARCHAR(255) | NULL |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP |

### Table: `internships`
Stores internship postings (FK → companies.id).

| Column | Type | Details |
|--------|------|---------|
| `id` | INT | PK, Auto Increment |
| `company_id` | INT | FK → `companies(id)` ON DELETE CASCADE |
| `title` | VARCHAR(255) | NOT NULL |
| `location` | VARCHAR(255) | NOT NULL |
| `duration` | VARCHAR(100) | NOT NULL |
| `stipend` | DECIMAL(10,2) | NOT NULL |
| `last_date_to_apply` | DATE | NOT NULL |
| `description` | TEXT | NOT NULL |
| `requirements` | TEXT | NULL |
| `skills_required` | TEXT | NULL |
| `vacancies` | INT | DEFAULT 1 |
| `internship_type` | VARCHAR(50) | DEFAULT 'Full-time' |
| `status` | VARCHAR(20) | DEFAULT 'Active' |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP |
| `updated_at` | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP |

---

## 🧩 Core Helper Functions

All helpers live in [includes/functions.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/includes/functions.php):

| Function | Purpose |
|----------|---------|
| `sanitize($data)` | Trim, stripslashes, htmlspecialchars — clean user input |
| `redirect($url)` | Safe header redirect + exit |
| `isLoggedIn()` | Check if `$_SESSION['company_id']` is set |
| `requireLogin()` | Redirect guests to login with error flash |
| `setFlash($msg, $type)` | Store flash message in session |
| `getFlash()` | Render + clear flash alert |
| `validateEmail($email)` | FILTER_VALIDATE_EMAIL check |
| `validatePhone($phone)` | Regex 10-digit check |
| `formatDate($str)` | Format to "F j, Y" |
| `formatCurrency($amt)` | Format as "Rs. X,XXX.XX" |
| `hashPassword($p)` | `password_hash(..., PASSWORD_DEFAULT)` |
| `verifyPassword($p, $h)` | `password_verify(...)` |

---

## 🔧 Troubleshooting

### ❌ "Database Connection Failed"
- Ensure **MySQL** is running in XAMPP/WAMP
- Double-check credentials in `config/config.php`
- Confirm the database `internship_portal` exists

### ❌ Blank White Screen
- PHP error reporting is ON in [config.php](file:///c:/Users/DELL/OneDrive/Desktop/shivali/company%20internship%20portal/config/config.php) — check for error text
- Review Apache error logs for clues

### ❌ Cannot Login After Registering
- Verify the `companies` table has your row via phpMyAdmin
- Passwords are hashed — never paste raw text directly into DB

### ❌ 404 Page Not Found
- Project must be inside the server's document root (`htdocs` / `www` / `html`)
- `BASE_URL` in `config/config.php` must exactly match your folder name
- Spaces in folder names → use `%20` encoding in URL, or rename folder

---
