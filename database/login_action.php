<?php
include_once 'connection.php';
session_start();
$username = $_POST['email'];
$password = $_POST['password'];
$notice = ['success' => false, 'message' => 'Incorrect username or password, or unauthorized access!'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    if ($password == $user['password'] && $user['usertype'] == 3) {
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['logged_in'] = true;

        $notice['success'] = true;
        $notice['message'] = 'Login successful!';
    }
}

echo json_encode($notice);
