<?php

include 'connect.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">

</head>
<style>


:root{
    --yellow:#fed330;
    --orange: #e48100;
    --red:#e74c3c;
    --white:#fff;
    --black: #222;
    --light-color: #777;
    --border:.2rem solid var(--yellow);
}

*{
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    outline: none;
    border: none;
    text-decoration: none;
    list-style: none;
}

*::selection{
    background-color: var(--yellow);
    color:var(--black);
}
 
::-webkit-scrollbar{
    height: .5rem;
    width: 1rem;
}
 
::-webkit-scrollbar-track{
    background-color: transparent;
}

::-webkit-scrollbar-thumb{
    background-color: var(--yellow);
}
 
html{
    font-size: 62.5%;
    overflow-x: hidden;
    scroll-behavior: smooth;
    stop-opacity: 7rem;
}


section{
    margin:0 auto;
    max-width: 1200px;
    padding:2rem;
}

.title{
   text-align: center;
   margin-bottom: 2.5rem;
   font-size: 4rem;
   color:var(--black);
   text-transform: uppercase;
   text-underline-offset: 1rem;
}

.title:hover{
   color: var(--orange);
}

.img-logo{
    height: 80px;
    width: 120px;
    left: 0;
    margin-right: 20px;

}
.heading{
   display: flex;
   align-items: center;
   justify-content: center;
   gap:1rem;
   flex-flow: column;
   background-color:var(--black);
   min-height: 20rem;
}
    
.heading h3{
    font-size: 5rem;
    color:var(--white);
    text-transform: capitalize;
}
 
.heading p{
    font-size: 2.3rem;
    color:var(--light-color);
}
 
.heading p a{
    color:var(--yellow);
}
 
.heading p a:hover{
   text-decoration: underline;
   color:var(--white);
}


.message{
   position: sticky;
   top:0;
   max-width: 1200px;
   margin:0 auto;
   background-color: var(--orange);
   padding:2rem;
   display: flex;
   align-items: center;
   gap:1rem;
   justify-content: space-between;
  
}

.message span{
   font-size: 2rem;
   color:var(--white);
   
}
.message i{
   font-size: 2.5rem;
   color:var(--white);
   cursor: pointer;
}
.message i:hover{
   color:var(--black);
}


/* Make header sticky */
.header {
   position: fixed;
   top: 0;
   width: 100%;
   z-index: 1000;
   background-color: var(--yellow);

   transition: all 0.3s ease;
   box-shadow: none;
}

/* Add effect when scrolled */
.header.scrolled {
   background-color: var(--yellow);
}

.empty{
   border-radius: 10px;
   padding:1.5rem;
   text-align: center;
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
   width: 100%;
   font-size: 2rem;
   text-transform: capitalize;
   color:var(--red);
}
.empty:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

 
.header .flex{
   display: flex;
   align-items: center;
   justify-content: space-between;
   position: relative;
}
 
.header .flex .logo{
   font-size: 2.5rem;
   color:var(--black);
   font-weight: 600;
}
.header .flex .icons .login-btn{
   border: none;
   outline: none;
   color: var(--yellow);
   font-size: 1.7rem;
   font-weight: 600;
   padding: 10px 19px;
   border-radius: 3px;
   cursor: pointer;
   background-color: var(--black);
}
.header .flex .navbar a{
   font-size: 2rem;
   color:var(--black);
   margin:0 1rem;
}
 
.header .flex .navbar a:hover{
   color: var(--orange);
   text-decoration: underline;
}

.header .flex .icons > *{
   margin-left: 1.5rem;
   font-size: 2.5rem;
   color:var(--black);
   cursor: pointer;
}
 
.header .flex .icons> *:hover{
   color: var(--orange);
}

 

.header .flex .icons span{
   font-size: 2rem;
}
 
#menu-btn{
   display: none;
}
 
.header .flex .profile{
   background-color: var(--white);
   border:var(--border);
   padding:1.5rem;
   text-align: center;
   position: absolute;
   top:125%; right:2rem;
   width: 30rem;
   display: none;
   animation: fadeIn .2s linear;
}
 
.header .flex .profile.active{
   display: inline-block;
}
 
