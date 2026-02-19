        <aside class="sidebar bg-dark text-white" id="sidebar">
            <div class="sidebar-header p-3 d-flex justify-content-between align-items-center">
                <h5>Complaint System</h5>
                <button class="btn btn-dark btn-close btn-close-white d-md-none" id="sidebarClose" aria-label="Close sidebar"></button>
            </div>
            
            <nav class="nav flex-column p-3" role="navigation" aria-label="Main navigation">
            <h3 class=""><?php echo $_SESSION['username']; ?></h3>

                <?php if ($_SESSION['role_id'] === '1'): ?>
                <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                <a class="nav-link text-white" href="manage_user.php">Manage Users</a>
                <a class="nav-link text-white" href="#complaints">Manage Complaints</a>

                <?php elseif ($_SESSION['role_id'] === '2'): ?>
                <a class="nav-link text-white" href="dashboard.php">Manage Complaints</a>
              

                <?php elseif ($_SESSION['role_id'] === '3'): ?>
                <a class="nav-link text-white" href="dashboard.php">My Complaints</a>
                <a class="nav-link text-white" href="file_complaints.php">File Complaints</a>
                <?php endif; ?>

                <a class="nav-link text-white" href="../logout.php">Logout</a>
            </nav>
        </aside>