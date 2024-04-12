<?php
header('Content-Type: application/json');

include 'connection.php';

if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['quantity']) && isset($_POST['supplier'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $supplier = $_POST['supplier'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, quantity_in_stock, supplied_by) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $description);
    $stmt->bindParam(3, $quantity);
    $stmt->bindParam(4, $supplier);

    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => $name . ' successfully added!'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Failed to add product.'
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'All product details must be provided.'
    ];
}

$conn = null;

echo json_encode($response);