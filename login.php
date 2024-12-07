<?php
   session_start();
   $conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");

   if(isset($_GET['logout']))
      setcookie("user_id", "", time() - 3600, '/');

   if(isset($_POST['submit'])){
      
      $email = $_POST['email'];
      $pass = md5($_POST['password']);

      $query = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'";
      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_assoc($result);
         $_SESSION['user_id'] = $row['id'];
         setcookie('user_id', $row['id'], time() + (86400 * 30), "/") ;
         header('location:profile.php');
      }else{
         $toastr = 1;
      }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <link rel="stylesheet" href="css/login&register.css">

   <!-- Toastr -->
   <link rel="stylesheet" href="css/Toastr/toastr.css">

</head>
<body>
   <div class="form-container">
      <form action="" method="post" enctype="multipart/form-data">
         <h3>Login now</h3>
         <input type="email" name="email" placeholder="test@gmail.com" class="box" required>
         <input type="password" name="password" placeholder="*********" class="box" required>
         <input type="submit" name="submit" value="Login" class="btn">
         <p>don't have an account? <a href="register.php">REGISTER NOW!!</a></p>
      </form>
   </div>
</body>
<!-- jquery -->
<script src="js/jquery.js"></script>

<!-- toastr -->
<script src="js/toastr.js"></script>

<script>
   <?php if(isset($_POST['Register'])) {?>
      toastr.success("Account Created Successfully");
   <?php }?>
   
   <?php if(isset($toastr)) {?>
      toastr.error("Email Or Password Incorrect!!");
   <?php }?>
</script>

</html>