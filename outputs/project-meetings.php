<?php
	include "../checkBiologyst.php";
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>GWTropiMed Project</title>

    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/utils.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="../css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">
    <link href="../css/sticky-footer.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

	<div class="container">
		<div class="page-header">
     		<h1>Project Meetings</h1>
   		</div>
	</div>

	<div class="container">
		<div class="row">
			<p class="lead">The meetings are a gathering of people related to the project for the purpose of sharing information and discussing one or more project topics in a formal setting.</p>
		</div>

		<div class="row spacer">
				<div class="col-xs-4 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><strong>Kick-off Meeting</strong></h4>
					</div>
			        <div class="panel-body">
			        	<p>First meeting to discuss project aims, tasks and management.</p>
			        	<p><strong>When</strong> - <small>25 May 2012</small></p>
			        	<p><strong>Where</strong> - <small> FCUL, Lisbon, Portugal</small></p>
			        	<p><strong>Participants</strong> - <small>C. Maguas, S.Vieira, M.C.Barradas, C.Antunes, P. Pinho, M.J.Pereira, M.Ramos, O. Correia, Y.Bakker, R. Oliveira.</small></p>
			        	<hr/>
			        	<div class="row">
				        	<div class="col-xs-4 col-lg-4">
				        		<p><a target="_blank" href=<?=PROJECT_URL . "docs_center/outputs/meetings/GWTropiMed_Kickoff_Meeting.pdf"?> class="btn btn-warning btn-sm" role="button">Get document <span class="glyphicon glyphicon-tree-deciduous"></span></a></p>	
				        	</div>
				        </div>
			        </div>
				</div>
			</div>

			<div class="col-xs-4 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><strong>Iberian Meeting</strong></h4>
					</div>
			        <div class="panel-body">	        	
			        	<p>Meeting with portuguese and spanish colaborators to discuss preliminary results from Doñana spring campaign.</p>
			        	<p><strong>When</strong> - <small>24 October 2013</small></p>
			        	<p><strong>Where</strong> - <small> FCUL, Lisbon, Portugal</small></p>
			        	<p><strong>Participants</strong> - <small>C. Máguas, O. Correia, M.C.Barradas, C.Antunes.</small></p>
			        	<hr/>
			        	<div class="row">
				        	<div class="col-xs-4 col-lg-4">
				        		<p>
				        			<a target="_blank" href=<?=PROJECT_URL . "info/state_of_the_art.php"?> class="btn btn-warning btn-sm" role="button" disabled="disabled">
					        			Document unavailable <span class="glyphicon glyphicon-tree-deciduous"></span>
					        		</a>
					        	</p>	
				        	</div>
				        </div>
			        </div>
				</div>
			</div>

			<div class="col-xs-4 col-lg-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><strong>Progress Meeting</strong></h4>
					</div>
			        <div class="panel-body">
			        	<p>Meeting intended to evaluate the project progress: discussion about what we have accomplished, where we are and future strategies.</p>
			        	<p><strong>When</strong> - <small>10 July 2014</small></p>
			        	<p><strong>Where</strong> - <small> FCUL, Lisbon, Portugal</small></p>
			        	<p><strong>Participants</strong> - <small>C. Máguas, O. Correia, M.C.Barradas, C.Antunes, S. Vieira, P.Pinho, M. Ramos.</small></p>
			        	<hr/>
			        	<div class="row">
				        	<!-- <div class="col-xs-4 col-lg-4">
				        		<p><a href=<?=PROJECT_URL . "info/objectives.php"?> class="btn btn-primary btn-sm" role="button">Get abstract <span class="glyphicon glyphicon-leaf"></span></a></p>	
				        	</div> -->
				        	<div class="col-xs-4 col-lg-4">
				        		<p><a target="_blank" href=<?=PROJECT_URL . "docs_center/outputs/meetings/GWTropiMed_meeting_10july14_v2.pdf"?> class="btn btn-warning btn-sm" role="button">Get document <span class="glyphicon glyphicon-tree-deciduous"></span></a></p>	
				        	</div>
				        </div>
			        </div>
				</div>
			</div>


		</div>

	</div>

	<?php include "../footer.php";?>

  </body>
</html>