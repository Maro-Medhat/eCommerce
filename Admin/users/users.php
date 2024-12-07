<?php
    session_start();

    if (!(isset($_COOKIE['user_id'])) || $_COOKIE['user_id'] != 1) 
        header("Location: ../access_denied.php");

    $conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");
    if(isset($_POST['action'])){
        $uName = $_POST['name'];
        $uEmail = $_POST['email'];
        $uMobile = $_POST['mobile'];
        $uPassword = md5($_POST['password']);
        if($_POST['action'] == 'Add'){
            $toastr = 1;
            $query = "INSERT INTO users(name, email, mobile, password) VALUES ('$uName', '$uEmail', '$uMobile', '$uPassword')";
            mysqli_query($conn, $query);
        }

        else if($_POST['action'] == 'Edit'){
            $toastr = 2;
            $id = $_POST['id'];
            $query = "UPDATE users SET name='$uName', email='$uEmail', mobile='$uMobile', password='$uPassword' WHERE id='$id'";
            mysqli_query($conn, $query);
        }
    }

    if(isset($_GET['action']) && $_GET['action'] == 'Delete'){
        $toastr = 3;
        $id = $_GET['id'];
        $query = "DELETE FROM users WHERE id='$id'";
        mysqli_query($conn, $query);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/Bootstrap/bootstrap.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="../../css/Toastr/toastr.css">

    <link rel="stylesheet" href="../../css/navbar.css">

</head>
<body>
    <nav>
        <ul>
            <li><a href="users.php"><i data-feather="users"></i> Show Users</a></li>
            <li><a href="add_user.php"><i data-feather="user-plus"></i> Add User</a></li>
            <li><a href="../products/add_product.php"><i data-feather="package"></i> Add Product</a></li>
            <li><a href="../products/products.php"><i data-feather="copy"></i> Show Products</a></li>
            <li><a href="../../login.php?logout=true"><i data-feather="log-out"></i> Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex p-2 mb-2 justify-content-between">
                <h2>All Users</h2>
                <a href="add_user.php">
                    <i class="text-primary" data-feather="user-plus"></i>
                </a>
            </div>
            <hr>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $query = "SELECT * FROM users";
                    $reuslt = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($reuslt)){ ?>
                        <tr>
                            <td><?php echo $row['id']?></td>
                            <td><?php echo $row['name']?></td>
                            <td><?php echo $row['email']?></td>
                            <td><?php echo $row['mobile']?></td>
                            <td>
                                <div class="d-flex justify-content-evenly">
                                    <a href="users.php?action=Delete&id=<?php echo $row['id']?>"><i class="text-danger" data-feather="trash-2"></i></a>
                                    <a href="edit_user.php?id=<?php echo $row['id'];?>"><i class="text-success" data-feather="edit"></i></a>            
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<!-- Bootstrap -->
<script src="../../css/Bootstrap/bootstrap.bundle.min.js"></script>

<!-- jquery -->
<script src="../../js/jquery.js"></script>

<!-- toastr -->
<script src="../../js/toastr.js"></script>

<!-- Feather Icons -->
<script src="../../css/Feather_icons/feather.js"></script>

<script>
    feather.replace();
    
    /* Toastr Message */
    <?php if(isset($toastr)){
        switch($toastr) {
            case 1:
                ?> toastr.success("User Added Successfully!!"); <?php
                break;
    
            case 2:
                ?> toastr.success("User Edited Successfully!!"); <?php
                break;
            
            case 3:
                ?> toastr.error("User Deleted Successfully!!"); <?php
                break;
        }}?>
</script>
</html>