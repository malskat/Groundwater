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
	
	<!--Load the AJAX API-->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php 
    
		require_once "../data/species_data.php";
		require_once '../data/campaign_data.php';
		require_once '../data/ecofisio_data.php';


		$campaignData = new Campaign();
	   	$campaigns = $campaignData->getCampaigns(-1);
  		
		$speciesData = new Species();
		$species = $speciesData->getSpecies(-1);


		$selectedCampaign = (isset($_GET["campaign"]) ? $_GET["campaign"] : $campaigns[0]->sampling_campaign_id);
		$selectedSpecies = (isset($_GET["species"]) ? $_GET["species"] : false);
		$selectedtype = (isset($_GET["type"]) ? $_GET["type"] : '13c15N');

//var_dump($selectedCampaign);

		$ecoFisioValues = array();
		$ecoFisioData = new EcoFisio();

		$whereClause = 'ef.sampling_campaign_id = ' . $selectedCampaign;

		if($selectedSpecies && $selectedSpecies != 'all') {
			$whereClause .= ' and sp.species_id = ' . $selectedSpecies;
		}
//var_dump($selectedtype, $whereClause);
		$ecoFisioValues = $ecoFisioData->getEcoFisioSpeciesChart($whereClause);

		$ecoFisioEncoded = json_encode($ecoFisioValues);
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
				var chart_type = "<?=$selectedtype?>";



				if(_ecoFisioValues.length > 0) {

					switch (chart_type) {

						case "13c15N" : {

							var graphData = [['Xylem Water 18O', 'Leaf 13C', 'Leaf 15N']];
							if (_ecoFisioValues != "") {
								for (ecoFisio in _ecoFisioValues){
									if (_ecoFisioValues[ecoFisio].individualCode != null && _ecoFisioValues[ecoFisio].xylemWater_18O != null 
									    	&& _ecoFisioValues[ecoFisio].leaf_13C != null && _ecoFisioValues[ecoFisio].leaf_15N != null) {
										graphData.push([Number(_ecoFisioValues[ecoFisio].xylemWater_18O), 
										               Number(_ecoFisioValues[ecoFisio].leaf_13C), 
										               Number(_ecoFisioValues[ecoFisio].leaf_15N)]);
									}
								}
							}

							if (graphData.length > 1 ) {

								var data = google.visualization.arrayToDataTable(graphData);

								var options = {title:'Leaf 13C and leaf 15N / Xylem 18O',
								               width:1000,
								               height:500,
												hAxis: {title: 'Xylem 18O', minValue: -5, maxValue: 1},
				          						vAxes: [{title: 'leaf 13C', minValue: -32, maxValue: -20}, {title: 'Leaf 15N', minValue: -10, maxValue: 10}],
				          						series:[{targetAxisIndex:0},{targetAxisIndex:1}],
								               lineWidth: 0,
								               pointSize: 3};

								var chart = new google.visualization.LineChart(document.getElementById('species_chart'));
								chart.draw(data, options);
							}

							break;

						} 


						case "13cPri": { 

							var graphData = [['Xylem Water 18O', 'Leaf 13C', 'PRI']];
							if (_ecoFisioValues != "") {
								for (ecoFisio in _ecoFisioValues){
									if (_ecoFisioValues[ecoFisio].individualCode != null && _ecoFisioValues[ecoFisio].xylemWater_18O != null 
										    && _ecoFisioValues[ecoFisio].leaf_13C != null && _ecoFisioValues[ecoFisio].pri != null) {
										graphData.push([Number(_ecoFisioValues[ecoFisio].xylemWater_18O), 
										               Number(_ecoFisioValues[ecoFisio].leaf_13C), 
										               Number(_ecoFisioValues[ecoFisio].pri)]);
									}
								}
							}

							if (graphData.length > 1 ) {

								var data = google.visualization.arrayToDataTable(graphData);

								var options = {title:'Leaf 13C and PRI / Xylem 18O',
								               width:1000,
								               height:500,
												hAxis: {title: 'Xylem 18O', minValue: 0, maxValue: 15},
				          						vAxes: [{title: 'leaf 13C', minValue: -34, maxValue: -20}, {title: 'PRI', minValue: -0.3, maxValue: 0.3}],
				          						series:[{targetAxisIndex:0},{targetAxisIndex:1}],
								               lineWidth: 0,
								               pointSize: 3};

								var chart = new google.visualization.LineChart(document.getElementById('species_chart'));
								chart.draw(data, options);
							}


							break;
						} 

						case "15nCn": {

							var graphData = [['Xylem Water 18O', 'Leaf 15N', 'Leaf CN']];
							if (_ecoFisioValues != "") {
								for (ecoFisio in _ecoFisioValues){
									if (_ecoFisioValues[ecoFisio].individualCode != null && _ecoFisioValues[ecoFisio].xylemWater_18O != null 
									    && _ecoFisioValues[ecoFisio].leaf_15N != null && _ecoFisioValues[ecoFisio].leaf_CN != null) {
										graphData.push([Number(_ecoFisioValues[ecoFisio].xylemWater_18O), 
										               Number(_ecoFisioValues[ecoFisio].leaf_15N), 
										               Number(_ecoFisioValues[ecoFisio].leaf_CN)]);
									}
								}
							}

							if (graphData.length > 1 ) {

								var data = google.visualization.arrayToDataTable(graphData);

								var options = {title:'Leaf 15N and Leaf CN / Xylem 18O',
								               width:1000,
								               height:500,
												hAxis: {title: 'Xylem 18O', minValue: 0, maxValue: 15},
				          						vAxes: [{title: 'leaf 15N', minValue: -10, maxValue: 10}, {title: 'Leaf CN', minValue: 10, maxValue: 90}],
				          						series:[{targetAxisIndex:0},{targetAxisIndex:1}],
								               lineWidth: 0,
								               pointSize: 3};

								var chart = new google.visualization.LineChart(document.getElementById('species_chart'));
								chart.draw(data, options);
							}

							break;
						}

						case "Wi_Ndvi" : {

							var graphData = [['Xylem Water 18O', 'WI', 'NDVI']];
							if (_ecoFisioValues != "") {
								for (ecoFisio in _ecoFisioValues){
									if (_ecoFisioValues[ecoFisio].individualCode != null && _ecoFisioValues[ecoFisio].xylemWater_18O != null 
										    && _ecoFisioValues[ecoFisio].wi != null && _ecoFisioValues[ecoFisio].ndvi != null) {
										graphData.push([Number(_ecoFisioValues[ecoFisio].xylemWater_18O), 
										               Number(_ecoFisioValues[ecoFisio].wi), 
										               Number(_ecoFisioValues[ecoFisio].ndvi)]);
									}
								}
							}

							if (graphData.length > 1 ) {

								var data = google.visualization.arrayToDataTable(graphData);

								var options = {title:'WI and NDVI / Xylem 18O',
								               width:1000,
								               height:500,
												hAxis: {title: 'Xylem 18O', minValue: 0, maxValue: 15},
				          						vAxes: [{title: 'WI', minValue: 0, maxValue: 1.5}, {title: 'NDVI', minValue: 0, maxValue: 1}],
				          						series:[{targetAxisIndex:0},{targetAxisIndex:1}],
								               lineWidth: 0,
								               pointSize: 3};

								var chart = new google.visualization.LineChart(document.getElementById('species_chart'));
								chart.draw(data, options);
							}

							break;
						}

						case "Pri_ChlNdi" : {

							var graphData = [['Xylem Water 18O', 'PRI', 'CHL_NDI']];
							if (_ecoFisioValues != "") {
								for (ecoFisio in _ecoFisioValues){
									if (_ecoFisioValues[ecoFisio].individualCode != null && _ecoFisioValues[ecoFisio].xylemWater_18O != null 
										    && _ecoFisioValues[ecoFisio].pri != null && _ecoFisioValues[ecoFisio].chl_ndi != null) {
										graphData.push([Number(_ecoFisioValues[ecoFisio].xylemWater_18O), 
										               Number(_ecoFisioValues[ecoFisio].pri), 
										               Number(_ecoFisioValues[ecoFisio].chl_ndi)]);
									}
								}
							}

							if (graphData.length > 1 ) {

								var data = google.visualization.arrayToDataTable(graphData);

								var options = {title:'PRI and CHL_NDI / Xylem 18O',
								               width:1000,
								               height:500,
												hAxis: {title: 'Xylem 18O', minValue: 0, maxValue: 15},
				          						vAxes: [{title: 'PRI', minValue: -0.5, maxValue: 0.5}, {title: 'CHL_NDI', minValue: 0, maxValue: 1}],
				          						series:[{targetAxisIndex:0},{targetAxisIndex:1}],
								               lineWidth: 0,
								               pointSize: 3};

								var chart = new google.visualization.LineChart(document.getElementById('species_chart'));
								chart.draw(data, options);
							}

							break;
						}

					}

				} 
			}
	    </script>
  	
    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
         	<h1>Species <small>Scatter Plot</smal></h1>
        </div>
      </div>
    </div>
      
    <!-- accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-lg-10">
          <form  class="form-inline" role="form" name="form_searchindividual_data" action="../core/core_action.php" method="post">
            <input type="hidden" value="chart" name="action">
            <input type="hidden" value="species" name="class">
            <input type="hidden" value="scatter" name="chart">
            
            <div class="form-group">
			<select name="species" class="form-control input-sm">
				<option <?=$selectedSpecies && "all" == $selectedSpecies? 'selected' : ''?> value="all">All Species</option>
				<?php
					foreach($species as $specie){
					echo '<option ' . ($selectedSpecies && $specie->species_id == $selectedSpecies? 'selected' : '') . ' value="' . $specie->species_id . '">' . $specie->genus . ' - ' . $specie->species . '</option>';
					}
				?>
			</select>
            </div>

            <div class="form-group">
			<select name="campaign" class="form-control input-sm">
			<?php
			    foreach($campaigns as $campaign){
					echo '<option ' . ($campaign->sampling_campaign_id == $selectedCampaign ? 'selected' : '') . ' value="' . $campaign->sampling_campaign_id . '">' . $campaign->designation . '</option>';
				}
			?>
			</select>
            </div>

            <div class="form-group">
			<select name="type" class="form-control input-sm">
                <option <?=($selectedtype && "13c15N" == $selectedtype ? 'selected' : '')?> value="13c15N">Leaf 13C and Leaf 15N / Xylem 18O</option>
                <option <?=($selectedtype && "13cPri" == $selectedtype ? 'selected' : '')?> value="13cPri">Leaf 13C and PRI / Xylem 18O</option>
                <option <?=($selectedtype && "15nCn" == $selectedtype ? 'selected' : '')?> value="15nCn">Leaf 15N and Leaf CN / Xylem 18O</option>
                <option <?=($selectedtype && "Wi_Ndvi" == $selectedtype ? 'selected' : '')?> value="Wi_Ndvi">WI and NDVI / Xylem 18O</option>
                <option <?=($selectedtype && "Pri_ChlNdi" == $selectedtype ? 'selected' : '')?> value="Pri_ChlNdi">PRI and CHL_NDI / Xylem 18O</option>
			</select>
            </div>

            <button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-ok"></span> Update</button>
          </form>
        </div>
      </div>
    </div>
    
    <div class="container">
  		<div class="row spacer">
  			<div class="col-xs-12 col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Chart</h3>
					</div>
					<div class="panel-body">
						<div id="species_chart">
							<?
								echo '<p>There are no Eco-Physiology values to show.</p>';
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