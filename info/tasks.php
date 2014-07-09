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
  				$('#tasks-pills a[href="' + hash.replace(prefix,"") + '"]').tab('show');
			}

			$('#tasks-pills a').on('shown.bs.tab', function (e) {
				console.log('funcao executada');
			    window.location.hash = e.target.hash.replace("#", "#" + prefix);
			});
		});
    </script>

    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

	<div class="container">
		<div class="page-header">
     		<h1>Tasks</h1>
   		</div>
	</div>

	<div class="container">
		<div class="col-xs-3 col-lg-3">
			<div class="row spacer">
				<ul class="nav nav-pills nav-stacked" id="tasks-pills">
					<li class="active"><a href="#task1" data-toggle="tab">1. Installation and characterization of experimental plots</a></li>
	  				<li><a href="#task2" data-toggle="pill">2. Groundwater short-term stress tracers</a></li>
	  				<li><a href="#task3" data-toggle="pill">3. Groundwater long-term stress tracers</a></li>
	  				<li><a href="#task4" data-toggle="pill">4. Prediction of functional groups responses to groundwater limitation</a></li>
				</ul>
			</div>
		</div>

		<div class="col-xs-9 col-lg-9">
			<div class="tab-content">


				<div class="tab-pane fade in active" id="task1">
					<h2>Task 1</h2>
					
					<h4 class="smallspacer">Objective</h4>
					<p class="text-justify">
						<ol>
							<li>Experimental plots installation and characterization across climatic and groundwater availability gradients.</li>
						</ol>
					</p>
					
					<h4>Rationale</h4>
					<p class="text-justify">The existing information on site conditions guarantee a climatic and groundwater gradient. The climatic gradient will include Tropical, Meso-mediterranean and Mediterranean regions: Brazil, Portugal and Spain. All the sites are coastal dune forests with groundwater changing and with available information concerning climate and groundwater variation.</p>
					
					<h4>Approach</h4>
					<p class="text-justify">
						<ol>
							<li>
								<strong><em>Establishment of experimental plots</em></strong>:
								<p class="text-justify">In each climatic region, it will be installed 1 experimental plot of +/-3 km2 with 30 sub-plots of 20mx20m. Selection of the areas will follow two main criteria: i) all sites are coastal forests, ii) sites have a groundwater limitation gradient.</p>
								<ul>
									<li>Tropical site: plot established by BIOTA/FAPESP, RESTINGA, Brazil (Joly et al, 2008).</li>
									<li>Meso-mediterranen site: plot established by CBA-FCUL, Osso da Baleia, Portugal (Maguas etal,2011).</li>
									<li>Mediterranean site: plot established by Univ Sevilla, Doñana National Park, Spain (Serrano & Zunzunegui, 2008).</li>
								</ul>
							</li>
							<li>
								<strong><em>Monitoring climatic conditions and groundwater</em></strong>:
								<p class="text-justify">Local climate data will be available from a climate station already installed in each site. Groundwater assessed from piezometers (water-level-recording/sampling) already installed in Portugal (REN-Armazenagem) and Spain (Doñana National Park) sites and from piezometers that will be installed within Brazil sub-plots.</p>
							</li>
							<li>
								<strong><em>Functional groups identification and Forest structure evaluation</em></strong>:
								<p class="text-justify">In every sub-plot the species identification, spatial distribution and allometric measures will be performed.  Species will be grouped by functional traits (eg. root system). Considering the functional group, a max of 12 individuals per sub-plot will be selected for further analysis.</p>
							</li>
							<li>
								<strong><em>Soil profiles</em></strong>:
								<p class="text-justify">In each sub-plot soil profile (10, 30, 50 depths), will be performed with collection of soil samples (3 per sub-plot).</p>
							</li>
						</ol>
					</p>
					
					<h4>Expected achievements</h4>
					<p class="text-justify">
						<ol>
							<li>Set up of field sites to evaluate plant functional groups and groundwater dynamics in a climatic gradient;</li>
							<li>Characterization of experimental plots.</li>
					</p>
				</div>


				<div class="tab-pane fade" id="task2">
					<h2>Task 2</h2>

					<h4 class="smallspacer">Objectives</h4>
					<p class="text-justify">
						<ol>
							<li>Understand water source, groundwater use and ecophysiological responses of functional groups to changing GW.</li>
							<li>Definition of isotopic and vegetation indices that could function as short-term GW stress tracers.</li>
						</ol>
					</p>

					<h4>Rationale</h4>
					<p class="text-justify">Under scenarios of changes in GW availability, species with different root systems, and thus with different access to GW, could show different water state and responses.</p>

					<h4>Approach</h4>
					<p class="text-justify">
						All measurements of the following Task will be conducted in 2 seasons in all sites: dry and wet season (different water availability) and will consider individuals selected in task 1.3 (12 individuals persub-plot X30 subplots X3 sites x2 seasons).
						<ol>
							<li>
								<strong><em>Identification and use of water sources</em></strong>:
								<p class="text-justify">Natural 18O/16O (d18O) ratios will be used to quantify different water sources by matching the isotopic signature of plant xylem water with the available water sources signal. This method also allows identification of differential water utilization by plants.</p>
							</li>
							<li>
								<strong><em>Plant physiological performance</em></strong>:
								<p class="text-justify">Carbon isotope discrimination of leaves (D13C) will be assessed (analysis in FCUL). Additionally, it will be used vegetation indices associated with plant state: Photochemical Reflectance Index (PRI), Water Index (WI), Chlorophyll Content Index (CCI) and Normalized Difference Water Index (NDWI)- evaluated with a Spectral Analysis System (UniSpec-SC-PP of FCUL).</p>
							</li>
							<li>
								<strong><em>Plant water state through NDWI</em></strong>:
								<p class="text-justify">The canopy water content can be calculated using remote sensed data. It will be calculated a estimation of vegetation water content and Normalized Difference Water Index (NDWI) to compare the water status of canopy (and with reflectance indices at leaf level – see 2.2)  [Carvalho&Soares2006].</p>
							</li>
							<li>
								<strong><em>Integration of data according to water availability</em></strong>:
								<p class="text-justify">Integrative analysis of ecophysiological parameters in function of GW availability. For answering the question: "which factors can be used as short-term GW stress tracers?" the data collected in task 2 and GW dynamics it will be used to perform spatial and temporal statistical analysis.</p>
							</li>
						</ol>
					</p>
					
					<h4>Expected achievements</h4>
					<p class="text-justify">
						<ol>
							<li>Understand functional groups water use and how functional groups’ water state changes in a GW limitation situation;</li>
							<li>Define suitable GW short-term stress tracers.</li>
						</ol>
					</p>
				</div>


				<div class="tab-pane fade" id="task3">
					<h2>Task 3</h2>

					<h4 class="smallspacer">Objectives</h4>
					<p class="text-justify">
						<ol>
							<li>Evaluate long-term stress sensitivity of different functional groups to temporal/seasonal changes in water availability.</li>
							<li>Estimate factors that could function as GW long-term stress tracers.</li>
						</ol>
					</p>


					<h4>Rationale</h4>
					<p class="text-justify">An analysis of long-term responses is expected to provide community reaction to a temporal stress, as groundwater limitation. It is hypothesize that functional groups will respond differently according to their root system and water strategy in a temporal scale.</p>

					<h4>Approach</h4>
					<p class="text-justify">
						<ol>
							<li>
								<strong><em>Chronological water use and stress: Tree-rings as an archive tool</em></strong>:
								<p class="text-justify">Tree-ring width records are being supplemented with tree-ring stable-isotope measurements, useful for inferring and reconstructing past climate, isotope hydrology, plant ecophysiology and pollution [Olga et al., 2010]. Analysis of tree-rings will be performed in at least 3 trees in the sub-plots plots (3 treesx30 sub-plotsx3 climatic sites). This will include collecting, preparation and analysis of the samples: width analysis will be performed with appropriate software, and isotopic analysis will include d13C and d18O in bulk wood (following the PSI protocol method and IRMS analysis). This task can have the consultancy and collaboration of Prof Dr. Rolf Siegwolf (from Paul Scherrer Institut – Switzerland).</p>
							</li>
							<li>
								<strong><em>Integration of data according to water availability</em></strong>:
								<p class="text-justify">Using the data collected in task 3, it will be perform statistical analys\is considering distances to groundwater and climatic data (task 1) in a temporal scale.</p>
							</li>
						</ol>
					</p>

					<h4>Expected achievements</h4>
					<p class="text-justify">
						<ol>
							<li>Analysis of differential utilization of water and capacity of water regulation in a large temporal scale (past to present);</li>
							<li>Determination of functional groups stress sensitivity and relative growth rate patterns in changing groundwater.</li>
						</ol>
					</p>
				</div>


				<div class="tab-pane fade" id="task4">
					<h2>Task 4</h2>

					<h4 class="smallspacer">Objectives</h4>
					<p class="text-justify">
						<ol>
							<li>Integrate spatial water resource and short-/long-term groundwater stress indicators among the different climatic conditions.</li>
							<li>Project water use differences under future groundwater change.</li>
						</ol>
					</p>


					<h4>Rationale</h4>
					<p class="text-justify">It is hypothesized that groundwater stress responses will depend upon functional group to adapt to available water sources changes. Water resource use among different climatic conditions can be up-scaled and usage differences under future climate change projected.</p>
					<p class="text-justify">This task will have the consultancy and collaboration of Instituto Superior Técnico, Universidade de Lisboa.</p>

					<h4>Approach</h4>
					<p class="text-justify">
						<ol>
							<li>
								<strong><em>Groundwater modeling and stress tracers spatial pattern</em></strong>:
								<p class="text-justify">Various layers of information collected will be integrated with spatial statistics and statistical significant analysis. Distance to groundwater and the groundwater stress tracers found suitable in TASK 2 and 3 will be interpolated (choosing the best approach) within the study area (using ArcGIs and R Software). GW stress tracers will be correlated with the groundwater (spatial pattern), with appropriate statistics.</p>
							</li>
							<li>
								<strong><em>Integration of groundwater stress tracers and GW patterns: future responses prediction</em></strong>:
								<p class="text-justify">Extension of local information in space and time will be performed.  The model will be aligned with the results of Tasks2-3 for proper patterns of plant water usage and ecological assumptions (using the the best statistical approach that fits the patterns observed). Accordingly it will be produced an integrative spatial approach of groundwater stress indicators. A spatio-temporal well-validated model of ecosystem functioning under future climate change (different groundwater availability) will be developed.</p>
							</li>
						</ol>
					</p>

					<h4>Expected achievements</h4>
					<p class="text-justify">
						<ol>
							<li>Design of spatially explicit model that includes groundwater dynamics and detailed ecosystem physiology;</li>
							<li>Develop a model to evaluate community water use under future groundwater change scenarios through ecophysiological parameters.</li>
						</ol>
					</p>
				</div>

			</div>
		</div>


	</div>

	

	<?php include "../footer.php";?>

  </body>
</html>