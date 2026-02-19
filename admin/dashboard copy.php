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
            <div class="p-4">
                <p>Manage your complaints efficiently.</p>
                
                <!-- Example Complaint Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Product Issue</td>
                                <td>Open</td>
                                <td><button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#complaintModal" data-content="Details for complaint 1">View</button></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Service Delay</td>
                                <td>Resolved</td>
                                <td><button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#complaintModal" data-content="Details for complaint 2">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>


<?php
    include '../includes/footer.php';
?>