<?php
session_start();
include_once '../config/database.php';

if(isset($_POST['submit']))
    {
        $user_id = $_SESSION['user_id'];
        $agent_id = "1";
        $complaint_type = $_POST['complaint_type'];
        $description = $_POST['description'];
        $status = "1";    
        
        $insertComplaint = "INSERT INTO `complaints`(`user_id`, `complaint_type`, `description`) VALUES ('$user_id', '$complaint_type', '$description')";
        

        if(mysqli_query($conn, $insertComplaint))
         {
                $complaint_id = mysqli_insert_id($conn); // Get last inserted complaint ID

                // Handle file if uploaded

                if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['attachment']['tmp_name'];
                    $fileName = $_FILES['attachment']['name'];
                    $fileSize = $_FILES['attachment']['size'];
                    $fileType = $_FILES['attachment']['type'];
                    
                    // Optional: sanitize file name
                    $fileNameClean = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $fileName);

                    // Define upload folder
                    $uploadDir = "../uploads/"; // make sure this folder exists and is writable
                    $destPath = $uploadDir . time() . "_" . $fileNameClean;

                    // Move file
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        // Insert into attachments table
                        $insertAttachment = "INSERT INTO complaint_attachments 
                            (complaint_id, uploaded_by, file_name, file_path, file_type) VALUES ('$complaint_id', '$user_id', '$fileNameClean', '$destPath', '$fileType')";
                        
                        mysqli_query($conn, $insertAttachment);
                    } else {
                        echo "Error uploading the file.";
                    }
        }

        header('location: dashboard.php');

    }else {
        echo "Error submitting complaint: " . mysqli_error($conn);
    }
        



    }