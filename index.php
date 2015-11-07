<?php
$auth_user = "your_username";
$auth_pass = "your_password";

//Auth required
if (!isset($_SERVER['PHP_AUTH_USER']) || !($_SERVER['PHP_AUTH_USER'] == $auth_user && $_SERVER['PHP_AUTH_PW'] == $auth_pass)) {
  header('WWW-Authenticate: Basic realm="Botin !party -hallinta"');
  header('HTTP/1.0 401 Unauthorized');
  echo 'imases...';
  die;
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="Botparty">
  <meta name="author" content="T-101">
  <link rel="icon" href="favicon.ico">

  <title>Botparty v1.9</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap theme -->
  <link href="css/bootstrap-theme.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/jquery-ui.min.css" rel="stylesheet">
  <link href="css/theme.css" rel="stylesheet">
  <link href="css/botparty.css" rel="stylesheet">

  <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
  <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  <script src="js/ie-emulation-modes-warning.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body role="document">

      <!-- Fixed navbar -->
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Botparty</a>
          </div>
        </div>
      </nav>

      <div class="container theme-showcase" role="main">
       <div class="col-md-8" id="partyList">
         <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="text-title">
              Upcoming parties <a class="btn btn-success addParty-btn" id="addPartyLink">+ Add party</a>
            </h3>
          </div>
          <div class="panel-body">
            <table class="table table-striped" id="partyTable">
              <thead>
                <tr>

                  <th>What</th>
                  <th>When</th>
                  <!--                 <th>Ends</th> -->
                  <th colspan="2">Where</th>
                  
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6" id="partyAdd">
       <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Add party</h3>
        </div>
        <div class="panel-body">
          <table class="table">
            <tbody>
              <tr>
                <td>
                  Party name
                </td>
                <td>
                  <input type="text" placeholder="Party name" class="partyInput" id="newPartyName">
                </td>
              </tr>
              <tr>
                <td>
                  Party starts
                </td>
                <td>
                  <input type="text" class="partyInput dateInput" id="newPartyStart" placeholder="YYYY-MM-DD">
                </td>
              </tr>
              <tr>
                <td>
                  Party ends (optional)
                </td>
                <td>
                  <input type="text" class="partyInput dateInput" id="newPartyEnd" placeholder="YYYY-MM-DD">
                </td>
              </tr>
              <tr>
                <td>
                  Partyplace
                </td>
                <td>
                  <input type="text" placeholder="Partyplace" class="partyInput" id="newPartyPlace">
                </td>
              </tr>
            </tbody>
          </table>
          <button type="button" class="btn btn-success" id="addPartySubmit">Add Party</button>
        </div>
      </div>
    </div>

  </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/scripts.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
  </html>
