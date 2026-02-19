<?php
session_start();

function checkAuth() {
  if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
  }
}

// function checkRole($role) {
//   if ($_SESSION['role'] !== $role) {
//     header("Location: /dashboard/index.php");
//     exit;
//   }
// }
