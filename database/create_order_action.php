<?php
require_once 'connection.php';

$response = array('success' => false, 'message' => 'An error occurred');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];
    $action = $_POST['action'];
    $serviceprovider_id = $_POST['serviceprovider'];

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO orders (supplier_id, recycler_id, action) VALUES (:supplier_id, :recycler_id, :action)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'supplier_id' => $action === 'order' ? $serviceprovider_id : null,
            'recycler_id' => $action === 'recycle' ? $serviceprovider_id : null,
            'action' => $action
        ]);

        $order_id = $conn->lastInsertId();

        $sql = "INSERT INTO order_products (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";

        $stmt = $conn->prepare($sql);

        for ($i = 0; $i < count($product_ids); $i++) {
            $stmt->execute([
                'order_id' => $order_id,
                'product_id' => $product_ids[$i],
                'quantity' => $quantities[$i]
            ]);
        }

        $conn->commit();

        $response['success'] = true;
        $response['message'] = 'Order created successfully';
    } catch (Exception $e) {
        $conn->rollBack();

        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>