<?php

session_start();
$user_id = $_SESSION['user_id'];

$conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");

if(isset($_POST['Update'])){

   $update_name = $_POST['update_name'];
   $update_email = $_POST['update_email'];

   $query = "UPDATE users SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'";
   mysqli_query($conn, $query);

   $old_pass = $_POST['old_pass'];
   $update_pass = md5($_POST['update_pass']);
   $new_pass = md5($_POST['new_pass']);
   $confirm_pass = md5($_POST['confirm_pass']);

   if($update_pass != $old_pass)
      $toastr = 1;

   elseif($new_pass != $confirm_pass)
      $toastr = 2;
   
   else{
      $query = "UPDATE users SET password = '$confirm_pass' WHERE id = '$user_id'";
      mysqli_query($conn, $query);
      header("Location: profile.php?Update=done");
   }


   $update_image = $_FILES['update_image']['name'];
   $update_image_folder = 'profiles_Images/'. $update_image;

   $query = "UPDATE users SET image = '$update_image' WHERE id = '$user_id'";
   $image_update_query = mysqli_query($conn, $query);
   move_uploaded_file($_FILES['update_image']['tmp_name'], $update_image_folder);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login&register.css">

   <!-- Toastr -->
   <link rel="stylesheet" href="css/Toastr/toastr.css">

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
   
<div class="update-profile">

   <?php
      $query = "SELECT * FROM users WHERE id = '$user_id'";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($result);
      $image_Name = $row['image'];
   ?>

   <form action="update_profile.php" method="post" enctype="multipart/form-data">
      <img src=<?php echo "profiles_Images/" . $image_Name?>>
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="update_name" value="<?php echo $row['name']; ?>" class="box">
            <span>your email :</span>
            <input type="email" name="update_email" value="<?php echo $row['email']; ?>" class="box">
            <span>update your pic :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $row['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="*********" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="*********" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="*********" class="box">
         </div>
      </div>
      <input type="submit" value="Update" name="Update" class="btn">
      <a href="profile.php" class="delete-btn">Go back</a>
   </form>

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

    /* Toastr Message */
    <?php if(isset($toastr)){
        switch($toastr) {
            case 1:
                ?> toastr.error("Old Password Incorrect!!"); <?php
                break;
    
            case 2:
                ?> toastr.success("Confirm Password Doesn't Match!!"); <?php
                break;
        }}?>
</script>
</html>