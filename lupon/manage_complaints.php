<?php
    require_once "../config/auth.php";
    checkAuth();
    include_once '../config/database.php';

    $agent_id = $_SESSION['user_id'];

    // Fetch Complaints assigned to the agent
    $sql = "SELECT c.complaint_id, c.complaint_type, c.description, c.created_at, c.status_id, s.status_name,
                   u.username as complainant_name, u.email as complainant_email,
            (SELECT file_path FROM complaint_attachments WHERE complaint_id = c.complaint_id LIMIT 1) as attachment_path
            FROM complaints c
            LEFT JOIN complaint_status s ON c.status_id = s.status_id
            LEFT JOIN users u ON c.user_id = u.user_id
            WHERE c.assigned_agent_id = ?
            ORDER BY c.created_at DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $agent_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    include '../includes/header.php';
?>

    <div class="d-flex">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-fill">
        <!-- Header with Toggle Button -->
            <header class="d-flex align-items-center p-3 bg-white border-bottom">
                <button class="btn btn-outline-secondary d-md-none sidebar-toggle-btn me-3" id="sidebarToggle" aria-label="Toggle sidebar" aria-expanded="false">
                    <span class="navbar-toggler-icon">☰</span>
                </button>
                <h1 class="h4 mb-0">Lupon Member Dashboard</h1>
            </header>

            <div class="p-4">

                <h2 class="mb-4 text-success"><i class="fas fa-headset"></i> Assigned Complaints</h2>

        <!-- Complaints Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-card-list me-2"></i>These complaints require your attention and action.</h5>
            </div>
            <div class="card-body p-0">
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Complainant</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Attachment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Badge Color
                                    $badgeClass = 'bg-secondary';
                                    if ($row['status_name'] == 'Pending') $badgeClass = 'bg-warning text-dark';
                                    if ($row['status_name'] == 'In Progress') $badgeClass = 'bg-info text-white';
                                    if ($row['status_name'] == 'Resolved') $badgeClass = 'bg-success';
                                    if ($row['status_name'] == 'Closed') $badgeClass = 'bg-dark';

                                    // Attachment Logic
                                    $attPath = $row['attachment_path'];
                                    $fullPath = ""; 
                                    $isImage = false;

                                    if ($attPath) {
                                        $fullPath = "../folder/" . $attPath;
                                        $ext = strtolower(pathinfo($attPath, PATHINFO_EXTENSION));
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $isImage = true;
                                        }
                                    }
                            ?>
                                    <tr>
                                        <td>#<?php echo htmlspecialchars($row['complaint_id']); ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['complainant_name']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($row['complainant_email']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['complaint_type']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                        <td><span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['status_name']); ?></span></td>
                                        <td>
                                            <button class="btn btn-sm fw-bold btn-outline-secondary" data-bs-toggle="popover" 
                                                data-bs-title="Complaint Details" 
                                                data-bs-content="<?php echo htmlspecialchars($row['description']); ?>">
                                                View
                                            </button>
                                        </td>
                                        <td>
                                            <?php if($attPath): ?>
                                                <button type="button" class="btn btn-primary btn-sm fw-bold" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#attachmentModal"
                                                    datafilepath="<?php echo $fullPath; ?>"
                                                    data-isimage="<?php echo $isImage ? 'true' : 'false'; ?>"
                                                    data-filename="<?php echo htmlspecialchars($attPath); ?>">
                                                    <i class="fas fa-paperclip"></i> View
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- Link to update status page -->
                                            <a href="update_status.php?id=<?php echo $row['complaint_id']; ?>" class="btn btn-success btn-sm fw-bold">
                                                <i class="fas fa-edit"></i> Update
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No assigned complaints found.</td></tr>";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
                </div>
                    
                    
            </div>
    </main>
</div>

<?php
    include '../includes/footer.php';
?>