@keyframes fadeIn {
   0%{
      transform: translateY(1rem);
   }
}
 
.header .flex .profile .name{
   font-size: 2rem;
   color:var(--black);
   margin-bottom: .5rem;
}
 
.header .flex .profile .account{
   margin-top: 1.5rem;
   font-size: 2rem;
   color:var(--light-color);
}
 
.header .flex .profile .account a{
   color:var(--black);
}
 
.header .flex .profile .account a:hover{
   color: var(--orange);
}


/* SLIDER STYLE AND RESPONSIVENESS */
.hero .slide{
   display: flex;
   align-items: center;
   flex-wrap: wrap-reverse;
   gap:2rem;
   margin-bottom: 4rem;
}
 
.hero .slide .image{
   flex:1 1 40rem;
}
 
.hero .slide .image img{
   width: 100%;
}
 
.hero .slide .content{
   flex:1 1 40rem;
   text-align: center;
}
 
.hero .slide .content span{
   font-size: 2.5rem;
   color:var(--light-color);
}
 
.hero .slide .content h3{
   margin:1rem 0;
   font-size: 6rem;
   color:var(--black);
   text-transform: capitalize;
}
 
.swiper-pagination-bullet-active{
   background-color: var(--yellow);
}

.btn:hover{
   background-color: var(--orange);
}

.swiper-button-next{
   color: var(--yellow);
}
.swiper-button-next:hover{
   color: var(--orange);
}
.swiper-button-prev{
   color: var(--yellow);
}
.swiper-button-prev:hover{
   color: var(--orange);
}

/* END OF SLIDER STYLE AND RESPONSIVENESS */


.checkout form{
   max-width: 50rem;
   margin:0 auto;
   border:var(--border);
   padding:2rem;
}

.checkout form h3{
   font-size: 2.5rem;
   text-transform: capitalize;
   padding: 2rem 0;
   color:var(--black);
}

.checkout form .cart-items{
   background-color: var(--black);
   padding:2rem;
   padding-top: 0;
}

.checkout form .cart-items h3{
   color:var(--white);
}

.checkout form .cart-items p{
   display: flex;
   align-items: center;
   gap:1.5rem;
   justify-content: space-between;
   margin:1rem 0;
   line-height: 1.5;
   font-size: 2rem;
}

.checkout form .cart-items p .name{
   color:var(--light-color);
}

.checkout form .cart-items p .price{
   color:var(--yellow);
}

.checkout form .cart-items .grand-total{
   background-color: var(--white);
   padding:.5rem 1.5rem;
}

.checkout form .cart-items .grand-total .price{
   color:var(--red);
}

.checkout form .user-info p{ 
   font-size: 2rem;
   line-height: 1.5;
   padding:1rem 0;
}

.checkout form .user-info p i{
   color:var(--light-color);
   margin-right: 1rem;
}

.checkout form .user-info p span{
   color:var(--black);
}

.checkout form .user-info .box{
   width: 100%;
   border:var(--border);
   padding:1.4rem;
   margin-top: 2rem;
   margin-bottom: 1rem;
   font-size: 1.8rem;
}

.orders .box-container{
   display: flex;
   flex-wrap: wrap;
   gap:1.5rem;
   align-items: flex-start;
}

/* CATEGORY STYLE AND RESPONSIVENESS */
.category .title {
   text-align: center;
   margin-bottom: 1.5rem;
   font-family: 'Poppins', sans-serif;
}

.category .box-container {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
   gap: 20px;
   padding: 0 20px;
}

.category .box-container .box {
   background: #fff;
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   text-align: center;
   text-decoration: none;
   transition: transform 0.3s ease, box-shadow 0.3s ease;
   padding: 20px;
   display: flex;
   flex-direction: column;
   align-items: center;
}

