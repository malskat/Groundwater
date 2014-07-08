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


    <div id="alert-message" class="alert-message" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  
      <p id="alert-text"></p>
    </div>

    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

	<div class="container">
		<div class="page-header">
     		<h1>State of the Art</h1>
   		</div>
	</div>

	<div class="container">
		<div class="row spacer">
			<p>
				Groundwater (GW) drawdown is of obvious importance to vegetation as reduction of water tables may sever the plants from one of their key water sources. GW lowering or surface diversions can produce dramatic changes in stand structure and species composition [1, 2], inevitably affecting GW-dependent ecosystems [e.g 3, 4]. It can induce ecological effects such as the decrease in plant species richness, changes in plant communities, performance or survival of plant species [5, 6, 7]. Sand dune habitats are particularly sensitive to GW stress, as GW is one of their primary water-source, and the stress effects are dependent on GW level variations [8, 9]. Sand dune plant communities encompass a diverse number of species that differ widely in root depth, tolerance to drought and fluctuations of the water table, and capacity to shift between seasonal varying water sources [10, 11]. This high ecological diversity can occur in different climatic regions, such is the case of Tropical, Meso-mediterranen and Mediterranean areas, where future climate change is predicted to reduce water availability, which could exacerbate GW limitation [12]. A large-climatic-scale study, covering Brazil, Portugal and Spain, would provide an excellent experimental condition to study the GW dynamics and community functioning in natural dune Forests of high ecological and economical value.
			</p>
			<p>
				An important aspect in water resource management is the potential impact of GW abstraction on dependent ecosystems [13]. The additional impact of climatic drought on GW-dependent ecosystems has become of increasing concern since climatic drought aggravates GW abstraction impacts and there are uncertainties about how GWdependent vegetation will respond over the short and long term [14, 15]. Functional groups may be affected by water distribution and availability differently [12, 16]. Analyses of the relative natural abundances of stable isotopes of carbon (13C/12C), oxygen (18O/16O) and deuterium (D/H) have been used across a wide range of scales, contributing to our understanding of plant ecology and interactions [17]. This approach can show important temporal and spatial changes in utilization of GW by vegetation [18, 19, 20]. This approach, together with plant reflectance indices and forest structure, can be a useful tool to assess plant performance and be used as a GW stress indicator.
			</p>
			<p>
				Questions still remain about the integrated effects of natural and anthropogenic alterations in GW regime on the performance and survival of plants. Successful conservation of coastal dune forests will require knowledge on the dependency of the vegetation on GW and equally on the feedback between plant functional groups and water dynamics. Thus, it is crucial to better understand specific water requirements, in order to minimize future impacts of GW limitation.  Estimation of GW limitation impacts on ecosystems is challenging because methods are commonly used with no particular attention to physiological functioning. This lack of data often leads to a difficult interpretation and/or prediction of the effects of GW dynamics under a changing environment. The use of plant functional types ecophysiological responses is essential to study and predict consequences of global change, particularly water availability, on vegetation and ecosystem processes at a global scale.
			</p>
		</div>

		<div class="row spacer">
			<p><a href=<?=PROJECT_URL . "info/objectives.php"?> class="btn btn-primary btn-sm" role="button">Project Objectives &raquo;</a></p>	
		</div>

		<div class="row">
			<hr/>
			<p><strong>References</strong></p>
			<ol>
				<li>Munoz-Reinoso J.C. 2001. Vegetation changes and groundwater abstraction in SW Donana, Spain. Journal of Hydrology 242:197-209</li>
				<li>Antunes C., Correia O., Marques da Silva J., Cruces A., Freitas M. C. Branquinho C. (2012) Factors involved in spatiotemporal dynamics of submerged macrophytes in a Portuguese coastal lagoon under Mediterranean climate. Estuarine, Coastal and Shelf Science</li>
				<li>Lammerts EJ, Maas C, Grootjans AP. 2001. Groundwater variables and vegetation in dune slacks. Ecological Engineering. 17: 1, 33-47</li>
				<li>Antonellini, M., Mollema, P. M. 2009.. Impact of groundwater salinity on vegetation species richness in the coastal pine forests and wetlands of Ravenna, Italy. Ecological Engineering DOI: 10.1016/j.ecoleng.2009.12.007</li>
				<li>Zunzunegui, M., Barradas, M. C. D., Ain-Lhout, F., Clavijo, A., and Novo, F. G. 2005. To live or to survive in donana dunes: Adaptive responses of woody species under a Mediterranean climate, Plant and Soil, 273, 77-89, 10.1007/s11104-004-6806-4</li>
				<li>Grootjans, A.P., Engelmoer, M., Hendriksma, P., Westhoff, V., 1988. Vegetation dynamics in a wet dune slack I: rare species decline on the Waddenisland of Schiermonnikoog in the Netherlands. Acta Bot. Neerl. 37, 265–278</li>
				<li>Lamontagne, S., Cook, P. G., O'Grady, A., and Eamus, D. 2005. Groundwater use by vegetation in a tropical savanna riparian zone (daly river, australia), Journal of Hydrology, 310, 280-293, DOI: 10.1016/j.jhydrol.2005.01.009</li>
				<li>Serrano L. and Zunzunegui M. 2008. The relevance of preserving temporary ponds during drought: hydrological and vegetation changes over a 16-year period in the Donana National Park (south-west Spain). Aquatic Conserv: Mar. Freshw. Ecosyst. 18: 261–279</li>
				<li>Busch, D. E., Ingraham, N. L., and Smith, S. D.: Water-uptake in woody riparian phreatophytes of the southwestern united-states - a stable isotope study, Ecological Applications, 2, 450-459</li>
				<li>Muñoz Vallés S., Gallego Fernández J.B., Dellafiore C., Cambrollé J. 2011. Effects on soil, microclimate and vegetation of the nativeinvasive Retama monosperma (L.) in coastal dunes. Plant Ecology 212, 2 :169-179. DOI: 10.1007/s11258-010-9812-z</li>
				<li>Murray, B. R., Zeppel, M. J. B., Hose, G. C., and Eamus, D.: Groundwater-dependent ecosystems in australia: It's more than just water for rivers, Ecological Management & Restoration 4: 4</li>
				<li>Barradas, M. C. D., Zunzunegui, M., Tirado, R., Ain-Lhout, F., and Novo, F. G. 1999. Barradas, M. C. D., Zunzunegui, M., Tirado, R., Ain-Lhout, F., and Novo, F. G.: Plant functional types and ecosystem function in mediterranean shrubland, Journal of Vegetation Science, 10, 709-716</li>
				<li>Froend, R. and Sommer B. 2010. Phreatophytic vegetation response to climatic and abstraction induce groundwater drawdown: Examples of long-term spatial and temporal variability in community response. Ecological Engineering. 36, 1191–1200</li>
				<li>Munoz-Reinoso and Garcia Novo F. 2005. Multiscale control of vegetation patterns: the case of Don˜ana (SW Spain). Landscape Ecology 20: 51–61</li>
				<li>Corona M: G., Martin Vicente A., and Garcia Novo F. 1988. . Long-term vegetation changes on the stabilized dunes of Donana National Park. Vegetatio 75: 73-80</li>
				<li>Werner C. & Máguas C. 2010. Carbon isotope discrimination as a tracer of functional traits in a mediterranean macchia plant community. Functional Plant Biology, 37 (5): 467-477</li>
				<li>Werner C., Badeck F., Brugnoli E., Cohn B., Cuntz M., Dawson T., Gessler A., Ghashghaie J., Grams T.E.E., Kayler Z., Keitel C., Lakatos M., Lee X., Máguas C., Ogée J., Rascher K.G., Schnyder H., Siegwolf R., Unger S., Welker J., Wingate L. & Zeeman M.J. 2011. Linking carbon and water cycles using stable isotopes across scales: progress and challenges. Biogeosciences 8(2): 2659-2719</li>
				<li>Olga V. Sidorova, Rolf T. W. Siegwolf, Matthias Saurer, Mukhtar M. Naurzbaev, Alexander V. Shashkin, Eugene A. Vaganov (2010)  Spatial patterns of climatic changes in the Eurasian north reflected in Siberian larch tree-ring parameters and stable isotopes. Global Change Biology, Vol. 16 (3): 1003-1018</li>
				<li>Máguas C., Rascher K.G., Martins-Loução M.A., Carvalho P., Pinho P., Ramos M., Correia O. & Werner C. 2011. Responses of woody species to spatial and temporal ground water changes in coastal sand dune systems. Biogeosciences 8: 3823-3832</li>
				<li>Racher K.G, Hellmann C., Máguas C. & Werner C. 2012. Community scale 15N isoscapes: tracing the spatial impact of an exotic N2- fixing invader. Ecology Letters 15: 484–491. DOI: 10.1111/j.1461-0248.2012.01761.x</li>
			</ol>
		</div>
	</div>

	

	<?php include "../footer.php";?>

  </body>
</html>