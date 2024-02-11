<?php
require_once 'db_connect.php';

// Fetch transactions from the database
$sql = "SELECT * FROM transactions ORDER BY created_at DESC";
$stmt = $db->prepare($sql);
$stmt->execute();
$transactions = $stmt->fetchAll();
?>

<?php foreach ($transactions as $transaction): ?>
    <li><?= $transaction['type'] ?>: <?= $transaction['category'] ?> - $<?= $transaction['amount'] ?></li>
<?php endforeach; ?>
