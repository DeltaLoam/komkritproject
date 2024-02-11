<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_transaction'])) {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $type = $_POST['type'];

    // Insert transaction into the database
    $sql = "INSERT INTO transactions (amount, category, type) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$amount, $category, $type]);

    // Redirect back to the main page
    header("Location: index.php");
    exit;
}
?>
