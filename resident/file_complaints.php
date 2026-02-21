<?php
require_once "../config/auth.php";
checkAuth();
include_once '../config/database.php';

// Fetch users for the dropdown (exclude current user)
$usersQuery = "SELECT user_id, username, email FROM users WHERE user_id != ? AND status = 'Accepted' AND role_id > 2 ORDER BY username";

$stmtUsers = $conn->prepare($usersQuery); $stmtUsers->bind_param("i", $_SESSION['user_id']); $stmtUsers->execute(); $usersResult = $stmtUsers->get_result();

include '../includes/header.php';
?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-fill">
        <header class="d-flex align-items-center p-3 bg-white border-bottom">
            <button class="btn btn-outline-secondary d-md-none sidebar-toggle-btn me-3" id="sidebarToggle" aria-label="Toggle sidebar">
                <span class="navbar-toggler-icon">☰</span>
            </button>
            <h1 class="h4 mb-0">Welcome to Your Dashboard</h1>
        </header>

        <div class="col-md-8 mt-4 p-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Submit a Complaint</h5>
                </div>
                <div class="card-body">
                    <form action="complaint_process.php" method="POST" enctype="multipart/form-data">

                        <!-- Respondent Selection -->
                        <div class="mb-3">
                            <label for="respondent_id" class="form-label">
                                Complaint Against <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="respondent_id" name="respondent_id" required>
                                <option value="" selected disabled>Select person to complain about</option>
                                <?php while ($user = $usersResult->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($user['user_id']) ?>">
                                        <?= htmlspecialchars($user['username']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <small class="text-muted">If your complaint is about a specific person, select them here.</small>
                        </div>

                        <!-- Complaint Type -->
                        <div class="mb-3">
                            <label for="complaint_type" class="form-label">
                                Complaint Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="complaint_type" name="complaint_type" required>
                                <option value="" selected disabled>Select complaint type</option>
                                <option value="Public Safety/Security">Public Safety/Security</option>
                                <option value="Health & Sanitation">Health & Sanitation</option>
                                <option value="Infrastructure & Public Works">Infrastructure & Public Works</option>
                                <option value="Noise & Disturbances">Noise & Disturbances</option>
                                <option value="Environmental Concerns">Environmental Concerns</option>
                                <option value="Business / Vendor Issues">Business / Vendor Issues</option>
                                <option value="Verbal Harassment">Verbal Harassment</option>
                                <option value="Physical Harassment">Physical Harassment</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Description <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="8"
                                placeholder="Describe your complaint in detail..."
                                required
                            ></textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment (Image / PDF / DOC)</label>
                            <input
                                type="file"
                                class="form-control"
                                id="attachment"
                                name="attachment"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                            >
                            <small class="text-muted">Allowed formats: JPG, PNG, PDF, DOC, DOCX (Max size: 5MB)</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold" name="submit">
                                Submit Complaint
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
$stmtUsers->close();
include '../includes/footer.php';
?>