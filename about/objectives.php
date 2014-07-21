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
    <script src="../js/bootstrap.js"></script>
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
     		<h1>Objectives</h1>
   		</div>
	</div>

	<div class="container">
		<div class="row">
			<p class="lead">
				The core idea of this study is to evaluate the capacity of different plant communities to adapt to future scenarios of changing Groundwater (GW) by an integrative spatial approach of GW stress indicators. This approach will contribute to trace GW stress in vegetation in an early stage and help to manage vulnerable communities.
			</p>
			<p>
				Moreover, we aim to:
			</p>
			<p>
				<ol>
					<li>Characterize and understand plant functional groups water use in a GW limitation situation in a climatic gradient: from Tropics to Mediterranean (<a href=<?=PROJECT_URL . "about/tasks.php/#pill_task1"?>>Task 1</a>);</li>
					<li>Understand ecophysiological responses of functional groups in a GW gradient and define suitable short-term stress indicators in GW limitation scenarios (<a href=<?=PROJECT_URL . "about/tasks.php/#pill_task2"?>>Task 2</a>);</li>
					<li>Estimate important factors that could function as GW long-term stress tracers and evaluate long-term stress sensitivity of the functional groups to temporal/seasonal changes in water availability (<a href=<?=PROJECT_URL . "about/tasks.php/#pill_task3"?>>Task 3</a>);</li>
					<li>Develop a model to evaluate community water use and response under groundwater change scenarios through ecophysiological parameters (<a href=<?=PROJECT_URL . "about/tasks.php/#pill_task4"?>>Task 4</a>).</li>
				</ol>
			</p>
		</div>

		<div class="row spacer">
			<p><a href=<?=PROJECT_URL . "about/tasks.php"?> class="btn btn-primary btn-sm" role="button">Project Tasks &raquo;</a></p>	
		</div>
	</div>

	

	<?php include "../footer.php";?>

  </body>
</html>