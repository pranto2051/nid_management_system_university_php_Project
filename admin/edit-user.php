<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";
$user = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    
    if (!$user) {
        header("Location: users.php");
        exit();
    }
} else {
    header("Location: users.php");
    exit();
}

if (isset($_POST['update_user'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $nid_number = trim($_POST['nid_number']);
    $mobile_no = trim($_POST['mobile_no']);
    $father_name = trim($_POST['father_name']);
    $mother_name = trim($_POST['mother_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $address = trim($_POST['address']);

    // Image Handling
    $img = $user['img']; // Default to current
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

    // Official Form Handling - REMOVED
    $registration_form = "";

    try {
        // Check if NID exists for another user
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE nid_number = ? AND user_id != ?");
        $stmt->execute([$nid_number, $id]);
        if ($stmt->fetch()) {
            $error = "NID Number already exists for another user.";
        } else {
            $sql = "UPDATE users SET first_name=?, last_name=?, nid_number=?, mobile_no=?, father_name=?, mother_name=?, date_of_birth=?, address=?, img=? WHERE user_id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$first_name, $last_name, $nid_number, $mobile_no, $father_name, $mother_name, $date_of_birth, $address, $img, $id]);
            $success = "Citizen record updated successfully!";
            
            // Refresh user data
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 border-0">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h4 class="fw-bold text-slate-800 mb-1">Edit Citizen Profile</h4>
                    <p class="text-slate-500 small mb-0">Updating records for NID: <span class="text-blue-600 fw-bold"><?php echo $user['nid_number']; ?></span></p>
                </div>
                <a href="users.php" class="btn btn-light border rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Back to Registry
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
                            <input type="text" name="first_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-user text-slate-400"></i></span>
                            <input type="text" name="last_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">NID Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-id-badge text-slate-400"></i></span>
                            <input type="number" name="nid_number" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" value="<?php echo htmlspecialchars($user['nid_number']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Mobile Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-phone text-slate-400"></i></span>
                            <input type="text" name="mobile_no" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" value="<?php echo htmlspecialchars($user['mobile_no']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Father's Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-male text-slate-400"></i></span>
                            <input type="text" name="father_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" value="<?php echo htmlspecialchars($user['father_name']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Mother's Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-female text-slate-400"></i></span>
                            <input type="text" name="mother_name" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" value="<?php echo htmlspecialchars($user['mother_name']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Date of Birth</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-calendar-day text-slate-400"></i></span>
                            <input type="date" name="date_of_birth" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" value="<?php echo $user['date_of_birth']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-slate-600 text-uppercase tracking-wider">Permanent Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-slate-200 rounded-start-xl"><i class="fas fa-map-marker-alt text-slate-400"></i></span>
                            <textarea name="address" class="form-control border-start-0 border-slate-200 rounded-end-xl py-2 px-3" rows="1" required><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="bg-slate-50 rounded-4 p-4 border border-slate-200 shadow-sm">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center mb-4 mb-md-0">
                                    <div class="position-relative d-inline-block">
                                        <img src="<?php echo (!empty($user['img'])) ? ((strpos($user['img'], 'http') === 0) ? $user['img'] : '../' . $user['img']) : '../assets/img/default-user.png'; ?>" 
                                             class="rounded-circle border-4 border-white shadow-md object-fit-cover" 
                                             style="width: 120px; height: 120px;" alt="Profile">
                                        <div class="position-absolute bottom-0 end-0 bg-blue-600 text-white rounded-circle p-2 border-4 border-white">
                                            <i class="fas fa-camera small"></i>
                                        </div>
                                    </div>
                                    <p class="small fw-bold text-slate-500 mt-2 mb-0">Current Image</p>
                                </div>
                                <div class="col-md-9 border-start-md border-slate-100">
                                    <div class="ps-md-4">
                                        <h6 class="fw-bold text-slate-800 mb-3">Update Profile Picture</h6>
                                        <div class="row g-4 align-items-center">
                                            <div class="col-md-5">
                                                <label class="form-label x-small fw-bold text-slate-500 text-uppercase mb-1">Local Upload</label>
                                                <input type="file" name="img_file" class="form-control form-control-sm border-slate-200 rounded-lg bg-white" accept="image/*">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                <span class="text-slate-300 small">OR</span>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label x-small fw-bold text-slate-500 text-uppercase mb-1">External Link</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-white border-end-0 text-slate-400"><i class="fas fa-link"></i></span>
                                                    <input type="url" name="img_url" class="form-control border-start-0 border-slate-200" placeholder="Paste URL here..." value="<?php echo (strpos($user['img'], 'http') === 0) ? $user['img'] : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-5 text-end">
                        <button type="submit" name="update_user" class="btn btn-primary btn-lg px-5 py-3 rounded-xl border-0 shadow-lg" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                            <i class="fas fa-save me-2"></i> Update Citizen Record
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
