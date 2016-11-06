<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>The Bank of Gotham City</title>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/styles.css">
      <link rel="icon" href="images/favicon.ico" type="image/png">
      <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
      <link href="https://fonts.googleapis.com/css?family=Marck+Script" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Lobster+Two|Niconne|Tangerine" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400i" rel="stylesheet">
   </head>
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
                     <a href="branches.php">Branches</a>
                  </li>
                  <li>
                     <a href="#" class="active_link">FAQ</a>
                  </li>
               </ul>
            </div>
      </header>
      <div class="container faq_container">
      <div class = "row">
      <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs"></div>
      <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
      <div id="faq_heading"><img class="img-responsive text-center" src="images/faq.jpg"/></div>
      <div class= "question">1. What is Inter Bank Fund Transfer?</div>
      <div class= "answer"><u>Ans.</u> Inter Bank Transfer is a special service that allows you to transfer funds from your account to a bank account in any other bank.</div>
      <div class= "question"> 2. Can I transfer funds to an account in any bank branch through RTGS/NEFT?</div>
      <div class= "answer"> <u>Ans.</u> NEFT -The acronym "NEFT" stands for National Electronic Funds Transfer. Funds are transferred to the credit account with the other participating bank using NEFT service.<p>RTGS -The acronym "RTGS" stands for Real Time Gross Settlement. The RTGS system facilitates transfer of funds from accounts in one bank to another on a "real time". The RTGS system is the fastest possible interbank money transfer facility available through secure banking channels. The fund transfer through RTGS/NEFT can be done ONLY to any RTGS/NEFT enabled bank branch.</p></div>
      <div class= "question">3. Are there any charges levied for online Interbank Fund Transfer through RTGS/NEFT?</div>
      <div class= "answer"><u>Ans.</u> Currently, there are NO CHARGES for Online Interbank Fund Transfer through RTGS/NEFT.</div>
      <div class= "question">4. What is the mandatory information required for doing an Online Interbank Fund Transfer through RTGS/NEFT?</div>
      <div class= "answer"><u>Ans.</u> The following information about the beneficiary is mandatory - beneficiary name, address, account number, account type (only in case of NEFT) IFSC code of the beneficiary's bank branch.</div>
      <div class= "question">5. What are the timings for doing the online transactions?</div>
      <div class= "answer"><u>Ans.</u> NEFT transactions can be done any time, however, credits to the beneficiary account shall be on same day/immediate next working day depending on the time of payment and beneficiary bank. Currently, the RTGS timings on any given working day is as under - Week Days 09:15 AM - 03:45 AM Saturday 09:15 AM - 11:45 AM</div>
      <div class= "question">6. Where do I find IFSC Code?</div>
      <div class= "answer"><u>Ans.</u> IFSC Code can be found on Internet Banking Site, during the addition of beneficiary based on the beneficiary's bank.</div>
      <div class= "question">7. What happens to the transaction, if the beneficiary details provided are incorrect?</div>
      <div class= "answer"><u>Ans.</u> Bank does not verify the beneficiary details provided for outward NEFT transaction, and its fate entirely depends upon the beneficiary bank. If the beneficiary details provided matches at the beneficiary bank, the credit will be passed on, as per the details. But, in case the beneficiary bank rejects the transaction for any reason, the customer account will be credited.</div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-1 hidden-xs"></div></div>
      </div>
      </div>
      <?php include'footer.php' ?>
      <!-- jQuery (Bootstrap JS plugins depend on it) -->
      <script src="js/jquery-2.1.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>