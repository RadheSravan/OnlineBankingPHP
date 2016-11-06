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
                  <a href="login.html">Login</a>
               </li>
               <li>
                  <a href="branches.html">Branches</a>
               </li>
               <li>
                  <a href="faq.html">FAQ</a>
               </li>
            </ul>
         </div>
      </header>
      <div class="container">
         <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1"></div>
            <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">
               <div id="registration_title">Registration Form</div>
               <form id="registration_form">
                  <label for="first_name">First Name</label>
                  <input type="text" id="firstname" name="firstname" autocomplete="off">
                  <label for="last_name">Last Name</label>
                  <input type="text" id="lastname" name="lasttname" autocomplete="off">
                  <label for="email">Email Id</label>
                  <input type="text" id="email" name="email" autocomplete="off">
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" autocomplete="off">
                  <label for="password">Password</label>
                  <input type="password" id="password" name="password" autocomplete="off">
                  <label for="confirm_password">Confirm Password</label>
                  <input type="password" id="confirm_password" name="confirm_password" autocomplete="off">
                  <input type="submit" value="Register">
                  <div id = "message">
                     All the fields are mandatory.
                  </div>
               </form>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1"></div>
         </div>
      </div>
      <?php include 'footer.php'?>
      <!-- jQuery (Bootstrap JS plugins depend on it) -->
      <script src="js/jquery-2.1.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>