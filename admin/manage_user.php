<?php
    require_once "../config/auth.php";
    include_once '../config/database.php';

    $admin_id = $_SESSION['user_id'];

    // Handle Accept User Form Submission
    if (isset($_POST['accept_user'])) {
        $user_id = $_POST['user_id'];
        
        // Update user status to Accepted
        $updateSql = "UPDATE users SET status = 'Accepted' WHERE user_id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "i", $user_id);
        
        if (mysqli_stmt_execute($updateStmt)) {
            echo "<script>alert('User accepted successfully!');</script>";
        } else {
            echo "<script>alert('Error accepting user.');</script>";
        }
    }

    // Handle Reject (Delete) User Form Submission
    if (isset($_POST['reject_user'])) {
        $user_id = $_POST['user_id'];
        
        // Delete the pending user
        $deleteSql = "DELETE FROM users WHERE user_id = ? AND status = 'Pending'";
        $deleteStmt = mysqli_prepare($conn, $deleteSql);
        mysqli_stmt_bind_param($deleteStmt, "i", $user_id);
        
        if (mysqli_stmt_execute($deleteStmt)) {
            echo "<script>alert('User rejected and removed.');</script>";
        } else {
            echo "<script>alert('Error rejecting user.');</script>";
        }
    }

    // Fetch Pending Agents (role_id = 2)
    $pendingAgentsSql = "SELECT user_id, username, email, created_at 
                         FROM users 
                         WHERE role_id = 2 AND status = 'Pending' 
                         ORDER BY created_at DESC";
    $pendingAgentsResult = mysqli_query($conn, $pendingAgentsSql);

    // Fetch Pending Users (role_id = 3)
    $pendingUsersSql = "SELECT user_id, username, email, created_at 
                        FROM users 
                        WHERE role_id = 3 AND status = 'Pending' 
                        ORDER BY created_at DESC";
    $pendingUsersResult = mysqli_query($conn, $pendingUsersSql);

    // Fetch Accepted Agents (role_id = 2)
    $acceptedAgentsSql = "SELECT user_id, username, email, created_at 
                          FROM users 
                          WHERE role_id = 2 AND status = 'Accepted' 
                          ORDER BY created_at DESC";
    $acceptedAgentsResult = mysqli_query($conn, $acceptedAgentsSql);

    // Fetch Accepted Users (role_id = 3)
    $acceptedUsersSql = "SELECT user_id, username, email, created_at 
                         FROM users 
                         WHERE role_id = 3 AND status = 'Accepted' 
                         ORDER BY created_at DESC";
    $acceptedUsersResult = mysqli_query($conn, $acceptedUsersSql);

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
                <h2 class="mb-4 text-danger"><i class="fas fa-users-cog"></i> Manage Users</h2>

                <!-- =======================
                     PENDING REQUESTS SECTION
                     ======================= -->
                <div class="row mb-5">
                    <div class="col-12">
                        <h4 class="text-warning mb-3"><i class="fas fa-clock"></i> Pending Requests</h4>
                    </div>

                    <!-- Pending Agents Table -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-user-tie"></i> Pending Agents</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($pendingAgentsResult) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($pendingAgentsResult)): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                        <td>
                                                            <form method="POST" style="display:inline;">
                                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                                <button type="submit" name="accept_user" class="btn btn-success btn-sm" title="Accept">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                            <form method="POST" style="display:inline;">
                                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                                <button type="submit" name="reject_user" class="btn btn-danger btn-sm" title="Reject" onclick="return confirm('Are you sure you want to reject this user?');">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr><td colspan="4" class="text-center text-muted">No pending agents</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Users Table -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-user"></i> Pending Users</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($pendingUsersResult) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($pendingUsersResult)): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                        <td>
                                                            <form method="POST" style="display:inline;">
                                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                                <button type="submit" name="accept_user" class="btn btn-success btn-sm" title="Accept">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                            <form method="POST" style="display:inline;">
                                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                                <button type="submit" name="reject_user" class="btn btn-danger btn-sm" title="Reject" onclick="return confirm('Are you sure you want to reject this user?');">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr><td colspan="4" class="text-center text-muted">No pending users</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- =======================
                     ACCEPTED USERS SECTION
                     ======================= -->
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-success mb-3"><i class="fas fa-check-circle"></i> Accepted Users</h4>
                    </div>

                    <!-- Accepted Agents Table -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-user-tie"></i> Agents</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-success">
                                            <tr>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Registered Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($acceptedAgentsResult) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($acceptedAgentsResult)): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr><td colspan="3" class="text-center text-muted">No accepted agents</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accepted Users Table -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-user"></i> Users</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-success">
                                            <tr>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Registered Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($acceptedUsersResult) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($acceptedUsersResult)): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr><td colspan="3" class="text-center text-muted">No accepted users</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
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