<?php
    require_once "../config/auth.php";
    checkAuth();
    include_once '../config/database.php';

    $admin_id = $_SESSION['user_id'];

    // Fetch complaint counts for each status
    $counts = [
        'pending' => 0,
        'in_progress' => 0,
        'resolved' => 0,
        'closed' => 0
    ];
    
    $countSql = "SELECT status_id, COUNT(*) as count FROM complaints GROUP BY status_id";
    $countResult = mysqli_query($conn, $countSql);
    
    while ($row = mysqli_fetch_assoc($countResult)) {
        switch ($row['status_id']) {
            case 1:
                $counts['pending'] = $row['count'];
                break;
            case 2:
                $counts['in_progress'] = $row['count'];
                break;
            case 3:
                $counts['resolved'] = $row['count'];
                break;
            case 4:
                $counts['closed'] = $row['count'];
                break;
        }
    }
    
    // Total complaints
    $totalComplaints = array_sum($counts);
    
    
    include '../includes/header.php';
?>

<div class="d-flex">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-fill">
            <!-- Header -->
            <header class="d-flex align-items-center p-3 bg-white border-bottom">
                <button class="btn btn-outline-secondary d-md-none me-3" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="h4 mb-0">Admin Dashboard</h1>
            </header>

            <div class="p-4">
                <h2 class="mb-4 text-success"><i class="bi bi-speedometer2 me-2"></i>Dashboard Overview</h2>

                <!-- 4 Cards - Complaint Statistics (Bigger) -->
                <div class="row mb-4 g-3">
                    <!-- Total Complaints -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #6c757d;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 text-uppercase small fw-semibold">Total Complaints</p>
                                        <h1 class="mb-0 fw-bold text-dark"><?php echo $totalComplaints; ?></h1>
                                    </div>
                                    <div class="bg-danger p-4 rounded-circle">
                                        <i class="bi bi-card-text fs-2 text-light"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">All time</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #ffc107;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 text-uppercase small fw-semibold">Pending</p>
                                        <h1 class="mb-0 fw-bold text-warning"><?php echo $counts['pending']; ?></h1>
                                    </div>
                                    <div class="bg-warning p-4 rounded-circle">
                                        <i class="bi bi-clock fs-2 text-light"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">Awaiting action</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #0dcaf0;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 text-uppercase small fw-semibold">In Progress</p>
                                        <h1 class="mb-0 fw-bold text-info"><?php echo $counts['in_progress']; ?></h1>
                                    </div>
                                    <div class="bg-info p-4 rounded-circle" >
                                        <i class="bi bi-arrow-repeat fs-2 text-light"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">Being processed</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resolved -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #198754;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 text-uppercase small fw-semibold">Resolved</p>
                                        <h1 class="mb-0 fw-bold text-success"><?php echo $counts['resolved']; ?></h1>
                                    </div>
                                    <div class="bg-success p-4 rounded-circle">
                                        <i class="bi bi-check-circle fs-2 text-light"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">Successfully resolved</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
</div>

<?php
    include '../includes/footer.php';
?>