.category .box-container .box:hover {
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

.category .box-container .box img {
   width: 100px;
   height: 100px;
   object-fit: contain;
   margin-bottom: 10px;
}

.category .box-container .box h3 {
   font-size: 1.2rem;
   color: #333;
   font-weight: 600;
}

.box {
   background: #fff;
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   text-align: center;
   text-decoration: none;
   transition: transform 0.3s ease, box-shadow 0.3s ease;
   padding: 20px;
   display: flex;
   flex-direction: column;
   align-items: center;
}

.box:hover {
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}



/* END OF CATEGORY STYLE AND RESPONSIVENESS */

/*MENU*/
.products .box-container{
   display: flex;
   flex-wrap: wrap;
   justify-content: left;
   gap: 25px;
   padding: 10px;
}

.products .box-container .box{
   flex: 0 0 calc(25% - 20px); /* 4 cards per row */
   background: #fff;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   overflow: hidden;
   font-family: 'Poppins', sans-serif;
   transition: transform 0.3s ease;
   box-sizing: border-box;
}
.products .box-container .box:hover{
   transform: scale(1.03);
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

.products .box-container .box img{
   width: 100%;
   height: 100%;
   border-radius: 10px 50px 80px 100px;
   object-fit: contain;
}

.products .box-container .box .fa-eye,
.products .box-container .box .fa-shopping-cart{
   position: absolute;
   top:1rem;
   height: 4.5rem;
   width: 4.5rem;
   line-height: 4.3rem;
   border:var(--border);
   background-color: var(--white);
   cursor: pointer;
   font-size: 2rem;
   color:var(--black);
   transition: .2s linear;
   text-align: center;
}

.products .box-container .box .fa-eye:hover,
.products .box-container .box .fa-shopping-cart:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

.products .box-container .box .fa-eye{
   left: -10rem;
}

.products .box-container .box .fa-shopping-cart{
   right: -10rem;
}

.products .box-container .box:hover .fa-eye{
   left: 1rem;
}

.products .box-container .box:hover .fa-shopping-cart{
   right: 1rem;
}

.products .box-container .box .cat{
   font-size: 1.5rem;
   font-weight: 600;
   margin-top: 0.5rem;
   text-decoration: capitalize;
   color:var(--light-color);

}




.products .box-container .box .name{
   font-size: 1.5rem;
   font-weight: 600;
   margin-top: 0.5rem;
   text-align: left;
   color: #333;
}

.products .box-container .box .flex{
   display: flex;
   align-items: center;
   gap:1rem;
   margin-top: 1.5rem;
}

.products .box-container .box .flex .price{
   margin-right: auto;
   font-size: 2rem;
   font-weight: bold;
   color: #e74c3c;

}

.products .box-container .box .flex .price span{
   color:var(--light-color);
   font-size: 1.8rem;
}

.products .box-container .box .flex .qty{
   padding:1rem;
   border:var(--border);
   font-size: 1.8rem;
   color:var(--black);
}

.products .box-container .box .flex .fa-edit{
   width: 5rem;
   background-color: var(--yellow);
   color:var(--black);
   cursor: pointer;
   font-size: 1.8rem;
   height: 4.5rem;
   border:var(--border);
}

.products .box-container .box .flex .fa-edit:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

.products .box-container .box .fa-times{
   position: absolute;
   top:1rem; right:1rem;
   background-color: var(--red);
   color:var(--white);
   border:var(--border);
   line-height:4rem;
   height: 4.3rem;
   width: 4.5rem;
   cursor: pointer;
   font-size: 2rem;
}

.products .box-container .box .fa-times:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

.products .box-container .box .sub-total{
   margin-top: 1rem;
   font-size: 1.8rem;
   color:var(--light-color);
}

.products .box-container .box .sub-total span{
   color:var(--red);
}

.products .more-btn{
   margin-top: 1rem;
   text-align: center;
}
.products .more-btnimg{
   height: 30px;
   width: 30px;
   margin-top: 1rem;
   text-align: center;
}

.products .cart-total{
   display: flex;
   align-items: center;
   gap:1.5rem;
   flex-wrap: wrap;
   justify-content: space-between;
   margin-top: 3rem;
   border:var(--border);
   padding:1rem;
}

.products .cart-total p{
   font-size: 2.5rem;
   color:var(--light-color);
}

.products .cart-total p span{
   color:var(--red);
}

.products .cart-total .btn {
   
   margin-top: 0;
}

.btn{
    margin-top: 1rem;
    display: inline-block;
    font-size: 2rem;
    padding:1rem 3rem;
    cursor: pointer;
    text-transform: capitalize;
    transition: .2s linear;
    align-items: right;
}
.profile-btn{
   display: block;
   margin-top: 1rem;
   border-radius: .5rem;
   cursor: pointer;
   width: 100%;
   font-size: 1.8rem;
   color:var(--box-shadow);
   padding:1.2rem 3rem;
   text-transform: capitalize;
   text-align: center;
   background-color:#fed330;
}
.profile-btn:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(21, 24, 22, 0.384);
}
 
.btn{
   margin-right: 10px;
   background-color: var(--yellow);
   color:var(--black);
}
.delete-btn{
   background-color: transparent;
   margin-top: 0;
   margin-bottom: 0;
   margin-left: 0;
   margin-right: 0;
   padding-top: 0;
   padding-bottom: 0;
   padding-right: 0;
   padding-left: 0;
   cursor: pointer;
}
.delete-btn img{
   margin-top: 0;
   margin-bottom: 0;
   margin-left: 0;
   margin-right: 0;
   padding-top: 0;
   padding-bottom: 0;
   padding-right: 0;
   padding-left: 0;
   background-color: transparent;
   height: 60px;
   width: 60px;
}
 
.btn:hover,
.delete-btn:hover{
   letter-spacing: .2rem;
}

/* END OF CATEGORY STYLE AND RESPONSIVENESS */

/* RESPONSIVE BREAKPOINTS */
 
/* 3 per row */
@media (max-width: 1200px) {
   .products .box-container .box  {
     flex: 0 0 calc(33.33% - 20px);
   }
   
}
 
/* 2 per row */
@media (max-width: 800px) {
   .products .box-container .box  {
     flex: 0 0 calc(50% - 20px);
   }
}
 
/* 1 per row */
@media (max-width: 500px) {
   .products .box-container .box  {
     flex: 0 0 100%;
   }
}
 


@keyframes pop {
   0% { transform: scale(1); }
   50% { transform: scale(1.1); }
   100% { transform: scale(1); }
}


/* END OF PRODUCT CARD STYLE AND RESPONSIVENESS */


/* CART STYLE AND RESPONSIVENESS */

.cart{
   position: fixed;
   top: 0;
   right: -100%;
   width: 360px;
   height: 100%;
   background: #fff;
   box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
   padding: 65px 20px 40px;
   z-index: 100;
   overflow: auto;
   transition: 0.5s;
}
.cart.active{
   right: 0;
}
.cart-title{
   text-align: center;
   font-size: 30px;
}

.cart-box{
   display: flex;
   align-items: center;
   margin-top: 20px;
}

.cart-box img{
   width: 100px;
   height: 100px;
   border-radius: 6px;
   object-fit: cover;
   margin-right: 20px;
}

.cart-detail{
   display: grid;
   gap: 8px;
   margin-right: auto;
}
.cart-product-title{
   font-size: 16px;
   line-height: 1;
}
.cart-price{
   font-weight: 500;
   font-size: 16px;
}

.cart-quantity{
   display: flex;
   width: 100px;
   border: 1px solid #999;
   border-radius: 6px;
}
.cart-quantity button{
   background: transparent;
   width: 30px;
   border: none;
   font-size: 20px;
   cursor: pointer;
}
.cart-quantity #decrement{
   color: #999;
}
.cart-quantity .number{
   display: flex;
   justify-content: center;
   align-items: center;
   width: 40px;
   border-left: 1px solid #999;
   border-right: 1px solid #999;
   cursor: default;
   font-size: 17px;
}
.ri-delete-bin-5-fill{
   height: 37px;
   font-size: 18px;
   cursor: pointer;
}
.cart-remove{
   font-size: 25px;
   cursor: pointer;
}
.total{
   display: flex;
   justify-content: flex-end;
   align-items: center;
   border-top: 1px solid #333;
   margin-top: 20px;
   font-size: 18px;
}
.total-price{
   margin-left: 10px;
   font-weight: 600;
} 
.btn-buy{
   display: block;
   padding: 10px 30px;
   background: var(--orange);
   border: none;
   border-radius: 6px;
   font-size: 16px;
   color: var(--white);
   margin: 20px auto 0;
   cursor: pointer;
}

