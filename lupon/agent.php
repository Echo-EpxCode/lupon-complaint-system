<?php

require_once "../config/auth.php";
checkAuth();
include_once '../config/database.php';

$lupon_id = $_SESSION['user_id']; // Defaulting to 1 for testing

$sql = "Select * from `users` WHERE `u"

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard - Assigned Complaints</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; padding-top: 20px; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4 text-success"><i class="fas fa-headset"></i> Assigned Complaints</h2>

    <div class="table-container">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Complainant</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Attachment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        // Determine Badge Color based on status
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
                            <td><?php echo htmlspecialchars($row['complainant_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['complaint_type']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td><span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['status_name']); ?></span></td>
                            <td>
                                <!-- Popover for Description -->
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="popover" data-bs-title="Complaint Details" data-bs-content="<?php echo htmlspecialchars($row['description']); ?>">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                            <td>
                                <?php if($attPath): ?>
                                    <button type="button" class="btn btn-primary btn-sm" 
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
                    echo "<tr><td colspan='7' class='text-center'>No assigned complaints found.</td></tr>";
                }
                
                // Close connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL STRUCTURE (Same as User View) -->
<div class="modal fade" id="attachmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attachment Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                
                <!-- Image Container -->
                <div id="modalImageContainer">
                    <img src="" id="modalImageSrc" class="img-fluid" alt="Attachment">
                </div>

                <!-- Download Container -->
                <div id="modalDownloadContainer" class="d-none">
                    <p class="mb-3">This file type cannot be previewed directly.</p>
                    <a href="" id="modalDownloadLink" class="btn btn-success" download>
                        <i class="fas fa-download"></i> Download File
                    </a>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Initialize Popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });

    // Modal Logic
    const modalElement = document.getElementById('attachmentModal');
    const modalImageContainer = document.getElementById('modalImageContainer');
    const modalDownloadContainer = document.getElementById('modalDownloadContainer');
    const modalImageSrc = document.getElementById('modalImageSrc');
    const modalDownloadLink = document.getElementById('modalDownloadLink');

    modalElement.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const filepath = button.getAttribute('datafilepath');
        const isImage = button.getAttribute('data-isimage') === 'true';
        const filename = button.getAttribute('data-filename');

        // Reset contents
        modalImageSrc.src = "";
        modalDownloadLink.href = "";

        if (isImage) {
            // Show Image, Hide Download
            modalImageContainer.classList.remove('d-none');
            modalDownloadContainer.classList.add('d-none');
            modalImageSrc.src = filepath;
        } else {
            // Hide Image, Show Download
            modalImageContainer.classList.add('d-none');
            modalDownloadContainer.classList.remove('d-none');
            modalDownloadLink.href = filepath;
            modalDownloadLink.setAttribute('download', filename);
        }
    });
</script>

</body>
</html>