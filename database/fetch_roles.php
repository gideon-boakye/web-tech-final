<?php

include "connection.php";


try {
    $sql = "SELECT * FROM userrole";
    $result = $conn->query($sql);

    $users = array(); 

    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($users);
} catch (\Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>