<?php
    require_once "../config/auth.php";
    checkAuth();
    include '../includes/header.php';
?>

    <div class="d-flex">
        <!-- Sidebar -->
         <?php
            include '../includes/sidebar.php';
         ?>


        <!-- Main Content -->
        <main class="flex-fill">
            <!-- Header with Toggle Button (visible only on smaller screens) -->
            <header class="d-flex align-items-center p-3 bg-white border-bottom">
                <button class="btn btn-outline-secondary d-md-none sidebar-toggle-btn me-3" id="sidebarToggle" aria-label="Toggle sidebar" aria-expanded="false">
                    <span class="navbar-toggler-icon">☰</span> <!-- Fallback text if icon fails -->
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
                                rows="12"
                                placeholder="Describe your complaint in detail..."
                                required
                            ></textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="attachment" class="form-label">
                                Attachment (Image / PDF / DOC)
                            </label>
                            <input
                                type="file"
                                class="form-control"
                                id="attachment"
                                name="attachment"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                            >
                            <small class="text-muted">
                                Allowed formats: JPG, PNG, PDF, DOC, DOCX (Max size: 5MB)
                            </small>
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
    include '../includes/footer.php';
?>