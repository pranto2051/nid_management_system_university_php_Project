<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Search Logic
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = "";
if ($search) {
    $where = " WHERE nid_number LIKE :search OR first_name LIKE :search OR last_name LIKE :search ";
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_stmt = $pdo->prepare("SELECT COUNT(*) FROM users $where");
if ($search) {
    $total_stmt->execute(['search' => "%$search%"]);
} else {
    $total_stmt->execute();
}
$total_rows = $total_stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM users $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
if ($search) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$users = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="admin-card border-0 overflow-hidden mb-6">
    <div class="p-4 p-md-5 border-bottom bg-white">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
            <div>
                <h4 class="fw-bold text-slate-800 mb-1">Citizen Records</h4>
                <p class="text-slate-500 small mb-0">Total of <?php echo number_format($total_rows); ?> citizens registered</p>
            </div>
            
            <div class="d-flex flex-column flex-md-row gap-3">
                <form action="" method="GET" class="d-flex gap-2">
                    <div class="input-group" style="min-width: 300px;">
                        <span class="input-group-text bg-white border-end-0 text-slate-400 rounded-start-pill px-3">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 bg-white rounded-end-pill py-2" placeholder="Search by NID or Name..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <?php if($search): ?>
                        <a href="users.php" class="btn btn-light border rounded-circle" title="Clear Search"><i class="fas fa-times"></i></a>
                    <?php endif; ?>
                </form>
                <a href="add-user.php" class="btn btn-primary rounded-pill px-4 shadow-sm border-0 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                    <i class="fas fa-plus me-2"></i> Add Citizen
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="px-4 py-3">NID Number</th>
                    <th class="py-3">Citizen Info</th>
                    <th class="py-3 text-center">Mobile No</th>
                    <th class="py-3 text-center">Registration Date</th>
                    <th class="px-4 py-3 text-end">Management</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td class="px-4">
                        <span class="badge bg-blue-50 text-blue-600 font-mono fw-bold px-3 py-2 rounded-pill border border-blue-100"><?php echo $user['nid_number']; ?></span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl d-flex align-items-center justify-content-center text-slate-400 border shadow-sm overflow-hidden">
                                <?php if (!empty($user['img'])): ?>
                                    <img src="<?php echo (strpos($user['img'], 'http') === 0) ? $user['img'] : '../' . $user['img']; ?>" alt="Profile" class="w-100 h-100" style="object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-user-circle"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="fw-bold text-slate-800"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
                                <div class="small text-slate-500">DOB: <?php echo date('d M, Y', strtotime($user['date_of_birth'])); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="text-slate-600 small fw-bold"><i class="fas fa-mobile-alt me-1 text-slate-400"></i> <?php echo htmlspecialchars($user['mobile_no']); ?></span>
                    </td>
                    <td class="text-center">
                        <div class="text-slate-500 small d-flex align-items-center justify-content-center gap-2">
                            <i class="far fa-clock opacity-50"></i>
                            <?php echo date('d M, Y', strtotime($user['created_at'])); ?>
                        </div>
                    </td>
                    <td class="px-4 text-end">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle w-8 h-8 p-0" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v text-slate-400"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                <li><a class="dropdown-item py-2" href="../find-nid.php?nid=<?php echo $user['nid_number']; ?>" target="_blank"><i class="fas fa-eye me-2 text-blue-500"></i> View NID</a></li>
                                <li><a class="dropdown-item py-2" href="edit-user.php?id=<?php echo $user['user_id']; ?>"><i class="fas fa-edit me-2 text-emerald-500"></i> Edit Details</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="delete-user.php?id=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fas fa-trash-alt me-2"></i> Delete Record</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($users)): ?>
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-slate-400 mb-3"><i class="fas fa-user-slash fa-3x"></i></div>
                        <p class="text-slate-500">No citizens found in the registry.</p>
                        <a href="add-user.php" class="btn btn-primary-custom btn-sm">Add New Citizen</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($total_pages > 1): ?>
    <div class="p-4 bg-slate-50 border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <p class="small text-slate-500 mb-0 fw-medium">
            Showing <span class="text-slate-800 fw-bold"><?php echo $offset + 1; ?></span> to <span class="text-slate-800 fw-bold"><?php echo min($offset + $limit, $total_rows); ?></span> of <span class="text-slate-800 fw-bold"><?php echo number_format($total_rows); ?></span> entries
        </p>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0 gap-2">
                <!-- Previous Button -->
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link rounded-3 border px-3 py-2 bg-white shadow-sm d-flex align-items-center gap-2 text-slate-600" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">
                        <i class="fas fa-chevron-left small"></i>
                        <span class="d-none d-sm-inline fw-semibold">Previous</span>
                    </a>
                </li>

                <!-- Page Numbers -->
                <div class="d-flex gap-1 mx-1">
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link rounded-3 border px-3 py-2 <?php echo $page == $i ? 'bg-blue-600 text-white border-blue-600 shadow-md fw-bold' : 'bg-white shadow-sm text-slate-600 hover:bg-slate-50 border-slate-200'; ?>" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </div>

                <!-- Next Button -->
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link rounded-3 border px-3 py-2 bg-white shadow-sm d-flex align-items-center gap-2 text-slate-600" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">
                        <span class="d-none d-sm-inline fw-semibold">Next</span>
                        <i class="fas fa-chevron-right small"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>
</div>

<?php include 'includes/footer.php'; ?>
