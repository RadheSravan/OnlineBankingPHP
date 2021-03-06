<?php
   session_start();
   if(isset($_SESSION['api_key'])){
      header('Location: homepage.php');
   }
   include 'header.php'
?>
<body>
   <header>
      <nav id="header-nav" class="navbar navbar-default">
      <div class="container">
      <div class="navbar-header">
         <img id="logo-img" src="images/logo.png" width="200" height="100" style="float:left; margin:1em 1em;">
         <div class="navbar-brand">
            <h1>The Bank of Gotham City</h1>
            <p>....... A Silent Guardian</p>
         </div>
         <button id="navbarToggle" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav" aria-expanded="false">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         </button>
      </div>
      <div id="collapsable-nav" class="collapse navbar-collapse">
         <ul id="nav-list" class="nav navbar-nav navbar-right">
            <li>
               <a href="#" class="active_link">Home</a>
            </li>
            <li>
               <a href="login.php">Login</a>
            </li>
            <li>
               <a href="branches.php">Branches</a>
            </li>
            <li>
               <a href="faq.php">FAQ</a>
            </li>
         </ul>
      </div>
   </header>
   <div class = "container">
      <div class ="row">
         <div class = "col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="slideshow-container">
               <div class="slides">
                  <img src="images/img_1.jpg">
               </div>
               <div class="slides">
                  <img src="images/img_2.jpg" >
               </div>
               <div class="slides">
                  <img src="images/img_3.jpg">
               </div>
               <div class="slides">
                  <img src="images/img_4.jpg">
               </div>
               <div class="slides">
                  <img src="images/img_5.png">
               </div>
            </div>
         </div>
         <div id = "announcements" class = "col-lg-4 col-md-4 hidden-xs hidden-sm">
            <h1 id="announcements_heading"> Announcements </h1>
            <?php
               $service_url = 'http://localhost/OnlineBankingPHP/REST/v1/announcements';
               $curl        = curl_init($service_url);
               
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
               
               $curl_response = curl_exec($curl);
               
               if ($curl_response === false) {
                   $info = curl_getinfo($curl);
                   curl_close($curl);
                   die('error occured during curl exec. Additioanl info: ' . var_export($info));
               }
               
               curl_close($curl);
               
               $decoded = json_decode($curl_response, true);
               
               if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                   die('error occured: ' . $decoded->response->errormessage);
               }
               
               $announcements = array();
               $announcements = $decoded['announcements'];
               
               for ($i = 0; $i < sizeof($announcements); $i++) {
                   print_r ('<p>&bull; '.$announcements[$i]['announcement'].'</p>');
               }
               
               ?>
         </div>
         <div class = "hidden-lg hidden-md col-xs-12 col-sm-12">
            <div id="announcements_small_heading"> <a href="#announements_small_heading" onclick="show_hide('announcements_small')">Click here for Announcements </a></div>
            <a id="div_link" onclick="show_hide('announcements_small')">
               <div id="announcements_small" >
                  <?php
                     $service_url = 'http://localhost/OnlineBankingPHP/REST/v1/announcements';
                     $curl        = curl_init($service_url);
                     
                     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                     
                     $curl_response = curl_exec($curl);
                     
                     if ($curl_response === false) {
                         $info = curl_getinfo($curl);
                         curl_close($curl);
                         die('error occured during curl exec. Additioanl info: ' . var_export($info));
                     }
                     
                     curl_close($curl);
                     
                     $decoded = json_decode($curl_response, true);
                     
                     if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                         die('error occured: ' . $decoded->response->errormessage);
                     }
                     
                     $announcements = array();
                     $announcements = $decoded['announcements'];
                     
                     for ($i = 0; $i < sizeof($announcements); $i++) {
                         print_r ('<p>&bull; '.$announcements[$i]['announcement'].'</p>');
                     }
                     
                     ?>
               </div>
            </a>
         </div>
         <div id ="content" class = "col-lg-9 col-md-9 col-xs-12 col-sm-12">
            <a href="register.php">
               <h1 id="content_heading">Register For NetBanking Now!!</h1>
            </a>
            <p class="matter">Now monitor, transact and control your bank account online through our net banking service. You can do multiple things from the comforts of your home or office with our Internet Banking - a one stop solution for all your banking needs.You can now get all your accounts details, submit requests and undertake a wide range of transactions online. Our E-Banking service makes banking a lot more easy and effective.
            </p>
            <div id="features">Features <br class="visible-xs"> <span>(Click on a feature to expand/collapse)</span></div>
            <p class="matter_heading">  <a href="#features" onclick="show_hide('account_details')">Account Details</a></p>
            <p class="matter_desc" id="account_details">View your bank account details, account balance, download statements and more. Also view your Demat, Loan & Credit Card account details all in one place.</p>
            <p class="matter_heading"><a href="#features" onclick="show_hide('transfer_funds')">Fund Transfer</a></p>
            <p class="matter_desc" id="transfer_funds">Transfer fund to your own accounts,other Gotham Bank accounts seamlessly.</p>
            <p class="matter_heading"><a href="#features" onclick="show_hide('request_services')">Request Services</a></p>
            <p class="matter_desc" id="request_services">Give a request for Cheque book,Demand Draft,stop cheque payment, redemption of debit card loyalty points</p>
            <p class="matter_heading"><a href="#features" onclick="show_hide('investment_services')">Investment Services</a></p>
            <p class="matter_desc" id="investment_services">View your complete portfolio with the bank, create Fixed Deposit, Apply for IPO</p>
            <p class="matter_heading"><a href="#features" onclick="show_hide('value_added_services')">Value Added Services</a></p>
            <p class="matter_desc" id="value_added_services">Pay utility bills for more than 160 billers, recharge mobile, create Virtual Cards, pay any Visa Credit Card bills, register for E-Statement and SMS banking</p>
            <p class="matter">
               Register now for Gotham Bank's internet banking service to get started and avail for you multiple utility services, all in a matter of a click. Getting started with our internet banking is real easy. All you need to do is follow a few simple steps and you are good to go. Click <a href="register.php">here</a> for our registration process.
            </p>
            <p class="matter"> We at the B.O.G.C follow best-in-class online security practices in order to safeguard your information while you are banking online. We are constantly at task for preventing fraud and thereby making all your net banking transactions completely safe.</p>
         </div>
         <div id = "downloads" class = "col-lg-3 col-md-3 hidden-xs hidden-sm">
            <h1 id="downloads_heading"> Downloads </h1>
            <p><a href="downloads/New_Account.pdf" download="Account Opening Form">New Account form</a></p>
            <p><a href="downloads/ChequeBook_Request.pdf" download="Cheque Book Request Form">Cheque book request</a></p>
            <p>Loan Forms</p>
            <p><a href="downloads/home_loan_application_form.pdf" download="Home Loan Form">Home Loan</a></p>
            <p><a href="downloads/Car_Loan_Application_Form.pdf" download="Car Loan Form" >Car Loan</a></p>
            <p><a href="downloads/Education_Loan_Application_Form.pdf" download="Education Loan Form">Education Loan</a></p>
         </div>
      </div>
   </div>
   <?php include'footer.php' ?>
   <!-- jQuery (Bootstrap JS plugins depend on it) -->
   <script src="js/jquery-2.1.4.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/script.js"></script>
   <script>
      var slideIndex = 0;
      showSlides();
      
      function showSlides() {
      var i;
      var slides = document.getElementsByClassName("slides");
      for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
      }
      slideIndex++;
      if (slideIndex> slides.length) {slideIndex = 1} 
      slides[slideIndex-1].style.display = "block"; 
      setTimeout(showSlides, 5000);
      }
   </script>
   <script>
      function show_hide(id) {
            if(document.getElementById(id).style.display =='none'){
               document.getElementById(id).style.display ='block';
               }
            else{
               document.getElementById(id).style.display ='none';
            }
          }
   </script>
   <script>
      document.getElementById('announcements_small').style.display ='none';
      document.getElementById('account_details').style.display ='none';
      document.getElementById('transfer_funds').style.display ='none';
      document.getElementById('request_services').style.display ='none';
      document.getElementById('investment_services').style.display ='none';
      document.getElementById('value_added_services').style.display ='none';
   </script>
</body>