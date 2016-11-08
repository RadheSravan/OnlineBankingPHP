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
               <a href="./">Home</a>
            </li>
            <li>
               <a href="login.php">Login</a>
            </li>
            <li>
               <a href="#"  class="active_link">Branches</a>
            </li>
            <li>
               <a href="faq.php">FAQ</a>
            </li>
         </ul>
      </div>
   </header>
   <div class="container branches_container">
      <div class = "row">
         <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
         <div class = "col-lg-3 col-md-4 col-sm-5 hidden-xs">
            <img class = "bank_image img-responsive" src="images/iron bank.jpg">
            <div class="banking_hours">
               <p class="title">Banking Hours</p>
               <p>Mon-Thur : 8:00 AM to 3:30 PM</p>
               <p>Friday : 8:00 AM to 5:00 PM</p>
               <p>Saturday : 8:30 AM to Noon</p>
            </div>
         </div>
         <div class="col-lg-7 col-md-8 col-sm-7 hidden-xs">
            <div class ="bank_name"> The Iron Bank </div>
            <div class="bank_description">
               Our branch in New York city is also popularly known as "The Iron Bank", named after the legendary Iron Man. As Tony Stark's newest financial institution, the Iron Bank has a proud tradition of providing friendly, personalized service and convenient, full-service banking. Our experienced staff of banking professionals can answer your questions and help you make the most of your money. We offer an array of traditional banking services such as checking, savings, certificates of deposit, loan and individual retirement accounts plus, customer conveniences like 24-hour telephone banking and area network of surcharge-free automated teller machines. Our staff also includes a team of experienced mortgage, consumer, commercial and agricultural lenders who can offer you competitive interest rates, local loan decisions and on-site loan servicing.
            </div>
         </div>
         <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
      </div>
      <hr class="hidden-xs">
      <div class = "row">
         <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
         <div class = "col-lg-3 col-md-4 col-sm-5 hidden-xs">
            <img class = "bank_image img-responsive" src="images/webster_bank.jpg">
            <div class="banking_hours">
               <p class="title">Banking Hours</p>
               <p>Mon-Fri : 9:00 AM to 4:30 PM</p>
               <p>Saturday : 9:30 AM to 1:30 PM</p>
            </div>
         </div>
         <div class="col-lg-7 col-md-8 col-sm-7 hidden-xs">
            <div class ="bank_name"> Webster Bank </div>
            <div class="bank_description">
               As Spiderman's premium foundation, our branch in Boston known as the Webster Bank has been committed to helping individuals, families and businesses achieve their financial goals. In that mission, Webster’s 3,000 bankers are guided by our core values, namely, to take personal responsibility for meeting our customers’ needs; to respect the dignity of every individual; to earn trust through ethical behavior; to give of ourselves to our communities; and to work together to achieve outstanding results.
               Webster Bank provides consumer, business, government and institutional banking, as well as mortgage, financial planning, trust and investment services through Webster Private Bank. Webster has 294 ATMs and delivers superior customer service in person, on the phone, online, and through mobile devices.
            </div>
         </div>
         <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
      </div>
      <div class="row">
         <div class="bank_name hidden-lg hidden-md hidden-sm col-xs-12">The Iron Bank</div>
         <div class="hidden-lg hidden-md hidden-sm col-xs-6">
            <img class = "bank_image img-responsive" src="images/iron bank.jpg">
         </div>
         <div class="hidden-lg hidden-md hidden-sm col-xs-6">
            <div class="banking_hours">
               <p class="title">Banking Hours</p>
               <p>Mon-Thur : 8:00 AM to 3:30 PM</p>
               <p>Friday : 8:00 AM to 5:00 PM</p>
               <p>Saturday : 8:30 AM to Noon</p>
            </div>
         </div>
         <div class="bank_description hidden-lg hidden-md hidden-sm col-xs-12">
            Our branch in New York city is also popularly known as "The Iron Bank", named after the legendary Iron Man. As Tony Stark's newest financial institution, the Iron Bank has a proud tradition of providing friendly, personalized service and convenient, full-service banking. Our experienced staff of banking professionals can answer your questions and help you make the most of your money. We offer an array of traditional banking services such as checking, savings, certificates of deposit, loan and individual retirement accounts plus, customer conveniences like 24-hour telephone banking and area network of surcharge-free automated teller machines. Our staff also includes a team of experienced mortgage, consumer, commercial and agricultural lenders who can offer you competitive interest rates, local loan decisions and on-site loan servicing.
         </div>
      </div>
      <hr class="hidden-lg hidden-md hidden-sm">
      <div class="row">
         <div class="bank_name hidden-lg hidden-md hidden-sm col-xs-12">Webster Bank</div>
         <div class="hidden-lg hidden-md hidden-sm col-xs-6">
            <img class = "bank_image img-responsive" src="images/webster_bank.jpg">
         </div>
         <div class="hidden-lg hidden-md hidden-sm col-xs-6">
            <div class="banking_hours">
               <p class="title">Banking Hours</p>
               <p>Mon-Fri : 9:00 AM to 4:30 PM</p>
               <p>Saturday : 9:30 AM to 1:30 PM</p>
            </div>
         </div>
         <div class="bank_description hidden-lg hidden-md hidden-sm col-xs-12">
            As Spiderman's premium foundation, our branch in Boston known as the Webster Bank has been committed to helping individuals, families and businesses achieve their financial goals. In that mission, Webster’s 3,000 bankers are guided by our core values, namely, to take personal responsibility for meeting our customers’ needs; to respect the dignity of every individual; to earn trust through ethical behavior; to give of ourselves to our communities; and to work together to achieve outstanding results.
            Webster Bank provides consumer, business, government and institutional banking, as well as mortgage, financial planning, trust and investment services through Webster Private Bank. Webster has 294 ATMs and delivers superior customer service in person, on the phone, online, and through mobile devices.
         </div>
      </div>
   </div>
   <?php include'footer.php' ?>
   <!-- jQuery (Bootstrap JS plugins depend on it) -->
   <script src="js/jquery-2.1.4.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/script.js"></script>
</body>