<!-- incluir alertas -->
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

<?php 
	require_once 'config/constants.php';
	session_start();
	$showloggedItens = false;
	if(isset($_SESSION['user']) && ($_SESSION['user']['entrance'] + PROJECT_LOGGED_PERMITED_TIME) >= time()) {
		$showloggedItens = true;
	} else if (isset($_SESSION['user'])) {
		//retirar o user de sessao caso tenha passado o tempo permitido de acesso autorizado
		unset($_SESSION['user']);
	}

?>
<script src="../js/utils.js"></script>
<script>


  //para os alertas
	var params = getQueryParams(window.location.search);
    if (params["success"] < 0) {

      	if(params["success"] == -3) {
        	$('#alert-message').show();
          	$('#alert-message').addClass('warning');
          	$('#alert-text').html("<strong>Ups daisy!</strong>" +  params["reason"]);
    	} else if(params["success"] == -2) {
        	$('#alert-message').show();
          	$('#alert-message').addClass('warning');
          	$('#alert-text').html("<strong>Ups daisy!</strong> Operação concluída com sucesso. No entanto verifica o seguinte: <br />" + params["reason"]);
      	} else {
        	$('#alert-message').show();
        	$('#alert-message').addClass('danger');
        	$('#alert-text').html("<strong>Shit happens!</strong> Atenção. " + params["reason"]);
      	}
    } else if (params["success"] == 1) {
      	$('#alert-message').show();
      	$('#alert-message').addClass('success');
      	$('#alert-text').html("<strong>Holy guacamole!</strong> Registo criado/alterado com sucesso." + (params["inserted"] != null && params["inserted"] != "" ? " Foram inseridos/actualizados: " + params["inserted"] + " registos." : ""));
    } else if (params["success"] == 2) {
      	$('#alert-message').show();
      	$('#alert-message').addClass('success');
      	$('#alert-text').html("<strong>Holy guacamole!</strong> Registo eliminado com sucesso.");
    }
