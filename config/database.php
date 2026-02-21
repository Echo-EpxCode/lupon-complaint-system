<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lupon_complaint_system";

$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* Create database */
$sql = "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!mysqli_query($conn, $sql)) {
    die("Database creation failed: " . mysqli_error($conn));
}

mysqli_select_db($conn, $db);

/* SQL schema + seed data */
$sql = "
CREATE TABLE IF NOT EXISTS user_roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE
);

INSERT IGNORE INTO user_roles (role_name) VALUES
('Admin'), ('Agent'), ('User');

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    status ENUM('Pending', 'Accepted') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_role FOREIGN KEY (role_id)
        REFERENCES user_roles(role_id)
        ON DELETE RESTRICT
);


CREATE TABLE IF NOT EXISTS complaint_status (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    status_name VARCHAR(50) NOT NULL UNIQUE
);

INSERT IGNORE INTO complaint_status (status_name) VALUES
('Pending'), ('In Progress'), ('Resolved'), ('Closed');

CREATE TABLE IF NOT EXISTS complaints (
    complaint_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    respondent_id INT DEFAULT NULL,
    assigned_agent_id INT DEFAULT NULL,
    complaint_type VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    meeting_link VARCHAR(500) NULL,
    status_id INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_complaint_user FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_assigned_agent FOREIGN KEY (assigned_agent_id)
        REFERENCES users(user_id)
        ON DELETE SET NULL,
    CONSTRAINT fk_complaint_status FOREIGN KEY (status_id)
        REFERENCES complaint_status(status_id)
);

CREATE TABLE IF NOT EXISTS complaint_attachments (
    attachment_id INT AUTO_INCREMENT PRIMARY KEY,
    complaint_id INT NOT NULL,
    uploaded_by INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_attachment_complaint FOREIGN KEY (complaint_id)
        REFERENCES complaints(complaint_id)
        ON DELETE CASCADE
);
";

/* Execute multiple queries */
if (!mysqli_multi_query($conn, $sql)) {
    die("Schema error: " . mysqli_error($conn));
}

/* Flush multi_query results */
while (mysqli_more_results($conn)) {
    mysqli_next_result($conn);
}

/* Create default admin user securely */
$adminPassword = password_hash("admin123", PASSWORD_DEFAULT);

$adminSql = "
INSERT IGNORE INTO users (username, email, password, role_id, status)
VALUES ('ADMINISTRATOR', 'admin@example.com', '$adminPassword', 1, 'Accepted')
";

if (!mysqli_query($conn, $adminSql)) {
    die("Admin insert failed: " . mysqli_error($conn));
}

// echo "Complaint system database initialized successfully ✅";
?>