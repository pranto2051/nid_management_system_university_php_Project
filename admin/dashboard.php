<?php
session_start();
require_once '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch stats
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$recent_registrations = $pdo->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll();

include 'includes/header.php';
?>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="admin-card p-4 h-100 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-slate-500 small fw-bold mb-1 text-uppercase tracking-wider">Total Citizens</p>
                    <h2 class="fw-bold mb-0 text-slate-900"><?php echo number_format($total_users); ?></h2>
                </div>
                <div class="w-14 h-14 bg-blue-50 rounded-2xl d-flex align-items-center justify-content-center text-blue-600 shadow-sm">
                    <i class="fas fa-users fs-3"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-emerald-500 small fw-bold"><i class="fas fa-arrow-up me-1"></i>System Active</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4 h-100 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-slate-500 small fw-bold mb-1 text-uppercase tracking-wider">New Today</p>
                    <h2 class="fw-bold mb-0 text-slate-900">
                        <?php 
                        $today = date('Y-m-d');
                        echo number_format($pdo->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = '$today'")->fetchColumn()); 
                        ?>
                    </h2>
                </div>
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl d-flex align-items-center justify-content-center text-emerald-600 shadow-sm">
                    <i class="fas fa-user-plus fs-3"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-slate-400 small">Registered in last 24h</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4 h-100 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-slate-500 small fw-bold mb-1 text-uppercase tracking-wider">Database Status</p>
                    <h2 class="fw-bold mb-0 text-emerald-500">Healthy</h2>
                </div>
                <div class="w-14 h-14 bg-purple-50 rounded-2xl d-flex align-items-center justify-content-center text-purple-600 shadow-sm">
                    <i class="fas fa-database fs-3"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-slate-400 small">Last backup: Just now</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card border-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-slate-800 mb-0">Recent Registrations</h5>
                    <p class="small text-slate-500 mb-0">Latest 5 citizens added to the registry</p>
                </div>
                <a href="users.php" class="btn btn-sm btn-light text-blue-600 fw-bold px-3 py-2 border">View All Activity</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">Citizen Name</th>
                            <th class="py-3">NID Number</th>
                            <th class="py-3">Registration Date</th>
                            <th class="px-4 py-3 text-end">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recent_registrations as $user): ?>
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-50 rounded-xl d-flex align-items-center justify-content-center text-slate-400 border overflow-hidden">
                                        <?php if(!empty($user['img'])): ?>
                                            <?php 
                                                $img_path = $user['img'];
                                                if (!filter_var($img_path, FILTER_VALIDATE_URL)) {
                                                    $img_path = '../' . $img_path;
                                                }
                                            ?>
                                            <img src="<?php echo $img_path; ?>" alt="Profile" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <i class="fas fa-user"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
                                        <div class="small text-slate-500">Active Citizen</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-slate-600 font-mono small fw-bold"><?php echo $user['nid_number']; ?></td>
                            <td class="text-slate-500 small">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                                </div>
                            </td>
                            <td class="px-4 text-end">
                                <a href="edit-user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-light border text-blue-600 hover-shadow">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($recent_registrations)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/slate/shaking-hands.svg" width="120" class="mb-3 opacity-20">
                                <p class="text-slate-400">No recent registrations found.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="admin-card border-0 p-4 h-100 bg-white">
            <h5 class="fw-bold text-slate-800 mb-4">Quick Actions</h5>
            <div class="d-grid gap-3">
                <a href="add-user.php" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center py-3 shadow-lg shadow-blue-100 rounded-xl border-0" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                    <i class="fas fa-plus-circle me-2"></i> Add New Citizen
                </a>
                <a href="../find-nid-form.php" target="_blank" class="btn btn-light btn-lg d-flex align-items-center justify-content-center py-3 rounded-xl border">
                    <i class="fas fa-search me-2 text-slate-400"></i> Search Registry
                </a>
                <div class="p-4 rounded-xl mt-4 border border-dashed border-slate-200" style="background-color: #fafafa;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        <h6 class="fw-bold text-slate-800 mb-0">Admin Notice</h6>
                    </div>
                    <p class="small text-slate-500 mb-0 leading-relaxed">Please verify all physical documents before approving online NID applications in the system. Security checks are mandatory.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
