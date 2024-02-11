<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="active">Home</a>
        <a href="dashboard.php">Dashboard</a>
    </div>
    <div class="container">
        <h1 class="title">Personal Finance Tracker</h1>
        <form action="add_transaction.php" method="post" class="transaction-form">
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <button type="submit" name="add_transaction" class="btn btn-primary">Add Transaction</button>
        </form>

        <h2 class="transaction-history-heading">Transaction History</h2>
        <ul class="transaction-list">
            <?php include 'get_transactions.php'; ?>
        </ul>
    </div>
    <button id="dark-mode-toggle" class="dark-mode-toggle">Toggle Dark Mode</button>

    <script src="script.js"></script>
</body>
</html>