.btn-buy:hover{
   background:var(--yellow) ;
   color: var(--black);
}

#cart-close{
   position: absolute;
   top: 20px;
   right: 15px;
   font-size: 35px;
   cursor: pointer;
}
.cart h2{
   font-size: 2.5rem;
   color:var(--orange);
   text-transform: capitalize;
   text-align: center;
}
.cart h2:hover{
   color: var(--yellow);
}

/*cart item count*/
.icons .cart-item-count{
   position: absolute;
   top: 28px;
   right: 42px;
   width: 25px;
   height: 25px;
   background: var(--red);
   border-radius: 50%;
   font-size: 12px;
   color:var(--white);
   display: flex;
   justify-content: center;
   align-items: center;
   visibility: hidden;
}

.add-to-cart-btn.clicked {
   animation: pop 0.3s ease;
}

/*USER BUTTON*/
.icons #user-btn {
   position: relative;
   cursor: pointer;
}
 
.user-dropdown {
   display: none;
   position: absolute;
   top: 120%;
   right: 0;
   background: white;
   border: 1px solid #ccc;
   box-shadow: 0 4px 8px rgba(0,0,0,0.1);
   border-radius: 0.5rem;
   min-width: 180px;
   z-index: 1000;
}
 
.user-dropdown.show {
   display: block;
}
 
