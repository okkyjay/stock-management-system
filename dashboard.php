<?php include("conn/db_con.php");?>
<?php include("layouts/header.php")?>

<?php if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])){
    header("location:index.php?error=you need to login");
}
$user = $_SESSION['user'];
?>
    <div style="padding: 40px">
        <a href="sales.php" class="btn btn-primary">Add Sales</a>
        <?php if ($user['role'] == 'admin'): ?>
            <a href="stocks.php" class="btn btn-secondary">Add stock</a>
            <a href="stockCat.php" class="btn btn-success">Add stock Category</a>
            <a href="expenses.php" class="btn btn-danger">Add Expense</a>
            <a href="expenseCat.php" class="btn btn-warning">Add expense Categories</a>
            <a href="users.php" class="btn btn-info">Add User</a>
        <?php endif ?>
    </div>
<?php include("layouts/footer.php")?>
