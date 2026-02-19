        <aside class="sidebar bg-dark text-white" id="sidebar">
            <div class="sidebar-header p-3 d-flex justify-content-between align-items-center">
                <h5>Complaint System</h5>
                <button class="btn btn-dark btn-close btn-close-white d-md-none" id="sidebarClose" aria-label="Close sidebar"></button>
            </div>
            
            <div class="px-3 pb-3">
                <div class="bg-success bg-opacity-2 p-2 rounded d-flex align-items-center">
                    <center><i class="bi bi-person-circle fs-4 me-2"></i></center>
                    <div>
                        <small class="text-white-50 d-block">Logged in as</small>
                        <span class="fw-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                </div>
            </div>
            <nav class="nav flex-column px-3 pb-3"  role="navigation" aria-label="Main navigation">
                <!--  -->

                <?php if ($_SESSION['role_id'] === '1'): ?>
                <a class="nav-link text-white py-2 px-3 rounded mb-1" href="dashboard.php">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a class="nav-link text-white py-2 px-3 rounded mb-1" href="manage_user.php">
                    <i class="bi bi-people me-2"></i> Manage Users
                </a>
                <a class="nav-link text-white py-2 px-3 rounded mb-1" href="manage_complaints.php">
                    <i class="bi bi-card-text me-2"></i> Manage Complaints
                </a>

                <?php elseif ($_SESSION['role_id'] === '2'): ?>
                <a class="nav-link text-white py-2 px-3 rounded mb-1" href="dashboard.php">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a class="nav-link text-white py-2 px-3 rounded mb-1" href="manage_complaints.php">
                    <i class="bi bi-card-text me-2"></i> Manage Complaints
                </a>
              

                <?php elseif ($_SESSION['role_id'] === '3'): ?>
                <a class="nav-link text-white py-2 px-3 rounded mb-1" href="dashboard.php">
                <i class="bi bi-clock-history me-2"></i> My Complaints
                </a>
                <a class="nav-link text-white py-2 px-3 rounded mb-1" href="file_complaints.php">
                    <i class="bi bi-plus-circle me-2"></i> File Complaints
                </a>
                <?php endif; ?>

                <hr class="border-light">

                <a class="nav-link text-white py-2 px-3 rounded" href="../logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </nav>
        </aside>