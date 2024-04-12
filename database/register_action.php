<?php

session_start();
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$location = $_POST['location'];


$encrypted = rand(10000, 99999);
$usertype = 3;


$insert_query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at, usertype, phone, location) VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?, ?)";

$notice = [
    'success' => false,
    'message' => "Failed to register"
];

include('connection.php');

try {
    $stmt = $conn->prepare($insert_query);
    $stmt->bindParam(1, $first_name);
    $stmt->bindParam(2, $last_name);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $encrypted);
    $stmt->bindParam(5, $usertype);
    $stmt->bindParam(6, $phone);
    $stmt->bindParam(7, $location);

    if ($stmt->execute()) {
        $last_id = $conn->lastInsertId();
        $notice = [
            'success' => true,
            'message' => "Your assigned identifier is $encrypted. Please keep it safe."
        ];
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    $notice['message'] = "An error occurred: " . $e->getMessage();
}
echo json_encode($notice);
