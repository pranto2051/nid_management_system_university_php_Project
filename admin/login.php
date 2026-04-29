<?php
session_start();
require_once '../config/db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();

            // For this project, we check plain text as per the provided SQL insert
            if ($admin && $password === $admin['password']) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $error = "Connection error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NID System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

<div class="login-card text-white">
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-blue-600 rounded-2xl d-flex align-items-center justify-content-center mx-auto mb-4 shadow-lg shadow-blue-500/30">
            <i class="fas fa-user-shield fs-1"></i>
        </div>
        <h2 class="h3 fw-bold mb-2">Admin Portal</h2>
        <p class="text-slate-400">Secure access to NID Management System</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger bg-red-500/10 border-red-500/20 text-red-400 rounded-xl mb-6">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-5">
        <div>
            <label class="form-label text-slate-300 small fw-bold uppercase tracking-wider">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-white/5 border-white/10 text-slate-500">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control bg-white/5 border-white/10 text-white placeholder-slate-500 focus:bg-white/10 focus:border-blue-500" placeholder="admin@nid.com" required>
            </div>
        </div>
        
        <div>
            <label class="form-label text-slate-300 small fw-bold uppercase tracking-wider">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white/5 border-white/10 text-slate-500">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" class="form-control bg-white/5 border-white/10 text-white placeholder-slate-500 focus:bg-white/10 focus:border-blue-500" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100 py-3 rounded-xl fw-bold bg-blue-600 border-0 hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 mt-4">
            Sign In to Dashboard
        </button>
    </form>

    <div class="text-center mt-8">
        <a href="../index.php" class="text-slate-400 text-decoration-none hover:text-white transition-colors small">
            <i class="fas fa-arrow-left me-1"></i> Back to Main Website
        </a>
    </div>
</div>

</body>
</html>
