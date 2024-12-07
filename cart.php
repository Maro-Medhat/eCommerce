<?php
    session_start();
    $user_id = $_SESSION['user_id'];

    $conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");   
    
    if(isset($_POST['Add'])){
        $id = $_POST['id'];
        $pName = $_POST['name'];
        $pPrice = $_POST['price'];
        $query = "INSERT INTO cart VALUES ('$user_id', '$id', '$pName', '$pPrice');";
        mysqli_query($conn, $query);
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "DELETE FROM cart WHERE id=$id AND user_id=$user_id";
        mysqli_query($conn, $query);
        header("Location: cart.php");
    }
    $query = "SELECT name FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cart.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="css/Toastr/toastr.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="cart.php"><i data-feather="shopping-cart"></i> Cart</a></li>
            <li><a href="profile.php"><i data-feather="user"></i> Profile</a></li>
            <li><a href="products.php"><i data-feather="copy"></i> Show Products</a></li>
            <li><a href="login.php?logout=true"><i data-feather="log-out"></i> Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2><?php echo $row['name'] . "'s"?> Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Delete Product</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM cart WHERE user_id=$user_id";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $row['name']?></td>
                    <td>$<?php echo $row['price']?></td>
                    <td><a href="cart.php?id=<?php echo $row['id']?>" class="delete-btn">Delete</a></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</body>
<!-- jquery -->
<script src="js/jquery.js"></script>

<!-- toastr -->
<script src="js/toastr.js"></script>

<!-- Feather Icons -->
<script src="css/Feather_icons/feather.js"></script>

<script>
    feather.replace();

</script>
</html>