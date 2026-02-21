<?php
session_start();
include_once '../config/database.php';

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $complaint_type = $_POST['complaint_type'];
    $description = $_POST['description'];
    $respondent_id = !empty($_POST['respondent_id']) ? $_POST['respondent_id'] : NULL;
    $status = 1;

    // Use prepared statement for security
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, respondent_id, complaint_type, description, status_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissi", $user_id, $respondent_id, $complaint_type, $description, $status);

    if ($stmt->execute()) {
        $complaint_id = $stmt->insert_id;
        $stmt->close();

        // Handle file upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['attachment']['tmp_name'];
            $fileName = $_FILES['attachment']['name'];
            $fileSize = $_FILES['attachment']['size'];
            $fileType = $_FILES['attachment']['type'];

            $fileNameClean = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $fileName);
            $uploadDir = "../uploads/";
            $destPath = $uploadDir . time() . "_" . $fileNameClean;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $stmt2 = $conn->prepare("INSERT INTO complaint_attachments (complaint_id, uploaded_by, file_name, file_path, file_type) VALUES (?, ?, ?, ?, ?)");
                $stmt2->bind_param("iisss", $complaint_id, $user_id, $fileNameClean, $destPath, $fileType);
                $stmt2->execute();
                $stmt2->close();
            } else {
                echo "Error uploading the file.";
            }
        }

        header('Location: dashboard.php');
        exit;
    } else {
        echo "Error submitting complaint: " . $conn->error;
    }
}