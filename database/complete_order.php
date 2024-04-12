<?php
require_once 'connection.php';
$response = array('success' => false, 'message' => 'An error occurred');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    try {
        $conn->beginTransaction();
        $stmt = $conn->prepare("SELECT action FROM orders WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);
        $action = $stmt->fetchColumn();
        $stmt = $conn->prepare("SELECT * FROM order_products WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);
        $order_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($order_products as $order_product) {
            if ($action === 'order') {
                $stmt = $conn->prepare("UPDATE products SET quantity_in_stock = quantity_in_stock + :quantity WHERE product_id = :product_id");
            } elseif ($action === 'recycle') {
                $stmt = $conn->prepare("UPDATE products SET quantity_in_stock = quantity_in_stock - :quantity WHERE product_id = :product_id");
            }
            $stmt->execute([
                'quantity' => $order_product['quantity'],
                'product_id' => $order_product['product_id']
            ]);
        }
        $sql = "UPDATE orders SET status = 1 WHERE order_id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);
        $conn->commit();
        $response['success'] = true;
        $response['message'] = 'Order processed successfully';
    } catch (Exception $e) {
        $conn->rollBack();
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}
echo json_encode($response);