<?php

include 'connection.php';

$user_id = $_REQUEST['user_id'];

$sql = "SELECT * FROM users WHERE user_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $user_id);

$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$response = [
    'user_id' => $user['user_id'],
    'first_name' => $user['first_name'],
    'last_name' => $user['last_name'],
    'email' => $user['email'],
    'location' => $user['location'],
    'phone' => $user['phone'],
    'usertype' => $user['usertype']
];

echo json_encode($response);
