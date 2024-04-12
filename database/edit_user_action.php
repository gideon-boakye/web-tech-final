<?php
include('connection.php');
$user_id = $_POST['edit_user_id'];
$first_name = $_POST['edit_first_name'];
$last_name = $_POST['edit_last_name'];
$phone = $_POST['edit_phone'];
$location = $_POST['edit_location'];

$update_query = "UPDATE users SET first_name = ?, last_name = ?, phone = ?, location = ? WHERE user_id = ?";

$notice = [
    'success' => false,
    'message' => "Failed to update user"
];



try {
    $stmt = $conn->prepare($update_query);
    $stmt->bindParam(1, $first_name);
    $stmt->bindParam(2, $last_name);
    $stmt->bindParam(3, $phone);
    $stmt->bindParam(4, $location);
    $stmt->bindParam(5, $user_id);

    if ($stmt->execute()) {
        $notice = [
            'success' => true,
            'message' => "User updated successfully"
        ];
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    $notice['message'] = "An error occurred: " . $e->getMessage();
}

echo json_encode($notice);
