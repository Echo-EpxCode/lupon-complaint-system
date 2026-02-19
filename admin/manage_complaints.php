<?php
    require_once "../config/auth.php";
    checkAuth();
    include_once '../config/database.php';

    $admin_id = $_SESSION['role_id'];

    // Handle Assign Agent Form Submission
    if (isset($_POST['assign_agent'])) {
        $complaint_id = $_POST['complaint_id'];
        $agent_id = $_POST['agent_id'];
        
        // Update complaint with assigned agent and set status to In Progress
        $updateSql = "UPDATE complaints SET assigned_agent_id = ?, status_id = 2 WHERE complaint_id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "ii", $agent_id, $complaint_id);
        
        if (mysqli_stmt_execute($updateStmt)) {
            echo "<script>alert('Complaint assigned successfully!');</script>";
        } else {
            echo "<script>alert('Error assigning complaint.');</script>";
        }
    }
    
    // Fetch All Complaints with details
    $sql = "SELECT c.complaint_id, c.complaint_type, c.description, c.created_at, c.assigned_agent_id, c.status_id,
                   s.status_name, u.username as complainant_name, u.email as complainant_email,
                   a.username as agent_name,
            (SELECT file_path FROM complaint_attachments WHERE complaint_id = c.complaint_id LIMIT 1) as attachment_path
            FROM complaints c
            LEFT JOIN complaint_status s ON c.status_id = s.status_id
            LEFT JOIN users u ON c.user_id = u.user_id
            LEFT JOIN users a ON c.assigned_agent_id = a.user_id
            ORDER BY c.created_at DESC";
    
    $result = mysqli_query($conn, $sql);
    
    // Fetch all agents for the dropdown
    $agentSql = "SELECT user_id, username FROM users WHERE role_id = 2";
    $agentResult = mysqli_query($conn, $agentSql);
    
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
        <h1 class="h4 mb-0">Admin Dashboard</h1>
    </header>

    <div class="p-4">
        <h2 class="mb-4 text-danger"><i class="fas fa-shield-alt"></i> All Complaints</h2>
        
        <!-- Complaints Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-card-list me-2"></i>Centralized management of all complaints across the system.</h5>
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
                                        <th>Assigned To</th>
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
                                            $badgeIcon = '';
                                            if ($row['status_name'] == 'Pending') { 
                                                $badgeClass = 'bg-warning text-dark'; 
                                                $badgeIcon = '<i class="bi bi-clock me-1"></i>';
                                            }
                                            if ($row['status_name'] == 'In Progress') { 
                                                $badgeClass = 'bg-info text-white'; 
                                                $badgeIcon = '<i class="bi bi-arrow-repeat me-1"></i>';
                                            }
                                            if ($row['status_name'] == 'Resolved') { 
                                                $badgeClass = 'bg-success'; 
                                                $badgeIcon = '<i class="bi bi-check-circle me-1"></i>';
                                            }
                                            if ($row['status_name'] == 'Closed') { 
                                                $badgeClass = 'bg-dark'; 
                                                $badgeIcon = '<i class="bi bi-x-circle me-1"></i>';
                                            }

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
                                                <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $badgeIcon . htmlspecialchars($row['status_name']); ?></span></td>
                                                <td>
                                                    <?php if($row['agent_name']): ?>
                                                        <span class="text-success"><?php echo htmlspecialchars($row['agent_name']); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">Unassigned</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm fw-bold btn-outline-secondary" data-bs-toggle="popover" 
                                                        data-bs-title="Complaint Details" 
                                                        data-bs-content="<?php echo htmlspecialchars($row['description']); ?>">
                                                        <i class="bi bi-eye"></i> View
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
                                                        </ bi-paperclip"></button>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm fw-bold" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#assignAgentModal"
                                                        data-complaint-id="<?php echo $row['complaint_id']; ?>">
                                                        <i class="bi bi-person-plus"></i> Assign
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='9' class='text-center'>No complaints found.</td></tr>";
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   

        </div>   
    </div>
</main>
</div>

<!-- ========================================== -->
<!-- MODAL: Assign Agent (For Admin) -->
<!-- ========================================== -->
<div class="modal fade" id="assignAgentModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-user-plus"></i> Assign Complaint to Agent</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="">
            <div class="modal-body">
                <input type="hidden" name="complaint_id" id="assignComplaintId">
                
                <div class="mb-3">
                    <label for="agentSelect" class="form-label">Select Agent</label>
                    <select class="form-select" name="agent_id" id="agentSelect" required>
                        <option value="">-- Select Agent --</option>
                        <?php
                        // Reset agent result pointer for the dropdown
                        mysqli_data_seek($agentResult, 0);
                        while ($agent = mysqli_fetch_assoc($agentResult)) {
                            echo "<option value='" . $agent['user_id'] . "'>" . htmlspecialchars($agent['username']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="assign_agent" class="btn btn-primary">Assign</button>
            </div>
        </form>
    </div>
</div>
</div>

<?php
    include '../includes/footer.php';
?>

