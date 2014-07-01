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
  		include "../data/species_data.php";

  		$speciesData = new Species();
  		
	    $species = array();
	    $whereClause = "";
	    $getParameters = "";

		if(isset($_GET["genusSpecies"])){
			$whereClause = " upper(s.genus) like upper('%" . $_GET["genusSpecies"] . "%') or upper(s.species) like upper('%" . $_GET["genusSpecies"] . "%')";
		   	$getParameters = "genusSpecies=" . $_GET["genusSpecies"];
			$species = $speciesData->getSpeciesBy($whereClause, (isset($_GET["page"]) ? $_GET["page"] : 0), $withTotalIndividuals = 1);

		} else {
			$species = $speciesData->getSpecies((isset($_GET["page"]) ? $_GET["page"] : 0), $withTotalIndividuals = 1); 
		}

    	$fields = $speciesData->getFieldList();
  	?>

  	<!-- incluir menu principal -->
  	<?php include "../menu.php"; ?>

    <div class="container">
      <div class="row">
      	<div class="page-header">
       		<h1>Espécies</h1>
      	</div>
      </div>
    </div>

    <!-- accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-10">
          <form  class="form-inline" role="form" name="form_searchindividual_data" action="../core/core_action.php" method="post">
            <input type="hidden" value="search" name="action">
            <input type="hidden" value="species" name="class">
            <div class="form-group">
              <input type="text" class="form-control input-sm" name="genusSpecies" placeholder="Genus ou Species" value=<?= (isset($_GET["genusSpecies"]) ? '"' . $_GET["genusSpecies"] . '"' : "") ?>>
            </div>
            <button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span> Filtrar</button>
          </form>
        </div>
        <div class="col-xs-6 col-lg-2"> 
          <!-- insercao -->
          <button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='../forms/species.php'">Inserir Espécie</button>
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
                if(count($species) > 1) {
             		foreach ($species as $specie) {
						if(isset($specie->species_id)) {
							echo '<tr>
							        <td>' . $specie->species_id . '</td>
							        <td>' . $specie->genus . '</td>
							        <td>' . $specie->species . '</td>
							        <td>' . $specie->type . '</td>
							        <td>' .$specie->code . '</td>
							        <td>' .$specie->functionalGroup . '</td>';
							if ($specie->totalIndividuals > 0) {
								echo '<td><a href="individual-list.php?species=' . $specie->species_id .  '"><span id="accessTooltip_' . $specie->species_id . '" data-toggle="tooltip" data-placement="left" title="Clica para veres os indivíduos" class="label label-default">' . $specie->totalIndividuals . '</span></a></td>';
							} else {
								echo '<td><span class="label label-default">' . $specie->totalIndividuals . '</span></td>';
							}
							
						    echo '<td>
						          	<button onclick="location.href=\'../forms/species.php?species_id=' . $specie->species_id . '\'" type="button" class="btn btn-primary btn-xs">
						          			<span class="glyphicon glyphicon-edit"></span>
						          	</button>
						        </td> 
						        <td>';
						   
					        if ($specie->totalIndividuals == 0) {
						        echo '<button onclick="beginDelete(\'action=delete&class=species&id=' . $specie->species_id . '\',\'Queres mesmo remover esta Espécie?\');" type="button" class="btn btn-danger btn-xs">
						            <span class="glyphicon glyphicon-remove-sign"></span>
						          </button>';
					        } else {
					        	echo '<span id="removeTooltip_' . $specie->species_id . '" class="label label-default" data-toggle="tooltip" data-placement="left" title="Tem indivíduos associados">É melhor não</span>'; 
					        }

						        echo '</td>
							       </tr>';
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
          <h5>Total de registos <span class="badge"><?=$species[0]->totalRecords?></span></h5>
        </div>
        <div class="col-xs-4 col-lg-4"> 
          <div class="text-center">
            <ul class="pagination">
              <?php
                //paginas
                $addPage = (($species[0]->totalRecords % $speciesData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($species[0]->totalRecords / $speciesData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="species-list.php?page=' . $newPage . ($getParameters != "" ? '&' . $getParameters : "")  . '">&laquo;</a></li>';
                  }

                  for ($i = 1; $i <= $nPages; $i++ ) {
                    $active = ((isset($_GET["page"]) && $_GET["page"] == $i)  ? 'class="active"' : (!isset($_GET["page"]) && $i == 1) ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="species-list.php?page='. $i . ($getParameters != "" ? '&' . $getParameters : "")  . '">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="species-list.php?page=' . $newPage . ($getParameters != "" ? '&' . $getParameters : "")  . '">&raquo;</a></li>';
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
	    foreach ($species as $specie) {
	    	if (isset($specie->species_id) && $specie->totalIndividuals > 0) {
		    	echo "$('#removeTooltip_" . $specie->species_id . "').tooltip({trigger: 'hover'});";
		    	if ($specie->totalIndividuals > 0) {
		    		echo "$('#accessTooltip_" . $specie->species_id . "').tooltip({trigger: 'hover'});";
		    	}
	    	}
	    }
	?>
    </script>

  </body>
</html>