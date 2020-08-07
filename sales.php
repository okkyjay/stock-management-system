<?php include("conn/db_con.php");?>
<?php include("layouts/header.php")?>

<?php if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])){
    header("location:index.php?error=you need to login");
}
$user = $_SESSION['user'];
$userId = $user['id'];

if (isset($_POST['add-sale'])){
    $stockId = $_POST['stock_id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];
    $sql = "INSERT INTO sales (`stock_id`, `quantity`, `status`, `user_id`) VALUES  ('$stockId', '$quantity', '$status', '$userId')";
    $conn->query($sql);

    $stockSQL = "SELECT * FROM stocks WHERE id='{$stockId}'";
    $record = $conn->query($stockSQL)->fetch_assoc();
    $originalQuantity = $record['quantity'];
    $remainingQuantity = $originalQuantity - $quantity;

    $stockSQL = "UPDATE stocks SET quantity='{$remainingQuantity}' WHERE id='{$stockId}'";
    $conn->query($stockSQL);
}
?>

<div style="padding: 40px">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <select required name="stock_id" class="form-control select2">
                            <?php
                            $stocks = "SELECT * FROM stocks";
                            $stocks = $conn->query($stocks)->fetch_all(MYSQLI_ASSOC);
                            ?>
                            <?php foreach ($stocks as $stock): ?>
                                <option value="<?php echo $stock['id']?>"> <?php echo $stock['title'] ?> - &#x20A6;<?php echo number_format($stock['price'], 2)?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <input class="form-control" required type="number" name="quantity" step="1">
                    </div>
                    <div class="col-md-3 form-group">
                        <select required name="status" class="form-control select2">
                            <option value="paid">Paid</option>
                            <option value="returned">Returned</option>
                            <option value="on credit">On credit</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <button name="add-sale" type="submit" class="btn btn-primary">Add sale</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> S/N </th>
                            <th> Name of good </th>
                            <th> Quantity </th>
							<th> Amount </th>
                            <th> Status </th>
                            <th> Date </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "";
                            if ($user['role'] == 'sale'){
                                $sql = "SELECT * FROM sales WHERE user_id='{$user['id']}'";
                            }elseif ($user['role'] == 'admin'){
                                $sql = "SELECT * FROM sales";
                            }
                            $queryResult = $conn->query($sql);
                            $sales = $queryResult->fetch_all(MYSQLI_ASSOC);
                        ?>
                        <?php foreach ($sales as $key => $sale): ?>
                            <tr>
                                <td> <?php echo $key+1 ?> </td>
                                <td>
                                    <?php
                                        $stockSQL = "SELECT * FROM stocks WHERE id='{$sale['stock_id']}'";
                                        $q = $conn->query($stockSQL);
                                        $reco = $q->fetch_assoc();
										echo $reco['title'];
                                    ?>
                                </td>
                                <td> <?php echo $sale['quantity'] ?></td>
								<td> &#x20A6; <?php  echo number_format(($reco['price'] * $sale['quantity']),2) ?> </td>
                                <td> <?php echo ucwords($sale['status']) ?></td>
                                <td> <?php echo date('d-M-y', strtotime($sale['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include("layouts/footer.php")?>