.user-dropdown a {
   display: block;
   padding: 10px;
   text-decoration: none;
   color: #333;
}
 
.user-dropdown a:hover {
   background-color: #f0f0f0;
}
 

/*FOOTER*/
.footer{
   padding-top: 60px;
}
.footer .grid{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
   gap: 10px;
   padding: 20px;
}

.footer .grid .box{
   background: #fff;
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   text-align: center;
   text-decoration: none;
   transition: transform 0.3s ease, box-shadow 0.3s ease;
   padding: 20px;
   display: flex;
   flex-direction: column;
   align-items: center;
}

.footer .grid .box img{
   height: 10rem;
   width: 100%;
   object-fit: contain;
   margin-bottom: .5rem;
}

.footer .grid .box:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

.footer .grid .box h3{
   margin:1rem 0;
   font-size: 2rem;
   color:var(--black);
   text-transform: capitalize;
}

.footer .grid .box p,
.footer .grid .box a{
   display: block;
   font-size: 1.7rem;
   color:var(--light-color);
   line-height: 1.8;
}

.credit{
   padding:3rem 2rem;
   text-align: center;
   background-color: var(--black);
   color:var(--white);
   font-size: 2rem;
   text-transform: capitalize;
   /* padding-bottom: 10rem; */
}

.credit span{
   color:var(--yellow);
}

.loader{
   position: fixed;
   top:0; left:0; right:0; bottom: 0;
   z-index: 1000000;
   background-color: var(--white);
   display: flex;
   align-items: center;
   justify-content: center;
}

.loader img{
   height: 25rem;
}
 
 /* Responsive */
@media (max-width: 768px) {
   .footer-container {
     flex-direction: column;
     text-align: center;
   }
 
   .social-icons {
     justify-content: center;
   }
}



/*LOGIN MODAL AND REGISTER MODAL*/
/* Modal Styles - matching your original structure */

/*POP UP PROMO*/
/* Modal Styles */
.popup-overlay {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: rgba(0, 0, 0, 0.7);
   display: none; /* Hidden by default */
   justify-content: center;
   align-items: center;
   z-index: 1000;
   backdrop-filter: blur(5px);
   opacity: 0;
   transition: opacity 0.3s ease;
}

.popup-overlay.show {
   display: flex !important;
   opacity: 1;
}

.popup-card {
   background: white;
   border-radius: 20px;
   width: 90%;
   max-width: 400px;
   box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
   transform: scale(0.7) translateY(50px);
   transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
   overflow: hidden;
}

.popup-overlay.show .popup-card {
   transform: scale(1) translateY(0);
}

.popup-header {
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   color: white;
   padding: 30px;
   text-align: center;
   position: relative;
}

