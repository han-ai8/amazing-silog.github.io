<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $address = $_POST['flat'] .', '.$_POST['building'].', '.$_POST['area'].', '.$_POST['town'] .', '. $_POST['city'] .', '. $_POST['state'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'address saved!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update address</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   

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
.form {
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
input[type="email"],input[type="password"],input[type="number"],input[type="text"]{
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
   height: 600px;
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
      width: 500px;
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
      width: 700px;
   } 
}
</style>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form action="" method="post" class="box">
      <h1>ADDRESS</h1>
      <input type="text" placeholder="House No." required maxlength="50" name="flat">
      <input type="text" placeholder="Building" required maxlength="50" name="building">
      <input type="text" placeholder="Street, Block, Lot" required maxlength="50" name="area">
      <input type="text" placeholder="Province" required maxlength="50" name="town">
      <input type="text" placeholder="City" required maxlength="50" name="city">
      <input type="text" placeholder="Barangay" required maxlength="50" name="state">
      <input type="number" placeholder="Postal code" required max="999999" min="0" maxlength="6" name="pin_code">
      <input type="submit" value="save address" name="submit" class="btn">
   </form>

</section>










<?php include 'components/footer.php' ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>