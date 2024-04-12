<?php
require_once 'connection.php';
$response = array('success' => false, 'message' => 'An error occurred');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    try {
        $conn->beginTransaction();
        $stmt = $conn->prepare("DELETE FROM order_products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $conn->commit();
        $response['success'] = true;
        $response['message'] = 'Product deleted successfully';
    } catch (Exception $e) {
        $conn->rollBack();
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}
echo json_encode($response);