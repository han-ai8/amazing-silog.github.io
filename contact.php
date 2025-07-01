<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND message = ?");
   $select_message->execute([$name, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, message) VALUES(?,?,?)");
      $insert_message->execute([$user_id, $name, $msg]);

      $message[] = 'sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

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
   width: 100%;
}
.contact{
   width: 1000px;
   margin: 0 auto; /* Center the contact section */
   margin-top: 50px;
   margin-bottom: 50px;
}

.row{
   display: grid;
   grid-template-columns: 1fr 1fr; /* Equal columns */
   gap: 100px; /* Add spacing between columns */
   
   align-items: center; /* Vertically align items */
}

/* Style the image container */
.image {
   display: flex;
   justify-content: center;
   align-items: center;
}

.image img {
   max-width: 100%;
   height: auto;
}

.contact input{
   border-radius: 5px;
   font-size: 1.7rem;
   margin-bottom: 20px;
   border: var(--border);
   height: 50px;
   width: 100%; /* Changed from 70% to use full width of form */
}
input[type="email"],input[type="password"],input[type="number"],input[type="text"],textarea[name="msg"]{
   text-indent: 10px;
}
.contact textarea{
   border-radius: 5px;
   font-size: 1.7rem;
   margin-bottom: 20px;
   border: var(--border);
   width: 100%; /* Changed from 70% to use full width of form */
}
.contact h1{
   margin-top: 20px;
   margin-bottom: 55px;
   font-size: 3rem;
   height: 15px;
}
.contact p{
   margin-top: 5px;
   font-size: 1.7rem;
   color:var(--light-color);
}
.contact input:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}
.contact .box {
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

.contact .box:hover {
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

/* Add button styling */
.btn {
   background: var(--yellow);
   color: var(--black);
   padding: 12px 30px;
   border-radius: 5px;
   font-size: 1.7rem;
   cursor: pointer;
   transition: all 0.3s ease;
}

.btn:hover {
   background: var(--orange);
   transform: translateY(-2px);
}

/* media queries  */
@media (max-width: 1024px) {
   .contact {
      width: 90%;
      max-width: 900px;
   }
}

@media (max-width: 768px) {
   .contact {
      width: 95%;
   }
   
   .row {
      grid-template-columns: 1fr; /* Stack vertically on mobile */
      gap: 30px;
   }
   
   .contact .box {
      height: auto; /* Allow flexible height on mobile */
   }
}

@media (max-width: 470px) {
   .contact {
      width: 100%;
      padding: 0 10px;
   }
   
   .contact input,
   .contact textarea {
      font-size: 1.4rem;
   }
   
   .contact h1 {
      font-size: 2.5rem;
   }
}

</style>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->



<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/feedback.jpg" alt="">
      </div>

      <form action="" method="post" class="box">
         <h1>Message us!</h1>
         <input type="text" name="name" maxlength="50" placeholder="Enter your name" required>
         <textarea name="msg" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>

   </div>

</section>

<!-- contact section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>