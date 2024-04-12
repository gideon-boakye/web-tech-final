<?php
include('connection.php');

try {
    $sql = "SELECT products.*, users.first_name, users.last_name FROM products JOIN users ON products.supplied_by = users.user_id";
    $result = $conn->query($sql);

    $products = array(); 

    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($products);
} catch (\Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}