</script>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=<?= PROJECT_URL?>>Groundwater</a>
    </div>
    <div class="collapse navbar-collapse">
		<ul class="nav navbar-nav">

			<li <?=(strpos($_SERVER['PHP_SELF'], 'season') !== false || strpos($_SERVER['PHP_SELF'], 'campaign') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Campanhas <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li role="presentation" class="dropdown-header">Épocas</li>
			    <li><a href=<?="/forms/season.php" ?>>Inserir</a></li>
			    <li><a href=<?="/lists/season-list.php"?>>Consultar</a></li>
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Campanhas</li>
			    <li><a href=<?="/forms/campaign.php" ?>>Inserir</a></li>
			    <li><a href=<?= "/lists/campaign-list.php"?>>Consultar</a></li>
			  </ul>
			</li>

			<li <?=(strpos($_SERVER['PHP_SELF'], 'site') !== false || strpos($_SERVER['PHP_SELF'], 'plot') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Locais <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    
			    <li role="presentation" class="dropdown-header">Site</li>
			    <li><a href=<?="/forms/site.php"?>>Inserir</a></li>
			    <li><a href=<?="/lists/site-list.php"?>>Consultar</a></li> 
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Plot</li>
			    <li><a href=<?="/forms/plot.php"?>>Inserir</a></li>
			    <li><a href=<?="/forms/plot-csv.php"?>>Inserir por CSV</a></li>
			    <li><a href=<?="/lists/plot-list.php"?>>Consultar</a></li> 
			  </ul>
			</li>

			<li <?=(strpos($_SERVER['PHP_SELF'], 'species') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Espécies <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?="/forms/species.php"?>>Inserir</a></li>
			    <li><a href=<?="/forms/species-csv.php"?>>Inserir por CSV</a></li>
			    <li><a href=<?="/lists/species-list.php"?>>Consultar</a></li> 
			  </ul>
			</li>

			<li <?=(strpos($_SERVER['PHP_SELF'], 'individual') !== false || strpos($_SERVER['PHP_SELF'], 'ecoFisio') !== false || strpos($_SERVER['PHP_SELF'], 'struture') !== false ? 'class="active"' :  '')?> class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Indivíduos <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			  	<li role="presentation" class="dropdown-header">Indivíduos</li>
			    <li><a href=<?="/forms/individual.php"?>>Inserir</a></li>
			    <li><a href=<?="/forms/individual-csv.php"?>>Inserir por CSV</a></li>
			    <li><a href=<?="/lists/individual-list.php"?>>Consultar</a></li>  
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Eco-Fisio</li>
			    <li><a href=<?="/forms/ecoFisio-csv.php"?>>Actualizar por CSV</a></li>
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Struture</li>
			    <li><a href=<?="/forms/struture-csv.php"?>>Actualizar por CSV</a></li>
			  </ul>
			</li>
		<?php
			if ($showloggedItens) {
				echo '<li ' . (strpos($_SERVER['PHP_SELF'], 'use') !== false ? 'class="active"' :  '') .  ' class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Utilizadores <b class="caret"></b></a>
								  	<ul class="dropdown-menu">
								    	<li><a href="' .'/forms/user.php">Inserir</a></li>
								    	<li><a href="' .'/lists/user-list.php">Consultar</a></li> 
								  	</ul>
						</li>';

			}
		?>

		</ul>

		<?php

			if ($showloggedItens) {
				//utilizador logado
				echo '<div id="loggedInfo" name="loggedInfo">
							<div class="navbar-collapse collapse">
				        		<ul class="nav navbar-nav navbar-right">
				            		<li class="dropdown">
				            			<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] . ' <b class="caret"></b></a>
					            		<ul class="dropdown-menu">
					            			<li><a href="/forms/user.php?user_id=' . $_SESSION['user']['user_id'] . '"><i class="fa fa-user fa-fw"></i>Consultar</a></li>
					            			<li><a href="/forms/user.php"?>Recuperar password</a></li>
					            			<li><a href="/services/make_exit.php?destination=' . $_SERVER['HTTP_REFERER'] . '">Logout</a></li>
					            		</ul>
					            	</li>
					            </ul>
							</div>
						</div>';
			} else {

				//formulario de utilizador
				echo '<div id="loginForm" name="loginForm">
							<form class="navbar-form navbar-right" role="form" onsubmit="return validateLogin();" action="../services/make_entrance.php" method="post">
								<input id="destination" name="destination" type="hidden" value="' . $_SERVER['PHP_SELF'] . '"">
								<div id="emailInputGroup" class="form-group">
									<input id="email" name="email" type="text" placeholder="Email" class="form-control">
								</div> 
								<div id="passInputGroup" class="form-group">
									<input id="password" name="password" type="password" placeholder="Password" class="form-control">
								</div>
								<button id="loginTooltip" type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Por implementar!">Login</button>
							</form>
						</div>';
			}
		?>
		
		
    </div>
  </div>
</nav>



<!-- Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        	<h4 class="modal-title" id="modalLabel"></h4>
	      	</div>
			<div class="modal-body">
				<p id="modalDescription" name="modalDescription"></p>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
	        	<button id="removeModalButton" type="button" class="btn btn-primary">Sim</button>
	      	</div>
	    </div>
 	</div>
</div>

<script>

	//para mostrar a tooltip do login
	$('#loginTooltip').tooltip({trigger: 'hover'});

	//para fechar o alert;
	$(function(){
	    $("[data-hide]").on("click", function(){
	        $(this).closest("." + $(this).attr("data-hide")).hide();
	    });
	});


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
	        $('#alert-text').html("<strong>Shit happens!</strong> Faltam parâmetros ao login (email e password são obrigatórios)!");
			return false;
		} else {
			$("#loginForm").hide();
			$("#loggedInfo").show();
			return true;
		}
	}
</script>


