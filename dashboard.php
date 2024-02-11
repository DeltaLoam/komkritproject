<?php
include 'db_connect.php';

// Fetch recent transactions
try {
    $query = "SELECT * FROM transactions ORDER BY created_at DESC LIMIT 5";
    $statement = $db->query($query);
    $transactions = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error fetching transactions: " . $e->getMessage();
}

$monthNames = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
];

// Fetch income and expense data for graph
// Modify the query according to your database structure
try {
    $query = "SELECT MONTH(created_at) AS month, SUM(amount) AS total_amount, type FROM transactions GROUP BY MONTH(created_at), type";
    $statement = $db->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $incomeData = [];
    $expenseData = [];
    $months = [];
    
    foreach ($result as $row) {
        $month = date('F', mktime(0, 0, 0, $row['month'], 1));
        if (!in_array($month, $months)) {
            $months[] = $month;
        }
        if ($row['type'] === 'income') {
            $incomeData[$row['month']] = $row['total_amount'];
        } else {
            $expenseData[$row['month']] = $row['total_amount'];
        }
    }

        // Fetch income data
        $incomeQuery = "SELECT MONTH(created_at) AS month, SUM(amount) AS total_amount FROM transactions WHERE type = 'income' GROUP BY MONTH(created_at)";
        $incomeStatement = $db->query($incomeQuery);
        $incomeResult = $incomeStatement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($incomeResult as $row) {
            $incomeData[$row['month']] = $row['total_amount'];
        }
    
        // Fetch expense data
        $expenseQuery = "SELECT MONTH(created_at) AS month, SUM(amount) AS total_amount FROM transactions WHERE type = 'expense' GROUP BY MONTH(created_at)";
        $expenseStatement = $db->query($expenseQuery);
        $expenseResult = $expenseStatement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($expenseResult as $row) {
            $expenseData[$row['month']] = $row['total_amount'];
        }
    
        // Get unique months from both income and expense data
        $months = array_unique(array_merge(array_keys($incomeData), array_keys($expenseData)));
        
        
} catch(PDOException $e) {
    echo "Error fetching income and expense data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1 class="title">Dashboard</h1>
        <div class="overview">
            <div class="graph-section">
                <h2>Income and Expense Overview</h2>
                <div class="graph" id="income-expense-graph"></div>
            </div>
            <div class="summary-section">
                <h2>Recent Transactions</h2>
                <ul class="transaction-list">
                    <?php foreach ($transactions as $transaction): ?>
                        <li><?php echo $transaction['created_at']; ?> - $<?php echo $transaction['amount']; ?> - <?php echo $transaction['category']; ?> (<?php echo ucfirst($transaction['type']); ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Income',
                data: [
                    <?php foreach ($months as $month): ?>
                        <?php echo isset($incomeData[$month]) ? $incomeData[$month] : 0; ?>,
                    <?php endforeach; ?>
                ]
            }, {
                name: 'Expense',
                data: [
                    <?php foreach ($months as $month): ?>
                        <?php echo isset($expenseData[$month]) ? $expenseData[$month] : 0; ?>,
                    <?php endforeach; ?>
                ]
            }],
            xaxis: {
                categories: [
                    <?php foreach ($months as $month): ?>
                    '<?php echo $monthNames[$month]; ?>',
                    <?php endforeach; ?>
                 ]
        }
        };

        var chart = new ApexCharts(document.querySelector("#income-expense-graph"), options);
        chart.render();
    </script>
        <button id="dark-mode-toggle" class="dark-mode-toggle">Toggle Dark Mode</button>

    <script src="script.js"></script>
</body>
</html>
