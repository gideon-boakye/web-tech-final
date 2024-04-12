<?php
$servername = 'localhost';
$username = 'root';
$password = 'password';

try {
    $conn = new PDO("mysql:host=$servername;dbname=Inventory", $username, $password); 

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

