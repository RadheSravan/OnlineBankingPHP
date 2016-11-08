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
               <a href="#" class="active_link">Login</a>
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
   <div class="container">
      <div class="row">
         <div class="col-lg-4 col-md-4 col-sm-3 col-xs-1"></div>
         <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
            <form id = "loginform" onsubmit="return validateForm()" method = "post"action="login.php">
               <label for="username">Username</label>
               <input type="text" id="username" name="username" autocomplete="off">
               <label for="password">Password</label>
               <input type="password" id="password" name="password" autocomplete="off">
               <a>Forgot password?</a>
               <input type="submit" value="Login">
               <?php
                  error_reporting( error_reporting() & ~E_NOTICE );
                  
                  $submit = $_POST;
                  
                  $user_name = $_POST["username"];
                  $password  = $_POST["password"];
                  
                  $service_url    = 'http://localhost/OnlineBankingPHP/REST/v1/login';
                  $curl           = curl_init($service_url);
                  $curl_post_data = array(
                  'user_name' => $user_name,
                  'password'  => $password
                  );
                  
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($curl, CURLOPT_POST, true);
                  curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
                  
                  $curl_response = curl_exec($curl);
                  $http_status   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                  
                  if ($curl_response === false) {
                     $info = curl_getinfo($curl);
                     curl_close($curl);
                     die('Error occured during curl execution. Additioanl info: ' . var_export($info));
                  }
                  
                  curl_close($curl);
                  
                  $decoded = json_decode($curl_response, true);
                  
                  if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                     die('Error occured: ' . $decoded->response->errormessage);
                  }
                  
                  if ($decoded['code'] != 200) {
                     echo "<div id = 'message' style='color:white;'>".$decoded['message']."</div>";
                  } 
                  else if ($decoded['code'] == 200 && $decoded['error']) {
                     echo "<div id = 'message' style='color:red;'>".$decoded['message']."</div>";
                  }
                  else {
                     session_start();
                     $_SESSION["last_login"] = date('l, jS F Y, h:i A', strtotime($decoded['last_login']));
                     $_SESSION["name"] = $decoded['first_name'].' '.$decoded['last_name'];
                     $_SESSION["api_key"] = $decoded['api_Key'];
                     header('Location: homepage.php');
                  }
                  
                  ?>
            </form>
         </div>
         <div class="col-lg-4 col-md-3 col-sm-3 col-xs-1"></div>
      </div>
   </div>
   <?php
      include 'footer.php';
      ?>
   <!-- jQuery (Bootstrap JS plugins depend on it) -->
   <script src="js/jquery-2.1.4.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/script.js"></script>
   <script>
      function validateForm(){
         var username = document.getElementById('username').value;
         var password = document.getElementById('password').value;
         var message = document.getElementById('message');
         if(isEmpty(username)){
            message.innerHTML = "Username cannot be empty<br><br>";
            message.style.color = '#f00';
            return false;
         }
         else if(isEmpty(password)){
            message.innerHTML = "Password cannot be empty<br><br>";
            message.style.color = '#f00';
            return false;
         }
         else {
            return true;
         }
      }
      function isEmpty(string) {
         return (!string || 0 === string.length);
      }
   </script>
</body>