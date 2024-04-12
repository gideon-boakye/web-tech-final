<?php
include('connection.php');

try {
    if (isset($_GET['rolename'])) {
        $rolename = $_GET['rolename'];
        $stmt = $conn->prepare("SELECT typeid FROM userrole WHERE rolename = ?");
        $stmt->bindParam(1, $rolename);
        $stmt->execute();
        $typeId = $stmt->fetchColumn();

        if ($typeId === false) {
            throw new Exception('Role not found');
        }

        $stmt = $conn->prepare("SELECT users.*, userrole.rolename FROM users JOIN userrole ON users.usertype = userrole.typeid WHERE users.usertype = ?");
        $stmt->bindParam(1, $typeId);
    } else {
        $stmt = $conn->prepare("SELECT users.*, userrole.rolename FROM users JOIN userrole ON users.usertype = userrole.typeid");
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $users = array(); 
    if ($stmt->rowCount() > 0) {
        foreach($result as $row) {
            $users[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($users);
} catch (\Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>