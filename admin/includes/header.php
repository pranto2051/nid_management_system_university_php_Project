<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NID System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --top-bar-height: 70px;
            --primary-color: #2563eb;
            --sidebar-bg: #0f172a;
            --body-bg: #f8fafc;
        }
        body, html {
            height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: var(--body-bg);
            font-family: 'Inter', sans-serif;
            color: #1e293b;
        }
        .dashboard-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            width: 100%;
        }
        .top-row {
            height: var(--top-bar-height);
            width: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            z-index: 1010;
            flex-shrink: 0;
        }
        .body-row {
            height: calc(100vh - var(--top-bar-height));
            width: 100%;
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }
        .sidebar-left {
            width: var(--sidebar-width);
            height: 100%;
            background-color: var(--sidebar-bg);
            color: #94a3b8;
            overflow-y: auto;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .main-right {
            flex-grow: 1;
            height: 100%;
            padding: 2rem;
            overflow-y: auto;
            background-color: var(--body-bg);
            box-sizing: border-box;
            scroll-behavior: smooth;
        }
        .nav-link-admin {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            color: #94a3b8;
            text-decoration: none !important;
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            margin: 0.25rem 1rem;
            font-weight: 500;
        }
        .nav-link-admin:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .nav-link-admin.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }
        .nav-link-admin i {
            width: 20px;
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        @media (max-width: 991.98px) {
            .top-row {
                padding: 0 1rem;
            }
            .sidebar-left {
                position: fixed;
                left: -100%;
                width: 280px;
                top: 0;
                height: 100vh;
                z-index: 1050;
                box-shadow: 20px 0 50px rgba(0,0,0,0.1);
            }
            .sidebar-left.show {
                left: 0;
            }
            .main-right {
                width: 100%;
                padding: 1.5rem 1rem;
            }
            #sidebarOverlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(4px);
                z-index: 1040;
                animation: fadeIn 0.3s ease;
            }
            #sidebarOverlay.show {
                display: block;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Premium Card Styles */
        .admin-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid rgba(226, 232, 240, 0.7);
            box-shadow: 0 1px 3px rgba(0,0,0,0.02), 0 4px 6px rgba(0,0,0,0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .admin-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        }
        
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8fafc;
            border-bottom: 2px solid #f1f5f9;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<div class="dashboard-container">
    <!-- Top Row (Professional Header) -->
    <div class="top-row">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center bg-blue-600 rounded-lg p-2 shadow-lg shadow-blue-200">
                    <i class="fas fa-id-card text-white fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-slate-900 mb-0">NID Admin</h5>
                    <p class="small text-slate-500 mb-0 d-none d-sm-block">Management System</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3 gap-md-4">
                <div class="d-none d-lg-block border-end pe-4 me-2">
                    <h5 class="fw-bold text-slate-800 mb-0">
                        <?php 
                            $page = basename($_SERVER['PHP_SELF'], ".php");
                            echo ucfirst($page == 'dashboard' ? 'Overview' : str_replace('-', ' ', $page));
                        ?>
                    </h5>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <p class="small fw-bold mb-0 text-slate-900"><?php echo $_SESSION['admin_name']; ?></p>
                        <span class="badge bg-blue-50 text-blue-600 rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">ADMIN</span>
                    </div>
                    <div class="position-relative">
                        <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['admin_name']; ?>&background=2563eb&color=fff&bold=true" 
                             class="rounded-xl border border-white shadow-sm" width="42" height="42">
                        <span class="position-absolute bottom-0 end-0 bg-emerald-500 border border-2 border-white rounded-circle p-1"></span>
                    </div>
                    <button class="btn btn-light rounded-circle shadow-sm d-lg-none" id="sidebarToggle" style="width: 42px; height: 42px;">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Body Row -->
    <div class="body-row">
        <div id="sidebarOverlay"></div>
        
        <!-- Sidebar Navigation -->
        <div class="sidebar-left" id="sidebar">
            <div class="p-4 d-lg-none d-flex justify-content-between align-items-center border-bottom border-white/5">
                <span class="fw-bold text-white">Menu</span>
                <button class="btn btn-link text-white/50 p-0 text-decoration-none" id="sidebarClose">
                    <i class="fas fa-times fs-4"></i>
                </button>
            </div>
            
            <div class="px-3 py-4">
                <p class="text-slate-500 px-3 small fw-bold text-uppercase mb-3" style="font-size: 0.7rem; letter-spacing: 0.1em;">Main Menu</p>
                <nav>
                    <a href="dashboard.php" class="nav-link-admin <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                        <i class="fas fa-th-large"></i> <span>Dashboard</span>
                    </a>
                    <a href="users.php" class="nav-link-admin <?php echo in_array(basename($_SERVER['PHP_SELF']), ['users.php', 'edit-user.php']) ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> <span>Manage Users</span>
                    </a>
                    <a href="add-user.php" class="nav-link-admin <?php echo basename($_SERVER['PHP_SELF']) == 'add-user.php' ? 'active' : ''; ?>">
                        <i class="fas fa-user-plus"></i> <span>Add New User</span>
                    </a>
                    
                    <p class="text-slate-500 px-3 small fw-bold text-uppercase mt-5 mb-3" style="font-size: 0.7rem; letter-spacing: 0.1em;">System</p>
                    <a href="../index.php" class="nav-link-admin">
                        <i class="fas fa-external-link-alt"></i> <span>View Website</span>
                    </a>
                    <a href="logout.php" class="nav-link-admin text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-right">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    function toggleSidebar() {
        sidebar.classList.toggle('show');
        if (overlay) overlay.classList.toggle('show');
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        if (overlay) overlay.classList.remove('show');
    }

    if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
    if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
</script>
</body>
</html>
