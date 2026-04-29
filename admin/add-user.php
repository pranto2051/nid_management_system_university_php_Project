<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";

if (isset($_POST['add_user'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $nid_number = trim($_POST['nid_number']);
    $mobile_no = trim($_POST['mobile_no']);
    $father_name = trim($_POST['father_name']);
    $mother_name = trim($_POST['mother_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $address = trim($_POST['address']);
    
    // Image Handling
    $img = "";
    if (!empty($_FILES['img_file']['name'])) {
        $target_dir = "../uploads/profile/";
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

    try {
        if (!empty($nid_number)) {
            $stmt = $pdo->prepare("SELECT nid_number FROM users WHERE nid_number = ?");
            $stmt->execute([$nid_number]);
            if ($stmt->fetch()) {
                $error = "NID Number already exists.";
            }
        } else {
            // Generate Unique NID if left empty
            do {
                $nid_number = mt_rand(100000000000, 999999999999);
                $stmt = $pdo->prepare("SELECT nid_number FROM users WHERE nid_number = ?");
                $stmt->execute([$nid_number]);
                $exists = $stmt->fetch();
            } while ($exists);
        }

        if (empty($error)) {
            $sql = "INSERT INTO users (first_name, last_name, nid_number, mobile_no, father_name, mother_name, date_of_birth, address, img) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$first_name, $last_name, $nid_number, $mobile_no, $father_name, $mother_name, $date_of_birth, $address, $img]);
            $success = "Citizen record added successfully! NID: " . $nid_number;
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="admin-card border-0 p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h4 class="fw-bold text-slate-800 mb-1">Add New Citizen</h4>
                    <p class="text-slate-500 small mb-0">Register a new citizen in the national database</p>
                </div>
                <a href="users.php" class="btn btn-light border rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success border-0 bg-emerald-50 text-emerald-700 shadow-sm rounded-xl mb-5 p-4 animate__animated animate__fadeIn">
                    <div class="d-flex align-items-center">
                        <div class="bg-emerald-500 text-white rounded-circle p-2 me-3">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="fw-bold"><?php echo $success; ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger border-0 bg-red-50 text-red-700 shadow-sm rounded-xl mb-5 p-4 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <div class="bg-red-500 text-white rounded-circle p-2 me-3">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="fw-bold"><?php echo $error; ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">First Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-user text-slate-400"></i></span>
                            <input type="text" name="first_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" placeholder="Enter first name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-user text-slate-400"></i></span>
                            <input type="text" name="last_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" placeholder="Enter last name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">NID Number (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-id-badge text-slate-400"></i></span>
                            <input type="number" name="nid_number" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" placeholder="Auto-generate if empty">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Mobile Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-phone text-slate-400"></i></span>
                            <input type="text" name="mobile_no" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" placeholder="01XXX-XXXXXX" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Father's Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-male text-slate-400"></i></span>
                            <input type="text" name="father_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" placeholder="Enter father's name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Mother's Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-female text-slate-400"></i></span>
                            <input type="text" name="mother_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" placeholder="Enter mother's name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Date of Birth</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-calendar-day text-slate-400"></i></span>
                            <input type="date" name="date_of_birth" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Full Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-map-marker-alt text-slate-400"></i></span>
                            <textarea name="address" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" rows="1" placeholder="Enter address" required></textarea>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="bg-slate-50 rounded-4 p-4 border border-slate-200 shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-white rounded-circle d-flex align-items-center justify-content-center text-blue-600 shadow-sm border">
                                    <i class="fas fa-image"></i>
                                </div>
                                <h6 class="fw-bold text-slate-800 mb-0">Profile Image</h6>
                            </div>
                            
                            <div class="row g-4 align-items-center">
                                <div class="col-md-5">
                                    <label class="form-label x-small fw-bold text-slate-500 text-uppercase mb-2">Upload Local File</label>
                                    <input type="file" name="img_file" class="form-control border-slate-200 rounded-3 bg-white" accept="image/*">
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-white text-slate-300 border border-slate-100 rounded-pill px-3 py-2">OR</span>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label x-small fw-bold text-slate-500 text-uppercase mb-2">Image URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 border-slate-200 text-slate-400 rounded-start-3"><i class="fas fa-link"></i></span>
                                        <input type="url" name="img_url" class="form-control border-start-0 border-slate-200 rounded-end-3 shadow-none" placeholder="https://example.com/photo.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" name="add_user" class="btn btn-primary btn-lg w-100 w-md-auto px-5 py-3 rounded-xl border-0 shadow-lg shadow-blue-100" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                            <i class="fas fa-save me-2"></i> Complete Registration
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
