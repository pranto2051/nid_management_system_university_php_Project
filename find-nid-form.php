<?php 
session_start();
include 'includes/header.php'; 
?>

<div class="bg-gradient-to-r from-blue-700 to-blue-500 py-16 text-white text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-2">Find Your NID</h1>
        <p class="lead opacity-90">Enter your unique NID number to retrieve your digital identity card.</p>
    </div>
</div>

<div class="container py-12">
    <!-- Success/Error Messages -->
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-5 border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="glass-card p-4 p-md-5">
                <div class="w-16 h-16 bg-blue-100 rounded-circle d-flex align-items-center justify-content-center text-blue-600 fs-3 mb-4 mx-auto">
                    <i class="fas fa-search"></i>
                </div>
                <h2 class="fw-bold text-slate-900 mb-3 text-center">Search NID Database</h2>
                <p class="text-slate-500 mb-4 text-center">Ensure you have your 10 or 17 digit NID number ready.</p>
                
                <form action="find-nid.php" method="POST" class="space-y-4">
                    <div>
                        <label class="form-label fw-semibold text-slate-700">NID Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-start-3 text-slate-400">
                                <i class="fas fa-id-card"></i>
                            </span>
                            <input type="number" name="nid_number" class="form-control border-start-0 rounded-end-3 py-3 px-3" placeholder="e.g. 199512345678" required>
                        </div>
                    </div>
                    <button type="submit" name="search" class="btn btn-primary-custom w-100 py-3 shadow-sm mt-4">
                        Search NID Information
                    </button>
                </form>

                <div class="mt-5 p-4 bg-blue-50 rounded-4 border border-blue-100">
                    <h6 class="fw-bold text-blue-700 mb-2"><i class="fas fa-info-circle me-2"></i>Need Help?</h6>
                    <p class="small text-blue-600 mb-0">If you haven't registered yet, please visit the <a href="registration.php" class="fw-bold text-decoration-underline">Registration Page</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
