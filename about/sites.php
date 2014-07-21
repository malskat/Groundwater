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

    <script src="<?=PROJECT_URL?>js/jquery-1.10.2.js"></script>
    <script src="<?=PROJECT_URL?>/js/bootstrap.js"></script>
    <script src="<?=PROJECT_URL?>/js/utils.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <!-- Bootstrap core CSS -->
    <link href="<?=PROJECT_URL?>/css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="<?=PROJECT_URL?>/css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=PROJECT_URL?>/css/mainCore.css" rel="stylesheet">
    <link href="<?=PROJECT_URL?>/css/sticky-footer.css" rel="stylesheet">

  </head>

  <body>

  	<script>
  		$(function(){
	    	var hash = document.location.hash;
	    	var prefix = "pill_";
			if (hash){
  				$('#sites-pills a[href="' + hash.replace(prefix,"") + '"]').tab('show');
			}

			$('#sites-pills a').on('shown.bs.tab', function (e) {
			    window.location.hash = e.target.hash.replace("#", "#" + prefix);
				init_map(e.target.hash);
			});
		});
    </script>

    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

	<div class="container">
		<div class="page-header">
     		<h1>Sites</h1>
   		</div>
	</div>

	<div class="container">

		<div class="row">
			<p class="lead">The study sites were selected based in the following criteria: (i)  garantie of a climatic gradient; (ii) existence of a groundwater gradient; (iii) coastal dune forest (in sandy soils); (iv) data availability and infrastructures.</p>
		</div>

		<div class="row smallspacer">
			
			<div class="col-xs-3 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="nav nav-pills nav-stacked" id="sites-pills">
			  				<li class="active"><a href="#donana" data-toggle="pill"><span class="glyphicon glyphicon-map-marker"></span> Doñana, Spain</a></li>
							<li><a href="#osso" data-toggle="pill"><span class="glyphicon glyphicon-map-marker"></span> Osso da Baleia, Portugal</a></li>
			  				<li><a href="#ubatuba" data-toggle="pill"><span class="glyphicon glyphicon-map-marker"></span> Ubatuba, Brazil</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-xs-9 col-lg-9">
				<div class="tab-content">


					<div class="tab-pane fade in active" id="donana">
						<div class="row">
							<h3>Mediterranean Site</h3>
							<p>Plot created by Universidad de Sevilla, in Reserva Biológica de Doñana, Spain (Serrano & Zunzunegui, 2008). In the study area, it can be found  temporary ponds (prioritary habitat of the european habitat directive), floodable in certain periods of the year (autumn and winter), in sandy soils and favored by a clay horizon (semi-permeable) very dependent on annual rainfall and recharge capacity. The study site is composed by the temporary ponds, mediterranean thickets, juniper forest and pinewood. The vegetation is dominated by hydrophytic and xeric shrubs (such as <em>Erica scoparia</em>, <em>Corema album</em>, <em>Halimium sp.</em>) and mediterranean trees (<em>Juniperus phoenicea</em>, <em>Quercus suber</em> and <em>Pinus pinea</em>).</p>
							<p>The presence of a tourist complex and irrigated crops near the study site imply a strong impact upon the vegetation and hydric conditions of the study area (Serrano and Zunzunegui 2008), and this water exploitation creates a groundwater gradient throughout our study site.</p>
							<p>The climate is typically mediterranean, with the rainy period between october and march, and dry hot summers. Annual precipitation is lower compared to the other study sites: in a rainy year it can be found annual values higher than 712mm but in a dry year annual precipitation can be lower than 355mm. Temperature in the dry season can easily reach 40ºC, and lower temperatures are reached in the winter time, existing a high thermal amplitude over the year.</p>
						</div>

						<div class="row smallspacer">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><strong>Location</strong></h4>
								</div>
								<div class="panel-body">
									<div id="map-container-donana" class="col-xs-12 col-lg-12"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="osso">

						<div class="row">
							<h3>Meso-mediterranean Site</h3>
							<p>Plot created by CBA-FCUL, in Osso da Baleia, Portugal (Maguas et al, 2011). It is a pine forest, situated north of Leiria, constituted by north-south dune belts where many dune slacks exist. Maximum elevation is 77m and is oriented from west to east. Vegetation is characterized by a primary dune belt with a herbaceous and shrub formation, and a pine forest (<em>Pinus pinaster</em>) in the stabilized secondary dune. In the pine forest it can be found other tree species (such as <em>Myrica faya</em>), shrub species (such as <em>Corema album</em>) and dune slacks considered in the Natura 2000 network as the habitat 2170 - Dunes with <em>Salix repens</em> ssp. <em>argentea</em> (ICNB 2006). The soil is mainly constitute by sand.</p>
							<p>In this area the national electric and gas storage company (REN, S.A) is exploiting, since 2001, the groundwater for gas storage purposes. To assess subterranean caverns, the groundwater has to be extracted and, for that, the company uses 20 extraction wells (distributed in our study area). The groundwater extraction is limited to 600m3/h with a maximum of groundwater lowering of 5m. Additionally, 14 piezometers exists throughout  the area with daily groundwater level measurements.</p>
							<p>The climate is meso-mediterranean, with frequent rainy events in winter and spring (November to April, with a monthly average of about 150mm) and a period of less precipitation in the summer (July to August), being the annual total amount of precipitation c. 900mm. The highest temperatures (approximately 37ºC) are in the dry season, and the lowest temperatures in the rainy season.</p>
						</div>

						<div class="row smallspacer">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><strong>Location</strong></h4>
								</div>
								<div class="panel-body">
									<div id="map-container-osso" class="col-xs-12 col-lg-12"></div>
								</div>
							</div>
						</div>
					</div>


					<div class="tab-pane fade" id="ubatuba">
						
						<div class="row">
							<h3>Tropical Site</h3>
							<p>Plot created and monitored by BIOTA/FAPESP project - Restinga, in Ubatuba -SP, Brazil (Joly et al, 2008; Vieira et al., 2008). Restinga is a vegetation formation integrated in the Parque Estadual da Serra do Mar – PESM, in the Picinguaba Nucleo. The vegetation represents the Restinga fisionomy (according to the brazilian national classification system: IBGE (Veloso et al., 1991), being considered a pristine forest in coastal areas with an elevation between 0 and 10m. Restinga soil is classified as Neosolo Quartzarenic and has a high sand content, low pH, low phosphorus concentration and a high aluminium saturation.</p>
							<p>The climate in Ubatuba region is, according to Kopper (1948) classified as Af (Tropical rainforest climate), with a mean annual precipitation of approximately 3000 mm (and with less precipitation in june: about 87 mm) and mean annual temperature of 22ºC.</p>
						</div>

						<div class="row smallspacer">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><strong>Location</strong></h4>
								</div>
								<div class="panel-body">
									<div id="map-container-ubatuba" class="col-xs-12 col-lg-12"></div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

	

	<?php include "../footer.php";?>

	<script>    

		var toType = function(obj) {
			return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase()
		}
 
		function init_map(local) {

			var divToShow = "map-container-donana";

			if (toType(local) == 'string') {
				local = local.substring(1, local.length);
				divToShow = "map-container-" + local;
			}

			var coord_Lat = 37.042729;
			var coord_Long = -6.434447;
			var localTitle;

			switch (local) {
				case "donana": {
					coord_Lat = 37.042729;
					coord_Long = -6.434447;
					localTitle = "Doñana";
					break;
				}
				case "osso": {
					coord_Lat = 40.000964;
					coord_Long = -8.904092;
					localTitle = "Osso da Baleia";
					break;
				}
				case "ubatuba": {
					coord_Lat = -23.368612;
					coord_Long = -44.835051;
					localTitle = "Ubatuba";
					break;
				}
			}


			var var_location = new google.maps.LatLng(coord_Lat, coord_Long);

			var var_mapoptions = {
			  center: var_location,
			  zoom: 10
			};

			var var_marker = new google.maps.Marker({
			    position: var_location,
			    map: var_map,
			    title: localTitle}
			   );

			var var_map = new google.maps.Map(document.getElementById(divToShow),
			    var_mapoptions);

			var_marker.setMap(var_map);    

		}

		google.maps.event.addDomListener(window, 'load', init_map);
 
    </script>

  </body>
</html>