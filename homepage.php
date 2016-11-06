<!doctype html>
<?php
   session_start();
?>
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
                  <a href="homepage.html" class="active_link">Home</a>
               </li>
               <li>
                  <a href="#">Change Password</a>
               </li>
               <li>
                  <a href="logout.php">Logout</a>
               </li>
            </ul>
         </div>
      </header>
      <div class="container">
         <div class="row">
            <div id = "home_links" class="col-lg-2 col-md-3 hidden-sm hidden-xs">
               <div>Links Go Here</div>
            </div>
            <div id="home_content" class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
               <div id="welcome_message">Welcome,  <?php
                  echo $_SESSION["name"];
                  ?></div>
               <div id="last_login">Last Login : <?php
                  echo $_SESSION["last_login"];
                  ?></div>
               <div id="account_summary">
                  <div id="account_summary_title">Account(s) Summary</div>
                  <div id="big_table_div" class="col-lg-10 col-md-9 col-sm-12 hidden-xs">
                     <table id="big_table" class="col-lg-10 col-md-9 col-sm-12 hidden-xs">
                        <theader>
                           <tr>
                              <th>Account Type</th>
                              <th>Number</th>
                              <th>Branch</th>
                              <th>Status</th>
                              <th>Balance</th>
                           </tr>
                        </theader>
                        <tbody>
                           <?php
                              $service_url = 'http://localhost/OnlineBankingPHP/REST/v1/accounts';
                              $api_key     = $_SESSION["api_key"];
                              $header      = 'Authorization : ' . $api_key;
                              $curl        = curl_init($service_url);

                              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                              curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                  $header
                              ));

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

                              $accounts = array();
                              $accounts = $decoded['accounts'];
                              
                              for ($i = 0; $i < sizeof($accounts); $i++) {
                                 echo "<tr>";
                                  print_r ('<td>'.$accounts[$i]['account_type'].'</td>');
                                  print_r ('<td>'.$accounts[$i]['account_number'].'</td>');
                                  print_r ('<td>'.$accounts[$i]['branch'].'</td>');
                                  print_r ('<td>'.$accounts[$i]['account_status'].'</td>');
                                  print_r ('<td>&#x20b9; '.$accounts[$i]['account_balance'].'</td>');
                                  echo "</tr>";
                              }
                              
                              ?>
                        </tbody>
                     </table>
                  </div>
                  <div id="small_table_div" >
                     <table id="small_table" class="hidden-lg hidden-md hidden-sm col-xs-12">
                        <?php
                           $service_url = 'http://localhost/OnlineBankingPHP/REST/v1/accounts';
                           $api_key     = $_SESSION["api_key"];
                           $header      = 'Authorization : ' . $api_key;
                           $curl        = curl_init($service_url);
                           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                           curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                               $header
                           ));

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

                           $accounts = array();
                           $accounts = $decoded['accounts'];
                           
                           for ($i = 0; $i < sizeof($accounts); $i++) {
                               echo "<tr>";
                               echo "<td>Account Type</td>";
                               print_r ('<td>'.$accounts[$i]['account_type'].'</td>');
                               echo "</tr>";
                               echo "<tr>";
                               echo "<td>Number</td>";
                               print_r ('<td>'.$accounts[$i]['account_number'].'</td>');
                               echo "</tr>";
                               echo "<tr>";
                               echo "<td>Branch</td>";
                               print_r ('<td>'.$accounts[$i]['branch'].'</td>');
                               echo "</tr>";
                               echo "<tr>";
                               echo "<td>Status</td>";
                               print_r ('<td>'.$accounts[$i]['account_status'].'</td>');
                               echo "</tr>";
                               echo "<tr>";
                               echo "<td>Balance</td>";
                               print_r ('<td>&#x20b9; '.$accounts[$i]['account_balance'].'</td>');
                               echo "</tr>";
                               echo "<tr><td></td><td></td></tr>";
                           }
                           
                           ?>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php include'footer.php' ?>
      <!-- jQuery (Bootstrap JS plugins depend on it) -->
      <script src="js/jquery-2.1.4.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>