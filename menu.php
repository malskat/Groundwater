<!-- incluir alertas -->
<div class="container">
	<div class="row">
		<div class="col-xs-4 col-lg-8 col-lg-offset-2">
		    <div id="alert-message" class="alert-message" style="display:none">
		    	<button type="button" class="close" data-hide="alert-message" aria-hidden="true">&times;</button>  
		    	<p id="alert-text"></p>
		    </div>
		</div>
	</div>
</div>	


<script src="<?=PROJECT_URL?>js/utils.js"></script>
<script src="<?=PROJECT_URL?>js/system_errors.js"></script>
<script>


  //para os alertas
	var params = getQueryParams(window.location.search);

	if (params["response"]) {

		try {

			$('#alert-message').show();
		  	$('#alert-message').addClass(SYSTEM_ERRORS[params["response"]].type_error);
		  	$('#alert-text').html(SYSTEM_ERRORS[params["response"]].msg + 
		  	         (params["inserted"] != null && params["inserted"] != "" ? " " + params["inserted"] + " records have been inserted." : "") + 
		  	         (params["reason"] != null && params["reason"] != "" && params["inserted"] != null && params["inserted"] != "" ? " However, please, check: <br />" + params["reason"] : "") +
		  	         (params["reason"] != null && params["reason"] != "" && params["inserted"] == null ? " Please, check: <br />" + params["reason"] : ""));

		} catch (err) {
			$('#alert-message').show();
		  	$('#alert-message').addClass("danger");
		  	$('#alert-text').html("<strong>Error </strong>- Response not accepted.");
		}
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

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], '/about') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">About <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?=PROJECT_URL . "about/state-of-the-art.php"?>><span class="glyphicon glyphicon-tag"></span> State of the Art</a></li>
			    <li><a href=<?=PROJECT_URL . "about/objectives.php"?>><span class="glyphicon glyphicon-record"></span> Objectives</a></li>
			    <li><a href=<?=PROJECT_URL . "about/sites.php"?>><span class="glyphicon glyphicon-map-marker"></span> Sites</a></li>
			    <li><a href=<?=PROJECT_URL . "about/tasks.php"?>><span class="glyphicon glyphicon-tasks"></span> Tasks</a></li>
			    <li><a href=<?=PROJECT_URL . "about/partners.php"?>><span class="glyphicon glyphicon-leaf"></span> Partners</a></li>
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'outputs/') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Outuputs <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?=PROJECT_URL . "outputs/project-meetings.php"?>><span class="glyphicon glyphicon-adjust"></span> Project Meetings</a></li>
			    <li><a href=<?=PROJECT_URL . "outputs/scientific-events.php"?>><span class="glyphicon glyphicon-bullhorn"></span> Scientific Events</a></li>
			    <li><a href=<?=PROJECT_URL . "outputs/workshop.php"?>><span class="glyphicon glyphicon-globe"></span> Workshop</a></li>
			    <li><a href=<?=PROJECT_URL . "outputs/papers.php"?>><span class="glyphicon glyphicon-book"></span> Papers</a></li>
			  </ul>
			</li>	

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'season') !== false || strpos($_SERVER['PHP_SELF'], 'campaign') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Campaigns <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li role="presentation" class="dropdown-header">Seasons</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/season.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "lists/season-list.php": PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-th-list"></span> List</a></li>
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Campaigns</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/campaign.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "lists/campaign-list.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-th-list"></span> List</a></li>
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'lists/site') !== false || strpos($_SERVER['PHP_SELF'], 'forms/site') !== false )?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sites <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/site.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "lists/site-list.php": PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-th-list"></span> List</a></li>

			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Climatic Info</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/siteclima-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Update</a></li> 
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'plot') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Plots <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/plot.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/plot-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "lists/plot-list.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-th-list"></span> List</a></li> 

			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Water Info Update</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/plotattribute-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Update</a></li>

			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Soil Info Update</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/plotsoil-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Update</a></li>
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'species') !== false ? 'active' :  '')?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Species <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/species.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/species-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "lists/species-list.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-th-list"></span> List</a></li> 
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Graphs</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "charts/species-scatter.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-signal"></span> Scatter Plot</a></li> 
			  </ul>
			</li>

			<li class="dropdown <?=(strpos($_SERVER['PHP_SELF'], 'individual') !== false || strpos($_SERVER['PHP_SELF'], 'ecofisio') !== false || strpos($_SERVER['PHP_SELF'], 'structure') !== false || strpos($_SERVER['PHP_SELF'], 'reflectance') !== false ? 'active' :  '') ?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Individuals <b class="caret"></b></a>
			  <ul class="dropdown-menu">
			  	<li role="presentation" class="dropdown-header">Individual</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/individual.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-plus"></span> Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/individual-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Insert</a></li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "lists/individual-list.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-th-list"></span> List</a></li>  
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Eco-Physiology</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/ecofisio-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> Leaf/Xylem CSV Update</a></li>
			    
			    <li role="presentation" class="divider"></li>
			    <li role="presentation" class="dropdown-header">Structure</li>
			    <li><a href=<?=($_BIOLOGYST_LOGGED ? PROJECT_URL . "forms/structure-csv.php" : PROJECT_URL . "forms/login.php")?>><span class="glyphicon glyphicon-import"></span> CSV Update</a></li>
			  </ul>
			</li>
		<?php
			if ($_BIOLOGYST_LOGGED && array_search('user', $_BIOLOGYST_LOGGED['userInfo']['permissions']) !== false) {
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

				$destination = '';

				echo '<div id="loggedInfo" name="loggedInfo">
							<div class="navbar-collapse collapse">
				        		<ul class="nav navbar-nav navbar-right">
				            		<li class="dropdown">
				            			<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $_BIOLOGYST_LOGGED['userInfo']['first_name'] . ' ' . $_BIOLOGYST_LOGGED['userInfo']['last_name'] . ' <b class="caret"></b></a>
					            		<ul class="dropdown-menu">
					            			<li><a href="'. PROJECT_URL . 'forms/user.php?user_id=' . $_BIOLOGYST_LOGGED['userInfo']['id'] . '"><span class="glyphicon glyphicon-user"></span> Edit</a></li>
					            			<li><a href="'. PROJECT_URL . 'services/make_exit.php?destination=' . $destination . '"><span class="glyphicon glyphicon-eject"></span> Logout</a></li>
					            		</ul>
					            	</li>
					            </ul>
							</div>
						</div>';
			} else if (strpos($_SERVER['PHP_SELF'], 'login') === false && strpos($_SERVER['PHP_SELF'], 'recover-password') === false) {

				//acesso ao login
				echo '<div id="loginForm" name="loginForm" class="navbar-form navbar-right">
						<button id="loginTooltip" class="btn btn-success btn-sm" onclick="location.href=\'/forms/login.php\'">Login <span class="glyphicon glyphicon-tree-conifer"></span></button>
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
</script>


