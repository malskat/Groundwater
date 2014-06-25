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

    <title>Projecto Ground Water</title>

    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap alerts -->
    <link href="../css/alerts.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/mainCore.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <?php 
    
		include "../data/site_data.php";
		include "../data/species_data.php";
		include "../data/plot_data.php"; 
  		include "../data/individual_data.php";

  		$individualData = new Individual();
    	$individuals = array();
      	$getParameters = "";

		if(isset($_GET["site"]) || isset($_GET["plot"]) || isset($_GET["species"]) || isset($_GET["individualCode"])) {

			$whereClause = "";

			if (isset($_GET["site"])) {
				$whereClause .= "st.site_id = " . $_GET["site"];
			   $getParameters .= "site=" . $_GET["site"];
			}

			if (isset($_GET["plot"])) {
				if ($whereClause != "") {
			   		$whereClause .= " and i.plot_id = " . $_GET["plot"];
					$getParameters .= "&plot=" . $_GET["plot"];
				} else {
			   		$whereClause .= " i.plot_id = " . $_GET["plot"];
			   		$getParameters .= "plot=" . $_GET["plot"];
				}
			}

			if (isset($_GET["species"])) {
			  if ($whereClause != "") {
			    $whereClause .= " and i.species_id = " . $_GET["species"];
			    $getParameters .= "&species=" . $_GET["species"];
			  } else {
			    $whereClause .= " i.species_id = " . $_GET["species"];
			    $getParameters .= "species=" . $_GET["species"];
			  }
			}

			if (isset($_GET["individualCode"])) {
			  if ($whereClause != "") {
			    $whereClause .= " and upper(i.individualCode) like upper('%" . $_GET["individualCode"] . "%')";
			    $getParameters .= "individualCode=" . $_GET["individualCode"];
			  } else {
			    $whereClause .= " upper(i.individualCode) like upper('%"  . $_GET["individualCode"] . "%')";
			    $getParameters .= "&individualCode=" . $_GET["individualCode"];
			  }
			}

			$individuals = $individualData->getIndividualBy($whereClause, isset($_GET["page"]) ? $_GET["page"] : 0, $withTotals = 1);
		} else {
			  $individuals = $individualData->getIndividualPlotSpecies(isset($_GET["page"]) ? $_GET["page"] : 0, $withTotals = 1);
		}

		$fields = $individualData->getFieldList();

		$siteData = new Site();
		$sites = $siteData->getSites(-1);

		$plotData = new PLot();
		if (isset($_GET["site"])) {
			$plots = $plotData->getPlotBy(' s.site_id = ' . $_GET["site"] , $page = -1);
		} else {
			$plots = $plotData->getPlotsSite(-1);
		}

		$speciesData = new Species();
		$species = $speciesData->getSpecies(-1);
  	?>
  	
    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
         		<h1>Indivíduos</h1>
        </div>
      </div>
    </div>
      
    <!-- accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-10">
          <form  class="form-inline" role="form" name="form_searchindividual_data" action="../core/core_action.php" method="post">
            <input type="hidden" value="search" name="action">
            <input type="hidden" value="individual" name="class">
            <div class="form-group">
				<select name="site" class="form-control input-sm">
					<option value="none">Site</option>
					<?php
					foreach($sites as $site){
						echo '<option ' . (isset($_GET["site"]) && $site->site_id == $_GET["site"] ? 'selected' : '') . ' value="' . $site->site_id . '">' . $site->title . '</option>';
					}
					?>
				</select>
				<select name="plot" class="form-control input-sm">
					<option value="none">Plot</option>
					<?
					  foreach($plots as $plot){
					    echo '<option ' . (isset($_GET["plot"]) && $plot->plot_id == $_GET["plot"] ? 'selected' : '') . ' value="' . $plot->plot_id . '">' . $plot->title . " - " . $plot->code . '</option>';
					  }
					?>
				</select>
            </div>
            <div class="form-group">
              <select name="species" class="form-control input-sm">
                <option value="none">Espécie</option>
                <?php
                  foreach($species as $specie){
                    echo '<option ' . (isset($_GET["species"]) && $specie->species_id == $_GET["species"] ? 'selected' : '') . ' value="' . $specie->species_id . '">' . $specie->genus . ' - ' . $specie->species . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control input-sm" name="individualCode" placeholder="Código" value=<?= (isset($_GET["individualCode"]) ? '"' . $_GET["individualCode"] . '"' : "") ?>>
            </div>
            <button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span> Filtrar </button>
          </form>
        </div>
        <div class="col-xs-6 col-lg-2"> 
          <!-- insercao -->
          <button class="btn btn-primary btn-sm pull-right" onclick="location.href='../forms/individual.php'">Inserir Indivíduo</button>
        </div>
      </div>
    </div>

    <!-- lista -->
    <div class="container">
  		<div class="row spacer">
  			<div class="col-xs-12 col-lg-12">
          		<table class="table table-hover">
	        		<thead>
		              <tr class="active">
		              	<?php
		              		foreach ($fields as $field) {
		              			echo '<th>' . $field . '</th>';
		              		}
		              	?>
		                <th>Editar</th>
		                <th>Remover</th>
		              </tr>
	            	</thead>
		            <tbody>
		          		<?php
		                if(count($individuals) > 1) {
		             		foreach ($individuals as $individual) {
			                    if(isset($individual->individualCode)){
			               			echo '<tr>
			      	            	    <td>' . $individual->individualCode . '</td>
			      	                  	<td>' . $individual->genus . ' - ' . $individual->species . '</td>
			                            <td>' . $individual->siteTitle . ' - ' . $individual->plotCode . '</td>';
			                        
			                        //eco-fisio
			                        if ($individual->totalEcoFisio > 0) {
			                        	echo '<td>
			                            		<a href="../lists/ecofisio-list.php?individualCode=' . $individual->individualCode .  '"><span class="label label-info">' . $individual->totalEcoFisio . '</span></a>
												</td>';
			                        } else {
			                        	echo '<td>
				                            	<a href="../forms/ecoFisio.php?individualCode=' . $individual->individualCode .  '"><span class="label label-default">' . $individual->totalEcoFisio . '</span></a>
											</td>';
			                        }

			                        if(isset($individual->struture_id)) {
			                        	echo '<td><a href="../forms/struture.php?individualCode=' . $individual->individualCode .  '"><span class="label label-info">Sim</span></a></td>';
			                        } else {
			                        	echo '<td><a href="../forms/struture.php?individualCode=' . $individual->individualCode .  '"><span class="label label-default">Não</span></a></td>';
			                        }

			      	                echo '<td>
			      	                  		<button onclick="location.href=\'../forms/individual.php?individualCode=' . $individual->individualCode . '\'" type="button" class="btn btn-primary btn-xs">
			      	                  			<span class="glyphicon glyphicon glyphicon-edit"></span>
			      	                  		</button>
			      	                  	</td>';

			  	                  	if ($individual->totalEcoFisio || isset($individual->struture_id) == 0) {
			                            echo '<td>
			                              <button onclick="beginDelete(\'action=delete&class=individual&id=' . $individual->individualCode . '\', \'Queres mesmo remover este Indivíduo?\');" type="button" class="btn btn-danger btn-xs">
			                                <span class="glyphicon glyphicon-remove-sign"></span>
			                              </button>
			                            </td>';
			                      	} else {
			                      		echo '<td>
			                      				<span id="removeTooltip_' . $individual->individualCode . '" class="label label-default" data-toggle="tooltip" data-placement="left" title="Tem amostragens associadas">É melhor não</span> 
			                      			</td>';
			                      	}
			      	                echo '</tr>';
			                    }
		               		}
		                } else {
		                  echo '<tr><td colspan=' . (count($fields) + 2) . ' style="text-align:center">Não existem resultados para apresentar!</td></tr>'; 
		                }
		             	?>
		            </tbody>
          		</table>
        	</div>
      	</div>
    </div>

    <!-- paginacao -->
    <div class="container">
      <div class="row">
        <div class="col-xs-4 col-lg-4">
          <h5>Total de registos <span class="badge"><?=$individuals[0]->totalRecords?></span></h5>
        </div>
        <div class="col-xs-4 col-lg-4">
          <div class="text-center">
            <ul class="pagination">
              <?php
                //paginas
                $addPage = (($individuals[0]->totalRecords % $individualData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($individuals[0]->totalRecords / $individualData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="individual-list.php?page=' . $newPage . ($getParameters != "" ? '&' . $getParameters : "") . '">&laquo;</a></li>';
                  }

                  $begin = (($currentPage - 3) > 1 ? ($currentPage - 3) :  1 ); 
                  $end = (($currentPage + 3) < $nPages ? ($currentPage + 3) :  $nPages ); 

                  for ($i = $begin; $i <= $end; $i++ ) {
                    $active = ($currentPage == $i  ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="individual-list.php?page='. $i . ($getParameters != "" ? '&' . $getParameters : "") .'">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="individual-list.php?page=' . $newPage . ($getParameters != "" ? '&' . $getParameters : "") .'">&raquo;</a></li>';
                  }

                }

              ?>
            </ul>
          </div>
        </div>
        <div class="col-xs-4 col-lg-4"></div>
      </div>
    </div>


    <script>
    <?php
	    foreach ($individuals as $individual) {
	    	if (isset($individual->individualCode) && $individual->totalEcoFisio > 0) {
		    	echo "$('#removeTooltip_" . $individual->individualCode . "').tooltip({trigger: 'hover'});";
	    	}
	    }
	?>
    </script>


  </body>
</html>