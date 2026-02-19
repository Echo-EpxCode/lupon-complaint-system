<?php require_once "../config/auth.php"; 
include_once '../config/database.php'; 
$agent_id = $_SESSION['user_id']; $complaint_id = $_GET['id'] ?? 0; 
// Handle form submission 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) { $new_status_id = $_POST['status_id'];
 // Update complaint status 
 $updateSql = "UPDATE complaints SET status_id = ?, updated_at = NOW() WHERE complaint_id = ? AND assigned_agent_id = ?";
$updateStmt = mysqli_prepare($conn, $updateSql); 
mysqli_stmt_bind_param($updateStmt, "iii", $new_status_id, $complaint_id, $agent_id);
 if (mysqli_stmt_execute($updateStmt)) 
 { 
    echo "<script> alert('Status updated successfully!'); window.location.href = 'dashboard.php'; </script>"; exit; 
 } else { echo "<script>alert('Error updating status.');</script>";
  }
   } 
   // Fetch complaint details 
   $sql = "SELECT c.*, s.status_name, u.username as complainant_name, u.email as complainant_email FROM complaints c LEFT JOIN complaint_status s ON c.status_id = s.status_id LEFT JOIN users u ON c.user_id = u.user_id WHERE c.complaint_id = ? AND c.assigned_agent_id = ?"; $stmt = mysqli_prepare($conn, $sql); mysqli_stmt_bind_param($stmt, "ii", $complaint_id, $agent_id); mysqli_stmt_execute($stmt); $result = mysqli_stmt_get_result($stmt); $complaint = mysqli_fetch_assoc($result); 
   // If complaint not found or not assigned to this agent 
   if (!$complaint) { echo "<script>window.location.href = 'dashboard.php';</script>"; exit; } include '../includes/header.php'; 

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
            <h1 class="h4 mb-0">Agent Dashboard</h1>
        </header>

        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 text-success"><i class="fas fa-edit"></i> Update Complaint Status</h2>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            
            <div class="row">
                <!-- Complaint Details Card -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-alt"></i> Complaint Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Complaint ID</th>
                                    <td>#<?php echo htmlspecialchars($complaint['complaint_id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td><?php echo htmlspecialchars($complaint['complaint_type']); ?></td>
                                </tr>
                                <tr>
                                    <th>Complainant</th>
                                    <td><?php echo htmlspecialchars($complaint['complainant_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo htmlspecialchars($complaint['complainant_email']); ?></td>
                                </tr>
                                <tr>
                                    <th>Date Submitted</th>
                                    <td><?php echo date('M d, Y h:i A', strtotime($complaint['created_at'])); ?></td>
                                </tr>
                                <tr>
                                    <th>Current Status</th>
                                    <td>
                                        <?php 
                                            $badgeClass = 'bg-secondary';
                                            if ($complaint['status_name'] == 'Pending') $badgeClass = 'bg-warning text-dark';
                                            if ($complaint['status_name'] == 'In Progress') $badgeClass = 'bg-info text-white';
                                            if ($complaint['status_name'] == 'Resolved') $badgeClass = 'bg-success';
                                            if ($complaint['status_name'] == 'Closed') $badgeClass = 'bg-dark';
                                        ?>
                                        <span class="badge <?php echo $badgeClass; ?>">
                                            <?php echo htmlspecialchars($complaint['status_name']); ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            
                            <div class="mt-3">
                                <strong>Description:</strong>
                                <div class="p-3 bg-light rounded mt-2">
                                    <?php echo nl2br(htmlspecialchars($complaint['description'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Status Form Card -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-sync-alt"></i> Update Status</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="status_id" class="form-label">Select New Status</label>
                                    <select class="form-select" name="status_id" id="status_id" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="1">Pending</option>
                                        <option value="2">In Progress</option>
                                        <option value="3">Resolved</option>
                                        <option value="4">Closed</option>
                                    </select>
                                    <div class="form-text">
                                        Changing status will be reflected immediately.
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" name="update_status" class="btn btn-success btn-lg">
                                        <i class="fas fa-check"></i> Update Status
                                    </button>
                                    <a href="dashboard.php" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php
    include '../includes/footer.php';
?>


