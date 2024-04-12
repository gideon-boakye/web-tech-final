<?php
require_once 'connection.php';

$response = array('success' => false, 'message' => 'An error occurred');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];

    try {
        $conn->beginTransaction();


        $sql = "DELETE FROM order_products WHERE order_id = :order_id";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'order_id' => $order_id
        ]);

        $sql = "DELETE FROM orders WHERE order_id = :order_id";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'order_id' => $order_id
        ]);

        $conn->commit();

        $response['success'] = true;
        $response['message'] = 'Order canceled successfully';
    } catch (Exception $e) {
        $conn->rollBack();

        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