.close-btn {
   position: absolute;
   top: 15px;
   right: 20px;
   background: none;
   border: none;
   color: white;
   font-size: 30px;
   cursor: pointer;
   padding: 5px;
   border-radius: 50%;
   width: 40px;
   height: 40px;
   display: flex;
   align-items: center;
   justify-content: center;
   transition: all 0.3s ease;
}

.close-btn:hover {
   background: rgba(255, 255, 255, 0.2);
   transform: rotate(90deg);
}

.restaurant-name {
   font-size: 2rem;
   margin-bottom: 10px;
   font-weight: bold;
}

.tagline {
   opacity: 0.9;
   font-size: 1rem;
}

.popup-content {
   padding: 40px;
}

.popup-content form {
   display: flex;
   flex-direction: column;
   gap: 20px;
}

.popup-content input[type="text"],
.popup-content input[type="email"],
.popup-content input[type="password"] {
   padding: 15px;
   border: 2px solid #e0e0e0;
   border-radius: 10px;
   font-size: 1rem;
   transition: all 0.3s ease;
   outline: none;
}

.popup-content input:focus {
   border-color: #667eea;
   box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
   transform: translateY(-2px);
}

.checkbox-container {
   display: flex;
   align-items: center;
   gap: 10px;
   font-size: 0.9rem;
   color: #666;
}

.checkbox-container input[type="checkbox"] {
   width: 18px;
   height: 18px;
   accent-color: #667eea;
}

.cta-button {
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   color: white;
   border: none;
   padding: 15px;
   border-radius: 10px;
   font-size: 1.1rem;
   font-weight: bold;
   cursor: pointer;
   transition: all 0.3s ease;
   margin-top: 10px;
}

