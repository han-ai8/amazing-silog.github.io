<?php

include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<style>
*{
   font-family: 'Poppins', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border: none;
   text-decoration: none;
}
:root{
   --yellow:#fed330;
   --orange: #e48100;
   --red:#e74c3c;
   --white:#fff;
   --black: #222;
   --light-color: #777;
   --border:.2rem solid var(--yellow);
}
.form-container{
   width: 70%;
   
}
.form-container input{
   border-radius: 5px;
   font-size: 1.7rem;
   margin-bottom: 20px;
   border: var(--border);
   height: 50px;
   width: 100%;
}
input[type="email"],input[type="password"]{
   text-indent: 10px;
}
.form-container h1{
   
   margin-top: 30px;
   margin-bottom: 45px;
   font-size: 3rem;
   height: 15px;
}
.form-container p{
   margin-top: 5px;
   font-size: 1.7rem;
   color:var(--light-color);
}
.form-container input:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}
.form-container .box {
   height: 50px;
   background: #fff;
   border-radius: 12px;
   border: var(--border);
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   text-align: center;
   text-decoration: none;
   transition: transform 0.3s ease, box-shadow 0.3s ease;
   padding: 20px;
   display: flex;
   flex-direction: column;
   align-items: center;
}
.form-container .box:hover {
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}
h3 {
   font-size: 2rem;
}
/* media queries  */
@media (min-width:992px) {
   .form-container{
      margin-top: 100px;
      margin-bottom: 100px;
      width: 500px;
   }
}
@media (max-width:991px) {
   .form-container{
      margin-top: 100px;
      margin-bottom: 100px;
      width: 400px;
   }
}
@media (max-width:768px){
   .form-container{
      margin-top: 100px;
      margin-bottom: 100px;
      width: 400px;
   }
}
@media (max-width:470px) {
   .form-container{
      margin-top: 100px;
      margin-bottom: 100px;
      width: 400px;
   }
   
}
</style>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>Login</h3>
      <input type="email" name="email" required placeholder="Enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>