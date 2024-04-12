<?php

header('Content-Type: application/json');

$response = [];

if (isset($_GET['rolename'])) {
    $rolename = $_GET['rolename'];
    include 'connection.php';

    $stmt = $conn->prepare("SELECT typeid FROM userrole WHERE rolename = ?");
    $stmt->bindParam(1, $rolename);
    $stmt->execute();
    $typeid = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM users WHERE usertype = ?");
    $stmt->bindParam(1, $typeid);
    $stmt->execute();

    $users = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }

    $response['status'] = 'success';
    $response['data'] = $users;

    $conn = null;
} else {
    $response['status'] = 'error';
    $response['message'] = "Rolename not provided in the GET request.";
}

echo json_encode($response);