.cta-button:hover {
   transform: translateY(-2px);
   box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.popup-footer {
   background: #f8f9fa;
   padding: 25px 40px;
   text-align: center;
}

.terms {
   color: #666;
   font-size: 0.9rem;
}

.link-btn {
   background: none;
   border: none;
   color: #667eea;
   cursor: pointer;
   font-weight: bold;
   text-decoration: underline;
   transition: all 0.3s ease;
   padding: 2px 4px;
   border-radius: 4px;
}

.link-btn:hover {
   color: #764ba2;
   background: rgba(102, 126, 234, 0.1);
   text-decoration: none;
}

/* Responsive */
@media (max-width: 480px) {
   .popup-card {
       width: 95%;
       margin: 10px;
   }
   
   .popup-content {
       padding: 30px 25px;
   }
   
   .popup-header {
       padding: 25px;
   }
   
   .restaurant-name {
       font-size: 1.5rem;
   }
}
 
/* Popup Overlay */
.popup-overlay {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: rgba(0, 0, 0, 0.8);
   display: none;
   opacity: 0;
   transition: opacity 0.3s ease;
   align-items: center;
   justify-content: center;
   z-index: 1000;
   animation: fadeIn 0.3s ease-out;
}
.popup-overlay.show{
   display: flex;
   opacity: 1;
}
.popup-overlay.closing {
   animation: fadeOut 0.3s ease-out forwards;
}

/* Popup Card */

.popup-card {
   background: linear-gradient(145deg, #ffffff, #f8f9fa);
   border-radius: 20px;
   box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
   max-width: 450px;
   width: 100%;
   position: relative;
   overflow: hidden;
   transform: scale(0.9);
   animation: popIn 0.4s ease-out 0.1s forwards;
}

.popup-card.closing {
   animation: popOut 0.3s ease-in forwards;
}

/* Header Section */
.popup-header {
   background: linear-gradient(135deg, var(--yellow), var(--orange));
   padding: 30px 25px 20px;
   text-align: center;
   position: sticky;
   overflow: hidden;
}

.popup-header::before {
   content: '';
   position: absolute;
   top: -50%;
   left: -50%;
   width: 200%;
   height: 200%;
   background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
   animation: shimmer 3s ease-in-out infinite;
}

.close-btn {
   position: absolute;
   top: 15px;
   right: 20px;
   background: rgba(255, 255, 255, 0.2);
   border: none;
   width: 35px;
   height: 35px;
   border-radius: 50%;
   color: white;
   font-size: 18px;
   cursor: pointer;
   display: flex;
   align-items: center;
   justify-content: center;
   transition: all 0.3s ease;
   z-index: 10;
}

.close-btn:hover {
   background: rgba(255, 255, 255, 0.3);
   transform: rotate(90deg);
}

.restaurant-name {
   color: white;
   font-size: 28px;
   font-weight: bold;
   margin-bottom: 8px;
   text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
   z-index: 5;
   position: relative;
}

.tagline {
   color: rgba(255, 255, 255, 0.95);
   font-size: 16px;
   margin-bottom: 0;
   z-index: 5;
   position: relative;
}

/* Content Section */
.popup-content {
   padding: 30px 25px;
   text-align: center;
}

.promo-badge {
   background: linear-gradient(135deg, var(--yellow), var(--orange));
   color: white;
   padding: 8px 20px;
   border-radius: 25px;
   font-weight: bold;
   font-size: 14px;
   display: inline-block;
   margin-bottom: 20px;
   box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
   animation: bounce 2s ease-in-out infinite;
}
.promo-badge:hover{
   background: linear-gradient(135deg, var(--orange), var(--yellow));
}

.offer-title {
   font-size: 24px;
   font-weight: bold;
   color: #2c3e50;
   margin-bottom: 15px;
   line-height: 1.3;
}

.offer-description {
   color: #7f8c8d;
   font-size: 16px;
   line-height: 1.6;
   margin-bottom: 25px;
}

.highlight {
   color: #ff6b6b;
   font-weight: bold;
}

/* CTA Button */
.cta-button {
   background: linear-gradient(135deg, var(--yellow), var(--orange));
   color: white;
   border: none;
   padding: 15px 40px;
   border-radius: 50px;
   font-size: 16px;
   font-weight: bold;
   cursor: pointer;
   transition: all 0.3s ease;
   box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
   text-transform: uppercase;
   letter-spacing: 1px;
   position: relative;
   overflow: hidden;
}

.cta-button::before {
   content: '';
   position: absolute;
   top: 0;
   left: -100%;
   width: 100%;
   height: 100%;
   background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
   transition: left 0.5s ease;
}

.cta-button:hover {
   transform: translateY(-2px);
   box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
}

.cta-button:hover::before {
   left: 100%;
}

.cta-button:active {
   transform: translateY(0);
}

/* Footer */
.popup-footer {
   padding: 0 25px 25px;
   text-align: center;
}

.terms {
   font-size: 12px;
   color: #95a5a6;
   line-height: 1.4;
}

/* Animations */
@keyframes fadeIn {
   from { opacity: 0; }
   to { opacity: 1; }
}

@keyframes fadeOut {
   from { opacity: 1; }
   to { opacity: 0; }
}

@keyframes popIn {
   from {
       transform: scale(0.9);
       opacity: 0;
   }
   to {
       transform: scale(1);
       opacity: 1;
   }
}

@keyframes popOut {
   from {
       transform: scale(1);
       opacity: 1;
   }
   to {
       transform: scale(0.8);
       opacity: 0;
   }
}

@keyframes bounce {
   0%, 20%, 50%, 80%, 100% {
       transform: translateY(0);
   }
   40% {
       transform: translateY(-5px);
   }
   60% {
       transform: translateY(-3px);
   }
}

@keyframes shimmer {
   0% { transform: rotate(0deg); }
   100% { transform: rotate(360deg); }
}


/* Mobile Responsiveness */
@media (max-width: 480px) {
   .popup-card {
       margin: 20px;
       max-width: calc(100% - 40px);
   }

   .restaurant-name {
       font-size: 24px;
   }

   .offer-title {
       font-size: 20px;
   }

   .popup-content {
       padding: 25px 20px;
   }

   .popup-header {
       padding: 25px 20px 15px;
   }
}

/* Demo background for showcase */
.demo-background {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   
   z-index: -1;
}
 
/*PROFILE POP UP*/
.profile {
  position: absolute;
  top: 70px;
  right: 10px;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: .5rem;
  width: 1rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  display: none;
  z-index: 999;
}

.profile.active {
  display: block;
}

.profile .name {
  font-weight: bold;
  margin-bottom: 1.5rem;
}

.profile .flex {
  display: flex;
  justify-content: space-between;
  gap: 0.5rem;
  margin: 1rem 0;
}

.profile .btn {
  background-color: #ff7200;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  cursor: pointer;
}

.profile .delete-btn {
  background-color: #c0392b;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  cursor: pointer;
}

.profile #guestView .account {
  font-size: 1.7rem;
  color: var(--black);
}
.profile #guestView .account a {
   font-size: 1.6rem;
   color: var(--orange);
}
.profile #guestView .account a:hover {
   font-size: 1.6rem;
   color: var(--black);
}

