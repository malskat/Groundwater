<?php
	include "../checkBiologyst.php";
	require_once '../config/constants.php';
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Projecto Ground Water</title>

    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/alerts.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>


<div class="container">
	<div class="row">
		<div class="col-xs-4 col-lg-offset-4 col-lg-8 col-lg-offset-2">
		    <div id="alert-message" class="alert-message" style="display:none">
		    	<button type="button" class="close" data-hide="alert-message" aria-hidden="true">&times;</button>  
		    	<p id="alert-text"></p>
		    </div>
		</div>
	</div>
</div>	

    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

    <div class="container">

  		<div class="row spacer">
  			<div class="col-xs-6 col-lg-6 col-lg-offset-3 well well-sm text-center">
  				Para fazer actualizações é necessário existir um utilizador com login activo.
  			</div>
  		</div>

  		<div class="row">
			<div class="col-xs-4 col-lg-4 col-lg-offset-4">
		        <div class="panel panel-primary">
		            <div class="panel-heading">
		              <h3 class="panel-title">Login</h3>
		            </div>
		            <div class="panel-body">
		            	<div id="loginForm" name="loginForm">
							<form role="form" onsubmit="return validateLogin();" action="../services/make_entrance.php" method="post">
								
								<input id="destination" name="destination" type="hidden" value="<?=$_SERVER['HTTP_REFERER']?>">
								
								<div id="emailInputGroup" class="form-group">
									<label for="inputEmail">Email</label>
									<input id="email" name="email" type="text" class="form-control">
								</div> 
								<div id="passInputGroup" class="form-group">
									<label for="inputPassword">Password</label>
									<input id="password" name="password" type="password" class="form-control">
								</div>
								<div class="text-center">
									<button id="loginTooltip" type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Por implementar!">Login</button>
								</div>
							</form>
						</div>
		            </div>
		        </div>
	  		</div>
  		</div>

  	</div>

	<script>
	  		//para validar o login
		function validateLogin(){
			var email = $('#email').val();
	    	var password = $('#password').val();
	    	var hasErrors = false;

			if (email == '') {
				$('#emailInputGroup').addClass('has-error');
				hasErrors = true;
			}else {
				$('#emailInputGroup').removeClass('has-error');
			}

			if (password == '') {
				$('#passInputGroup').addClass('has-error');
				hasErrors = true;
			}else {
				$('#passInputGroup').removeClass('has-error');
			}
			
			if (hasErrors){
				$('#alert-message').show();
		        $('#alert-message').addClass('danger');
		        $('#alert-text').html("<strong>Shit happens!</strong>Atenção. Faltam parâmetros ao login (email e password são obrigatórios)!");
				return false;
			} else {
				$("#loginForm").hide();
				$("#loggedInfo").show();
				return true;
			}
		}
	</script>

  </body>
</html>