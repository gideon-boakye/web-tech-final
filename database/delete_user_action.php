<?php

include 'connection.php';
$user_id = $_POST['user_id'];
$notice = [
    'success' => false,
    'message' => "Failed to delete user"
];

$delete_query_order_products = "DELETE op FROM order_products op JOIN orders o ON op.order_id = o.order_id WHERE o.supplier_id = ? OR o.recycler_id = ?";
$delete_query_orders = "DELETE FROM orders WHERE supplier_id = ? OR recycler_id = ?";
$delete_query_order_products_by_product = "DELETE FROM order_products WHERE product_id IN (SELECT product_id FROM products WHERE supplied_by = ?)";
$delete_query_products = "DELETE FROM products WHERE supplied_by = ?";
$delete_query_recycler = "DELETE FROM recyclers WHERE recycler_id = ?";
$delete_query_suppliers = "DELETE FROM suppliers WHERE supplier_id = ?";
$delete_query_users = "DELETE FROM users WHERE user_id = ?";

try {
    $stmt = $conn->prepare($delete_query_order_products);
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();

    $stmt = $conn->prepare($delete_query_orders);
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();

    $stmt = $conn->prepare($delete_query_order_products_by_product);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();

    $stmt = $conn->prepare($delete_query_products);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();

    $stmt = $conn->prepare($delete_query_recycler);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();

    $stmt = $conn->prepare($delete_query_suppliers);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();

    $stmt = $conn->prepare($delete_query_users);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();

    $notice = [
        'success' => true,
        'message' => "User deleted successfully"
    ];
} catch (PDOException $e) {
    $notice['message'] = $e->getMessage();
}

echo json_encode($notice);
?>