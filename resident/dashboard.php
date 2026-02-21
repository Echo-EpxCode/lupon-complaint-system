<?php
    require_once "../config/auth.php";
    checkAuth();
    include_once '../config/database.php';

    $user_id = $_SESSION['user_id'];

    // Fetch Complaints submitted BY the user
    $sql = "SELECT 
                c.complaint_id, 
                c.complaint_type, 
                c.description, 
                c.created_at, 
                s.status_name, 
                c.meeting_link,
                (SELECT file_path 
                 FROM complaint_attachments 
                 WHERE complaint_id = c.complaint_id 
                 LIMIT 1) AS attachment_path
            FROM complaints c
            LEFT JOIN complaint_status s ON c.status_id = s.status_id
            WHERE c.user_id = ?
            ORDER BY c.created_at DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch Complaints filed AGAINST the user (where user is respondent)
    $sql2 = "SELECT 
                c.complaint_id, 
                c.complaint_type, 
                c.description, 
                c.created_at, 
                s.status_name,
                c.meeting_link,
                u.username AS complainant_name,
                u.email AS complainant_email,
                (SELECT file_path 
                 FROM complaint_attachments 
                 WHERE complaint_id = c.complaint_id 
                 LIMIT 1) AS attachment_path
            FROM complaints c
            LEFT JOIN complaint_status s ON c.status_id = s.status_id
            LEFT JOIN users u ON c.user_id = u.user_id
            WHERE c.respondent_id = ?
            ORDER BY c.created_at DESC";
    
    $stmt2 = mysqli_prepare($conn, $sql2);
    if (!$stmt2) {
        die("Prepare failed: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt2, "i", $user_id);
    mysqli_stmt_execute($stmt2);
    
    $result2 = mysqli_stmt_get_result($stmt2);
    
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
        <h1 class="h4 mb-0">Welcome to Your Dashboard</h1>
    </header>

    <div class="p-4">

<!-- ==================== MY COMPLAINTS SECTION ==================== -->
<h2 class="mb-4 text-success fw-bold"><i class="fas fa-user-circle"></i> My Complaints</h2>

<div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-card-list me-2"></i>Complaints you have submitted.</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Type</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Description</th>
                        <th scope="col">Meeting Link</th>
                        <th scope="col">Attachment</th>
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
                                <td><?php echo htmlspecialchars($row['complaint_type']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td><span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['status_name']); ?></span></td>
                                <td>
                                    <button class="btn btn-sm fw-bold btn-outline-success" data-bs-toggle="popover" data-bs-content="<?php echo htmlspecialchars($row['description']); ?>">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </td>
                                <td>
                                    <?php if(!empty($row['meeting_link'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['meeting_link']); ?>" target="_blank" class="btn btn-sm fw-bold btn-success">
                                            <i class="fas fa-video"></i> Join
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Not available</span>
                                    <?php endif; ?>
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
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No complaints found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>        
</div>

<!-- ==================== COMPLAINTS AGAINST ME SECTION ==================== -->
<h2 class="mb-4 text-danger fw-bold"><i class="fas fa-exclamation-triangle"></i> Complaints Against Me</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="bi bi-exclamation-octagon me-2"></i>Complaints filed against you by others.</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Filed By</th>
                        <th scope="col">Type</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Description</th>
                        <th scope="col">Meeting Link</th>
                        <th scope="col">Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            
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
                                    <span class="fw-bold text-primary">
                                        <?php echo htmlspecialchars($row['complainant_name']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['complaint_type']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td><span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['status_name']); ?></span></td>
                                <td>
                                    <button class="btn btn-sm fw-bold btn-outline-danger" data-bs-toggle="popover" data-bs-content="<?php echo htmlspecialchars($row['description']); ?>">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </td>
                                <td>
                                    <?php if(!empty($row['meeting_link'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['meeting_link']); ?>" target="_blank" class="btn btn-sm fw-bold btn-danger">
                                            <i class="fas fa-video"></i> Join
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Not available</span>
                                    <?php endif; ?>
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
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center text-muted py-4'>
                                <i class='fas fa-check-circle fa-2x mb-2'></i><br>
                                No complaints filed against you.
                              </td></tr>";
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>        
</div>
</div>
    </main>
</div>

<?php
    include '../includes/footer.php';
?>