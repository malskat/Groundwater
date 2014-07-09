<?php
	require_once 'config/constants.php';
?>
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


<script src="<?=PROJECT_URL?>js/utils.js"></script>
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
          	$('#alert-text').html("<strong>Ups daisy!</strong> Operation conclued. However, please, check: <br />" + params["reason"]);
      	} else if(params["success"] == -4) {
        	$('#alert-message').show();
          	$('#alert-message').addClass('danger');
          	$('#alert-text').html("<strong>Ups daisy!</strong> Invalid Login. Please, try again.");
      	}else {
        	$('#alert-message').show();
        	$('#alert-message').addClass('danger');
        	$('#alert-text').html("<strong>Shit happens!</strong> Atention. " + params["reason"]);
      	}


    } else if (params["success"] == 1) {
      	$('#alert-message').show();
      	$('#alert-message').addClass('success');
      	$('#alert-text').html("<strong>Holy guacamole!</strong> Record created/updated." + (params["inserted"] != null && params["inserted"] != "" ? " Foram inseridos/actualizados: " + params["inserted"] + " registos." : ""));
    } else if (params["success"] == 2) {
      	$('#alert-message').show();
      	$('#alert-message').addClass('success');
      	$('#alert-text').html("<strong>Holy guacamole!</strong> Record removed.");
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
      <a class="navbar-brand" href=<?= PROJECT_URL?>>GWTropiMed</a>
    </div>
    <div class="collapse navbar-collapse">
		<ul class="nav navbar-nav">

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'objectives') !== false || strpos($_SERVER['PHP_SELF'], 'sites_description.php') !== false || strpos($_SERVER['PHP_SELF'], 'state-of-the-art.php') !== false || strpos($_SERVER['PHP_SELF'], 'tasks') !== false || strpos($_SERVER['PHP_SELF'], 'partners') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">About <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?=PROJECT_URL . "info/state-of-the-art.php"?>><span class="glyphicon glyphicon-tag"></span> State of the Art</a></li>
			    <li><a href=<?=PROJECT_URL . "info/objectives.php"?>><span class="glyphicon glyphicon-record"></span> Objectives</a></li>
			    <li><a href=<?=PROJECT_URL . "info/sites_description.php"?>><span class="glyphicon glyphicon-map-marker"></span> Sites</a></li>
			    <li><a href=<?=PROJECT_URL . "info/tasks.php"?>><span class="glyphicon glyphicon-tasks"></span> Tasks</a></li>
			    <li><a href=<?=PROJECT_URL . "info/partners.php"?>><span class="glyphicon glyphicon-leaf"></span> Partners</a></li>
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'season') !== false || strpos($_SERVER['PHP_SELF'], 'campaign') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Campaigns <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li role="presentation" class="dropdown-header">Seasons</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/season.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=PROJECT_URL . "lists/season-list.php"?>><span class="glyphicon glyphicon-th-list"></span> List</a></li>
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Campaigns</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/campaign.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=PROJECT_URL . "lists/campaign-list.php"?>><span class="glyphicon glyphicon-th-list"></span> List</a></li>
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'site') !== false || strpos($_SERVER['PHP_SELF'], 'plot') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sites <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    
			    <li role="presentation" class="dropdown-header">Site</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/site.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=PROJECT_URL . "lists/site-list.php"?>><span class="glyphicon glyphicon-th-list"></span> List</a></li> 
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Plot</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/plot.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/plot-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Insert</a></li>
			    <li><a href=<?=PROJECT_URL . "lists/plot-list.php"?>><span class="glyphicon glyphicon-th-list"></span> List</a></li> 
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'species') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Species <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/species.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/species-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Insert</a></li>
			    <li><a href=<?=PROJECT_URL . "lists/species-list.php"?>><span class="glyphicon glyphicon-th-list"></span> List</a></li> 
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Graphs</li>
			    <li><a href=<?=PROJECT_URL . "charts/species-scatter.php"?>><span class="glyphicon glyphicon-signal"></span> Scatter Plot</a></li> 
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'individual') !== false || strpos($_SERVER['PHP_SELF'], 'ecofisio') !== false || strpos($_SERVER['PHP_SELF'], 'struture') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Individuals <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			  	<li role="presentation" class="dropdown-header">Individual</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/individual.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/individual-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Insert</a></li>
			    <li><a href=<?=PROJECT_URL . "lists/individual-list.php"?>><span class="glyphicon glyphicon-th-list"></span> List</a></li>  
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Eco-Physiology</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/ecofisio-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> Leaf/Xylem CSV Update</a></li>
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Structure</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/struture-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Update</a></li>
			  </ul>
			</li>
		<?php
			if ($_BIOLOGYST_LOGGED) {
				echo '<li class="dropdown ' . (strpos($_SERVER['PHP_SELF'], 'use') !== false ? 'active' :  '') .  '">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
								  	<ul class="dropdown-menu">
								    	<li><a href="' . PROJECT_URL .'forms/user.php"><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
								    	<li><a href="' . PROJECT_URL . 'lists/user-list.php"><span class="glyphicon glyphicon-th-list"></span> List</a></li> 
								  	</ul>
						</li>';

			}
		?>

		</ul>

		<?php

			if ($_BIOLOGYST_LOGGED) {
				//utilizador logado

				require_once 'core/core_system.php';

				$destination = CoreSystem::retriveReturnUrl($_SERVER['PHP_SELF']);

				echo '<div id="loggedInfo" name="loggedInfo">
							<div class="navbar-collapse collapse">
				        		<ul class="nav navbar-nav navbar-right">
				            		<li class="dropdown">
				            			<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] . ' <b class="caret"></b></a>
					            		<ul class="dropdown-menu">
					            			<li><a href="'. PROJECT_URL . 'forms/user.php?user_id=' . $_SESSION['user']['user_id'] . '"><span class="glyphicon glyphicon-user"></span> Edit</a></li>
					            			<li><a href="'. PROJECT_URL . 'forms/user.php"?><span class="glyphicon glyphicon-repeat"></span> Password Recover</a></li>
					            			<li><a href="'. PROJECT_URL . 'services/make_exit.php?destination=' . $destination . '"><span class="glyphicon glyphicon-eject"></span> Logout</a></li>
					            		</ul>
					            	</li>
					            </ul>
							</div>
						</div>';
			} else if (strpos($_SERVER['PHP_SELF'], 'login') === false) {

				//formulario de utilizador
				echo '<div id="loginForm" name="loginForm" class="navbar-form navbar-right">
						<button id="loginTooltip" class="btn btn-success btn-sm" onclick="location.href=\'../forms/login.php\'">Login <span class="glyphicon glyphicon-tree-conifer"></span></button>
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
	        	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	        	<button id="removeModalButton" type="button" class="btn btn-primary">Yes</button>
	      	</div>
	    </div>
 	</div>
</div>

<script>

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


