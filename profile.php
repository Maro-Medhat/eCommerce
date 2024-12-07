<?php

session_start();
$user_id = $_SESSION['user_id'];
$conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- Toastr -->
    <link rel="stylesheet" href="css/Toastr/toastr.css">

    <link rel="stylesheet" href="css/login&register.css">

    <link rel="stylesheet" href="css/navbar.css">
    
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
        <div class="profile">
        <?php
            $query = "SELECT * FROM users WHERE id = '$user_id'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result); 
            $imageName = $row['image']; ?>
            <img src=<?php echo "profiles_Images/" . $imageName ?>>

            <h3><?php echo $row['name']; ?></h3>
            <a href="update_profile.php" class="btn">Update Profile</a>
            <a href="login.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>
        </div>
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

    <?php if(isset($_GET['Update'])) { ?>
        toastr.success("Profile Updated Sucessfully!!");
    <?php }?>
</script>

</html>