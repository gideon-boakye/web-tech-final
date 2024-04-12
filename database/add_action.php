<?php

session_start();
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$usertype = $_POST['usertype'];
$phone = $_POST['phone'];
$location = $_POST['location'];


$encrypted = rand(10000, 99999);


$insert_query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at, usertype, phone, location) VALUES (?, ?, ?, ?, NOW(), NOW(), ?, ?, ?)";

$notice = [
    'success' => false,
    'message' => "Failed to add new user",
    'assigned_id' => 0
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
            'message' => $first_name . ' ' . $last_name . ' successfully added!'
        ];

        if ($usertype == 1) {
            $insert_query_recycler = "INSERT INTO recyclers (recycler_id) VALUES (?)";
            $stmt_recycler = $conn->prepare($insert_query_recycler);
            $stmt_recycler->bindParam(1, $last_id);
            $stmt_recycler->execute();
        } elseif ($usertype == 2) {
            $insert_query_suppliers = "INSERT INTO suppliers (supplier_id) VALUES (?)";
            $stmt_suppliers = $conn->prepare($insert_query_suppliers);
            $stmt_suppliers->bindParam(1, $last_id);
            $stmt_suppliers->execute();
        }
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    $notice['message'] = "An error occurred: " . $e->getMessage();
}

$_SESSION['response'] = $notice;
echo json_encode($notice);
