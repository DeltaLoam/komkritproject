<!-- navbar.php -->
<div class="navbar">
    <a href="index.php" <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'class="active"'; ?>>Home</a>
    <a href="dashboard.php" <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo 'class="active"'; ?>>Dashboard</a>
    <!-- Add more navigation links as needed -->
</div>
