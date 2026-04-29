# NID Card Management System

A comprehensive and secure web-based application for managing National Identification (NID) cards. This system allows citizens to register for NIDs and search for their information, while providing administrators with a powerful dashboard to manage user records, update details, and oversee the registration process.

## 🚀 Features

### Public Portal
- **Landing Page**: A modern, responsive homepage introducing the system.
- **Online Registration**: Easy-to-use form for citizens to register with personal details and profile photo upload.
- **Find NID**: Search functionality to retrieve NID information using specific identifiers.
- **About Section**: Detailed information about the NID management process and system goals.

### Admin Dashboard
- **Secure Login**: Authentication system for administrative access.
- **Analytics Overview**: Dashboard displaying key metrics (Total Registrations, etc.).
- **User Management**: 
    - View all registered citizens in a structured table.
    - Add new citizens directly from the admin panel.
    - Edit/Update existing citizen information and profile photos.
    - Delete redundant or incorrect records.
- **Pagination & Search**: Efficiently manage large datasets with built-in search and numerical pagination.
- **Responsive Sidebar**: Intuitive navigation optimized for both desktop and mobile devices.

---

## 🛠️ Tech Stack
- **Frontend**: HTML5, CSS3 (Vanilla), JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Web Server**: XAMPP / Apache

---

## ⚙️ Setup Instructions

### 1. Prerequisites
- Install [XAMPP](https://www.apachefriends.org/index.html) or any WAMP/MAMP server.
- Ensure Apache and MySQL services are running.

### 2. Database Configuration
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a new database named `nid_card_management`.
3. Select the database and run the following SQL commands:

```sql
-- Create Admin Table
CREATE TABLE IF NOT EXISTS admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Citizens Table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    nid_number BIGINT UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    mobile_no VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    father_name VARCHAR(100) NOT NULL,
    mother_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    img VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Default Admin Credentials
-- Email: admin@nid.com | Password: admin123
INSERT INTO admins (full_name, email, password)
VALUES ('Super Admin', 'admin@nid.com', 'admin123');
```

### 3. Application Setup
1. Clone or download the project folder.
2. Move the project folder to `C:\xampp\htdocs\` (or your server's root directory).
3. Open your browser and navigate to `http://localhost/NID Card Management System/`.

---

## 📸 Directory Structure
- `/admin`: Administrative panel and management files.
- `/assets`: CSS, JS, and image assets.
- `/config`: Database connection and configuration.
- `/uploads`: Directory for stored profile images.
- `index.php`: Main landing page.
- `registration.php`: Public registration portal.
- `find-nid.php`: Public search portal.

---

## 👨‍💻 Developer Note
This system was built with a focus on modern UI/UX principles, featuring glassmorphism elements, responsive layouts, and a clean administrative interface.
