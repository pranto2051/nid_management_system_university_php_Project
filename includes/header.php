<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NID Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease;
        }
        .navbar.sticky-top {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-toggler {
            border: none !important;
            padding: 0.25rem 0.5rem !important;
        }
        .navbar-toggler:focus {
            box-shadow: none !important;
            outline: none !important;
        }
        .navbar-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%231e293b' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            width: 1.5rem;
            height: 1.5rem;
            transition: background-image 0.3s ease;
        }
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%231e293b' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M6 6l18 18M6 24L24 6'/%3e%3c/svg%3e") !important;
        }
        .navbar-collapse {
            transition: all 0.3s ease;
            max-height: none !important;
            overflow: visible !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: #1e293b !important;
            transition: color 0.3s ease;
            padding: 0.5rem 0.75rem !important;
        }
        .nav-link.active {
            color: #2563eb !important;
            border-bottom: 2px solid #2563eb;
        }
        .nav-link:hover {
            color: #2563eb !important;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            color: white;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }
        
        /* Desktop Navbar */
        @media (min-width: 992px) {
            .navbar-collapse {
                display: flex !important;
                visibility: visible !important;
                position: static !important;
                height: auto !important;
                overflow: visible !important;
            }
            
            .navbar-nav {
                gap: 0.5rem;
            }
            
            .btn-primary-custom {
                width: auto;
                margin-left: 1.5rem;
            }
        }
        
        /* Mobile Menu Improvements */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: #ffffff;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                border-top: 1px solid #e2e8f0;
                padding: 0;
                margin-top: 0;
                z-index: 1000;
                border-radius: 0 0 0.5rem 0.5rem;
            }
            
            .navbar-collapse.show {
                display: block !important;
                visibility: visible;
            }
            
            .navbar-collapse:not(.show) {
                display: none !important;
                visibility: hidden;
            }
            
            .navbar-nav {
                flex-direction: column;
                width: 100%;
                gap: 0;
            }
            
            .nav-item {
                width: 100%;
                margin: 0;
                padding: 0;
                border-bottom: 1px solid #f1f5f9;
            }
            
            .nav-item:last-child {
                border-bottom: none;
            }
            
            .nav-link {
                display: block;
                padding: 1rem 1.5rem;
                border: none;
                color: #1e293b !important;
                text-decoration: none;
            }
            
            .nav-link:hover {
                background-color: #f8fafc;
                color: #2563eb !important;
            }
            
            .nav-link.active {
                background-color: #eff6ff;
                color: #2563eb !important;
                border-left: 4px solid #2563eb;
                padding-left: calc(1.5rem - 4px);
            }
            
            .ms-lg-3 {
                margin-left: 0;
            }
            
            .btn-primary-custom {
                width: calc(100% - 3rem);
                margin: 1rem 1.5rem;
                padding: 0.75rem 1.5rem !important;
                display: block;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top py-3" style="z-index: 1030;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="fas fa-id-card text-blue-600 text-2xl me-2"></i>
            <span class="fw-bold text-slate-800">NID Management</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" <?php echo $current_page == 'index.php' ? 'aria-current="page"' : ''; ?> href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo $current_page == 'about.php' ? 'active' : ''; ?>" <?php echo $current_page == 'about.php' ? 'aria-current="page"' : ''; ?> href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($current_page == 'find-nid-form.php' || $current_page == 'find-nid.php') ? 'active' : ''; ?>" <?php echo ($current_page == 'find-nid-form.php' || $current_page == 'find-nid.php') ? 'aria-current="page"' : ''; ?> href="find-nid-form.php">Find NID</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($current_page == 'registration.php') ? 'active' : ''; ?>" <?php echo ($current_page == 'registration.php') ? 'aria-current="page"' : ''; ?> href="registration.php">Registration</a>
                </li>
                <!-- <li class="nav-item ms-lg-3">
                    <?php if(isset($_SESSION['admin_id'])): ?>
                        <a class="btn btn-primary-custom" href="admin/dashboard.php">
                            <i class="fas fa-th-large me-2"></i>Dashboard
                        </a>
                    <?php else: ?>
                        <a class="btn btn-primary-custom" href="admin/login.php">
                            <i class="fas fa-user-shield me-2"></i>Admin Login
                        </a>
                    <?php endif; ?>
                </li> -->
            </ul>
        </div>
    </div>
</nav>
