<?php
    include("conn/db_con.php");
    if (isset($_SESSION['user']) || isset($_SESSION['user']['role'])) {
        header("location:dashboard.php");
    }
    $errorMsg = "";
    $successMsg = "";

    if (isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)){
            $errorMsg = "Fill the required fields";
        }else{
            $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
            $queryResult = $conn->query($sql);
            if ($queryResult->num_rows == 1){
                $user = $queryResult->fetch_assoc();
                $_SESSION['user'] = $user;
                header("location:dashboard.php");
            }
        }

    }
?>

<?php include("layouts/header.php")?>
<div style="padding: 130px;">
    <form method="post" action="" class="form-horizontal">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input required name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input required name="password" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button name="login" type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php include("layouts/footer.php")?>