.profile .info {
   font-size: 0.9rem;
   margin: 1rem 0;
   color: #333;
}
 
.profile .info p {
   margin: 0.3rem 0;
}
 
.profile .btn.small {
   padding: 0.3rem 0.6rem;
   font-size: 0.85rem;
}
/*MODAL*/
.modal {
   display: none;
   position: fixed;
   z-index: 999;
   left: 0; top: 0;
   width: 100%; height: 100%;
   background-color: rgba(0, 0, 0, 0.4);
}
.modal-content {
   background: white;
   margin: 10% auto;
   padding: 2em;
   width: 90%; max-width: 400px;
   border-radius: 10px;
   position: relative;
}
.close {
   position: absolute;
   top: 10px; right: 20px;
   font-size: 24px;
   cursor: pointer;
}
 
 
/* media queries  */
@media (max-width:992px) {
   html{
      font-size: 55%;
   }
   .img-logo{
      height: 70px;
      width: 90px;
   }
   .icons .cart-item-count{
      position: absolute;
      top: 25px;
      right: 42px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
   }
   body{
      margin-top: 110px;
   }
}
@media (min-width:992px) {
   .icons .cart-item-count{
      position: absolute;
      top: 21px;
      right: 45px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
   }
   body{
      margin-top: 125px;
   }
}

@media (max-width:913px) {
   .icons .cart-item-count{
      position: absolute;
      top: 17px;
      right: 42px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
   }
   body{
      margin-top: 105px;
   }
}


 
@media (max-width:768px){
 
   #menu-btn{
      display: inline-block;
   }
 
    .header .flex .navbar{
       position: absolute;
       top:99%; left: 0; right: 0;
       border-top: var(--border);
       border-bottom: var(--border);
       background-color: var(--white);
       transition: .2s linear;
       clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
    }
 
    .header .flex .navbar a{
       display: block;
       margin:2rem;
    }
 
    .header .flex .navbar.active{
       clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    }
    .img-logo{
        height: 50px;
        width: 80px;
    }
    .icons .cart-item-count{
      position: absolute;
      top: 17px;
      right: 78px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
   }
   body{
      margin-top: 85px;
   }
}
 
@media (max-width:450px) {
    
   html{
       font-size: 50%;
    }
 
    .title{
       font-size: 3rem;
    }
 
    .header .flex .logo{
       font-size: 2rem;
    }
 
    .hero .slide .content h3{
       font-size: 5rem;
    }
 
    .products.box-container{
       grid-template-columns: 1fr;
    }
 
    .heading h3{
       font-size: 3.5rem;
    }
 
    .products .cart-total{
       padding:1.5rem;
       justify-content: center;
    }
 
    .flex-btn{
       flex-flow: column;
       gap:0;
    }   
    .img-logo{
        height: 40px;
        width: 60px;
    }
    .icons .cart-item-count{
      position: absolute;
      top: 10px;
      right: 70px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
   }
   body{
      margin-top: 70px;
   }
}


</style>

<body>
<header class="header">
   <section class="flex">
      <img src="images/logo2.png" class="img-logo" > 
      <a href="home.php" class="logo">Amazing Silog Restobar</a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="menu.php">Menu</a>
         <a href="orders.php">Orders</a>
         <a href="contact.php">Feedback</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="profile-btn">Profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         
            
        
         <?php
            }else{
         ?>
            <p class="name">Please Login First!</p>
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
          
         <?php
          }
         ?>
      </div>

   </section>
</header>
</body>
</html>
