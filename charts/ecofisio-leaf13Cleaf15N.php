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
		<!-- Bootstrap core CSS -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<!-- Bootstrap alerts -->
		<link href="../css/alerts.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="../css/mainCore.css" rel="stylesheet">
    	<link href="../css/sticky-footer.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="../../assets/js/html5shiv.js"></script>
		  <script src="../../assets/js/respond.min.js"></script>
		<![endif]-->

		<!--Load the AJAX API-->
    	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	</head>

	<body>

	  	<!-- incluir menu principal -->
	  	<?php include "../menu.php";?>

	  	<?

	  		$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "../forms/individual.html?individualCode=" . $_GET['individualCode']);
	  		
			$ecoFisioValues = array();
			if (isset($_GET['individualCode'])) {
		    	include '../data/ecofisio_data.php';
		    	$ecoFisioData = new EcoFisio();
		    	$ecoFisioValues = $ecoFisioData->getEcoFisioBy($where = 'ef.individualCode = "' . $_GET['individualCode'] . '"', $orderBy = 'ef.samplingDate ASC' , -1);
			
				$ecoFisioEncoded = json_encode($ecoFisioValues);
			}
		?>

	    <script type="text/javascript">

			// Load the Visualization API and the piechart package.
			google.load('visualization', '1.0', {'packages':['corechart']});

			// Set a callback to run when the Google Visualization API is loaded.
			google.setOnLoadCallback(drawChart);

			// Callback that creates and populates a data table,
			// instantiates the pie chart, passes in the data and
			// draws it.
			function drawChart() {

				var _ecoFisioValues = <?=$ecoFisioEncoded?>;
				if(_ecoFisioValues.length > 0) {
					var graphData = [['Xylem Water 18O', 'Leaf 13C', 'Leaf 15N']];
					if (_ecoFisioValues != "") {
						for (ecoFisio in _ecoFisioValues){
							if (_ecoFisioValues[ecoFisio].individualCode != null && _ecoFisioValues[ecoFisio].xylemWater_18O != null 
								    	&& _ecoFisioValues[ecoFisio].leaf_13C != null && _ecoFisioValues[ecoFisio].leaf_15N != null) {
								graphData.push([_ecoFisioValues[ecoFisio].xylemWater_18O, 
								               Number(_ecoFisioValues[ecoFisio].leaf_13C), 
								               Number(_ecoFisioValues[ecoFisio].leaf_15N)]);
							}
						}
					}

					var data = google.visualization.arrayToDataTable(graphData);

					var options = {title:'Leaf 13C and leaf 15N / Xylem 18O',
					               width:1000,
					               height:500,
									hAxis: {title: 'Xylem 18O', minValue: 0, maxValue: 15},
	          						vAxes: [{title: 'leaf 13C', minValue: -40, maxValue: 40}, {title: 'Leaf 15N', minValue: -20, maxValue: 20}],
	          						series:[{targetAxisIndex:0},{targetAxisIndex:1}],
					               lineWidth: 0,
					               pointSize: 3};

					var chart = new google.visualization.LineChart(document.getElementById('ecoFisioLeaf13CLeaf15NGraph'));
					chart.draw(data, options);
				}
			}
	    </script>

	    <!-- titulo -->
	    <div class="container">
			<div class="row">
				<div class="page-header">
					<h2>
						Eco-Physiology
						<small>Individual - <?=$_GET['individualCode']?></small>
					</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-lg-10">
					<button class="btn btn-link" onclick="location.href='<?=$backUrl?>'">« back</button>
				</div>
				<div class="col-xs-6 col-lg-2"></div>
			</div>
		</div>

	    <!-- tabela e gráfico -->
	    <div class="container">
	  		<div class="row spacer">
	  			<div class="col-xs-12 col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Leaf 13C and 15N / Xylem Water 18O</h3>
						</div>
						<div class="panel-body">
							<div id="ecoFisioLeaf13CLeaf15NGraph">
								<?
									if (count($ecoFisioValues) == 0) {
										echo '<p>There are no Eco-Physiology values to show.</p>';
									}
								?>
				        	</div>
						</div>
					</div>
			    </div>
			</div>
		</div>

		<?php include "../footer.php";?>

	</body>
</html>

