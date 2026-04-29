<?php 
session_start();
require_once 'config/db.php';

if (isset($_POST['register'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $mobile_no = trim($_POST['mobile_no']);
    $father_name = trim($_POST['father_name']);
    $mother_name = trim($_POST['mother_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $address = trim($_POST['address']);

    // Image Handling
    $img = "";
    if (!empty($_FILES['img_file']['name'])) {
        $target_dir = "uploads/profile/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $file_extension = pathinfo($_FILES["img_file"]["name"], PATHINFO_EXTENSION);
        $file_name = time() . "_profile." . $file_extension;
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['img_file']['tmp_name'], $target_file)) {
            $img = "uploads/profile/" . $file_name;
        }
    } elseif (!empty($_POST['img_url'])) {
        $img = trim($_POST['img_url']);
    }

    // Basic Validation
    if (empty($first_name) || empty($last_name) || empty($mobile_no) || empty($date_of_birth)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: registration.php");
        exit();
    }

    try {
        // Generate Unique NID Number (12 digits)
        do {
            $nid_number = mt_rand(100000000000, 999999999999);
            $stmt = $pdo->prepare("SELECT nid_number FROM users WHERE nid_number = ?");
            $stmt->execute([$nid_number]);
            $exists = $stmt->fetch();
        } while ($exists);

        // Insert new user
        $sql = "INSERT INTO users (first_name, last_name, nid_number, mobile_no, father_name, mother_name, date_of_birth, address, img) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$first_name, $last_name, $nid_number, $mobile_no, $father_name, $mother_name, $date_of_birth, $address, $img]);

        $_SESSION['success'] = "Registration Successful! Your generated NID is: <strong class='fs-4'>" . $nid_number . "</strong><br>
        <div class='mt-3'>
            <a href='find-nid.php?nid=" . $nid_number . "' class='btn btn-success btn-sm px-4 py-2 rounded-3 fw-bold shadow-sm'>
                <i class='fas fa-eye me-2'></i> View Your NID Card Now
            </a>
        </div>";
        header("Location: registration.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: registration.php");
        exit();
    }
}

include 'includes/header.php'; 
?>

<div class="bg-gradient-to-r from-emerald-800 to-emerald-600 py-20 text-white text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">New NID Registration</h1>
        <p class="lead opacity-90 max-w-2xl mx-auto animate__animated animate__fadeInUp">Official portal for National Identity Card registration. Please ensure all information matches your birth certificate.</p>
    </div>
</div>

<div class="container py-12" style="margin-top: -50px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Success/Error Messages -->
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-5 border-0 shadow-lg p-4 animate__animated animate__bounceIn" role="alert" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-left: 8px solid #10b981 !important;">
                    <div class="d-flex align-items-center">
                        <div class="w-12 h-12 bg-emerald-500 rounded-circle d-flex align-items-center justify-content-center text-white me-4 shadow-sm">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-emerald-900 mb-1">Registration Successful!</h5>
                            <p class="text-emerald-800 mb-0"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-5 border-0 shadow-lg p-4 animate__animated animate__shakeX" role="alert" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-left: 8px solid #ef4444 !important;">
                    <div class="d-flex align-items-center">
                        <div class="w-12 h-12 bg-red-500 rounded-circle d-flex align-items-center justify-content-center text-white me-4 shadow-sm">
                            <i class="fas fa-exclamation-triangle fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-red-900 mb-1">Error Occurred</h5>
                            <p class="text-red-800 mb-0"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-4 shadow-2xl p-4 p-md-5 border-0 overflow-hidden position-relative">
                <div class="position-absolute top-0 end-0 p-5 opacity-5 pointer-events-none">
                    <i class="fas fa-id-card fa-10x"></i>
                </div>
                
                <div class="d-flex align-items-center gap-4 mb-5">
                    <div class="w-16 h-16 bg-emerald-100 rounded-2xl d-flex align-items-center justify-content-center text-emerald-600 fs-2 shadow-sm">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold text-slate-900 mb-1">Citizen Registration</h2>
                        <p class="text-slate-500 mb-0">Fill in the official details to generate your NID</p>
                    </div>
                </div>
                
                <form action="registration.php" method="POST" enctype="multipart/form-data" class="row g-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="first_name" class="form-control border-slate-200 rounded-3 shadow-none focus:border-emerald-500" id="firstName" placeholder="John" required>
                            <label for="firstName" class="text-slate-500">First Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="last_name" class="form-control border-slate-200 rounded-3 shadow-none focus:border-emerald-500" id="lastName" placeholder="Doe" required>
                            <label for="lastName" class="text-slate-500">Last Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="mobile_no" class="form-control border-slate-200 rounded-3 shadow-none focus:border-emerald-500" id="mobileNo" placeholder="01XXX-XXXXXX" required>
                            <label for="mobileNo" class="text-slate-500">Mobile Number</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="date_of_birth" class="form-control border-slate-200 rounded-3 shadow-none focus:border-emerald-500" id="dob" required>
                            <label for="dob" class="text-slate-500">Date of Birth</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="father_name" class="form-control border-slate-200 rounded-3 shadow-none focus:border-emerald-500" id="fatherName" placeholder="Father's Name" required>
                            <label for="fatherName" class="text-slate-500">Father's Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="mother_name" class="form-control border-slate-200 rounded-3 shadow-none focus:border-emerald-500" id="motherName" placeholder="Mother's Name" required>
                            <label for="motherName" class="text-slate-500">Mother's Name</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="address" class="form-control border-slate-200 rounded-3 shadow-none focus:border-emerald-500 h-32" id="address" placeholder="Address" required></textarea>
                            <label for="address" class="text-slate-500">Full Permanent Address</label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="bg-slate-50 rounded-4 p-4 border border-slate-200">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-white rounded-circle d-flex align-items-center justify-content-center text-emerald-600 shadow-sm">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <h5 class="fw-bold text-slate-800 mb-0">Profile Picture</h5>
                            </div>
                            
                            <div class="row g-4 align-items-center">
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider mb-2">Upload Photo</label>
                                    <div class="input-group">
                                        <input type="file" name="img_file" class="form-control border-slate-200 rounded-3 bg-white" accept="image/*">
                                    </div>
                                    <p class="x-small text-slate-400 mt-2 mb-0">Accepted: JPG, PNG. Max size 2MB.</p>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-white text-slate-400 border border-slate-200 rounded-pill px-3 py-2">OR</span>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider mb-2">Image Link (URL)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 border-slate-200 text-slate-400 rounded-start-3"><i class="fas fa-link"></i></span>
                                        <input type="url" name="img_url" class="form-control border-start-0 border-slate-200 rounded-end-3 shadow-none" placeholder="https://example.com/photo.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" name="register" class="btn btn-primary-custom w-100 py-4 fs-5 shadow-lg d-flex align-items-center justify-content-center gap-3">
                            <i class="fas fa-id-card"></i>
                            Complete Registration & Generate NID
                        </button>
                    </div>
                </form>

                <div class="mt-5 text-center">
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
