<?php
require_once 'connection.php';

try {
    $sql = "
        SELECT 
            orders.order_id AS order_id, 
            orders.action, 
            orders.status,
            order_products.product_id, 
            order_products.quantity, 
            products.name AS product_name,
            products.description AS product_description,
            users.user_id AS user_id, 
            users.first_name AS user_first_name,
            users.last_name AS user_last_name,
            userrole.rolename AS user_role
        FROM orders
        INNER JOIN order_products ON orders.order_id = order_products.order_id
        INNER JOIN products ON order_products.product_id = products.product_id
        INNER JOIN users ON orders.supplier_id = users.user_id OR orders.recycler_id = users.user_id
        INNER JOIN userrole ON users.usertype = userrole.typeid
        ORDER BY orders.order_id
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $orders = [];
    foreach ($rows as $row) {
        $orderId = $row['order_id'];
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                'order_id' => $orderId,
                'action' => $row['action'],
                'status' => $row['status'],
                'user' => [
                    'id' => $row['user_id'],
                    'first_name' => $row['user_first_name'],
                    'last_name' => $row['user_last_name'],
                    'role' => $row['user_role']
                ],
                'products' => []
            ];
        }
        $orders[$orderId]['products'][] = [
            'product_id' => $row['product_id'],
            'quantity' => $row['quantity'],
            'name' => $row['product_name'],
            'description' => $row['product_description']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode(array_values($orders));
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>