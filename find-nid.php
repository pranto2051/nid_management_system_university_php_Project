<?php
session_start();
require_once 'config/db.php';

$user = null;
if (isset($_POST['search']) || isset($_GET['nid'])) {
    $nid_number = isset($_POST['nid_number']) ? trim($_POST['nid_number']) : trim($_GET['nid']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE nid_number = ?");
        $stmt->execute([$nid_number]);
        $user = $stmt->fetch();

        if (!$user) {
            $_SESSION['error'] = "No record found for NID: " . htmlspecialchars($nid_number);
            header("Location: find-nid-form.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: find-nid-form.php");
        exit();
    }
} else {
    header("Location: find-nid-form.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container py-12">
    <div class="text-center mb-12">
        <h1 class="display-5 fw-bold text-slate-900 mb-3">NID Card Found</h1>
        <p class="text-slate-500">Verification successful. Below is your digital National Identity Card.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- NID Card Design -->
            <div id="nidCard" class="nid-card-container mx-auto bg-white shadow-2xl rounded-4 overflow-hidden border border-slate-200" style="max-width: 600px; position: relative;">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-700 to-emerald-600 p-4 text-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/84/Government_Seal_of_Bangladesh.svg" alt="Gov Logo" width="50" class="filter brightness-0 invert">
                        <div>
                            <h5 class="fw-bold mb-0">Government of the People's Republic</h5>
                            <p class="small mb-0 opacity-80">National Identity Card</p>
                        </div>
                    </div>
                    <i class="fas fa-id-card fs-1 opacity-20"></i>
                </div>

                <!-- Card Body -->
                <div class="p-5 d-flex gap-5 align-items-start">
                    <!-- Photo Placeholder -->
                    <div class="flex-shrink-0 text-center">
                        <div class="w-32 h-40 bg-slate-100 rounded-lg border-2 border-slate-200 d-flex align-items-center justify-content-center overflow-hidden mb-3">
                            <?php if (!empty($user['img'])): ?>
                                <img src="<?php echo (strpos($user['img'], 'http') === 0) ? $user['img'] : $user['img']; ?>" alt="Profile" class="w-100 h-100" style="object-fit: cover;">
                            <?php else: ?>
                                <i class="fas fa-user text-slate-300 display-4"></i>
                            <?php endif; ?>
                        </div>
                        <div class="bg-slate-50 p-2 rounded border border-slate-100 mb-3">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=NID:<?php echo $user['nid_number']; ?>" alt="QR Code" width="80">
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="flex-grow-1 space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Full Name</label>
                            <h4 class="fw-bold text-slate-900 mb-0"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h4>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-6">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Father's Name</label>
                                <p class="fw-semibold text-slate-800 mb-0"><?php echo htmlspecialchars($user['father_name']); ?></p>
                            </div>
                            <div class="col-6">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mother's Name</label>
                                <p class="fw-semibold text-slate-800 mb-0"><?php echo htmlspecialchars($user['mother_name']); ?></p>
                            </div>
                            <div class="col-6">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Date of Birth</label>
                                <p class="fw-semibold text-slate-800 mb-0"><?php echo date('d M, Y', strtotime($user['date_of_birth'])); ?></p>
                            </div>
                            <div class="col-6">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">NID Number</label>
                                <p class="fw-bold text-blue-600 mb-0"><?php echo htmlspecialchars($user['nid_number']); ?></p>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Address</label>
                            <p class="fw-medium text-slate-700 mb-0 small"><?php echo nl2br(htmlspecialchars($user['address'])); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="bg-slate-50 p-3 border-t d-flex justify-content-between align-items-center">
                    <span class="text-xs font-bold text-slate-400">ID NO: <?php echo $user['user_id']; ?></span>
                    <span class="text-xs font-bold text-emerald-600"><i class="fas fa-check-circle me-1"></i> VERIFIED CITIZEN</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-12 d-flex justify-content-center gap-3">
                <button onclick="window.print()" class="btn btn-outline-dark px-4 py-2 rounded-lg fw-semibold">
                    <i class="fas fa-print me-2"></i>Print NID Card
                </button>
                <a href="find-nid-form.php" class="btn btn-primary-custom px-4 py-2">
                    <i class="fas fa-arrow-left me-2"></i>Back to Search
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #nidCard, #nidCard * {
        visibility: visible;
    }
    #nidCard {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none;
        border: 1px solid #ccc;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
