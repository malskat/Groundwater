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
  </head>

  <body>

    <?php


  		if ($_BIOLOGYST_LOGGED === false) {
  			header('Location: ' . PROJECT_URL . 'index.php?response=-1');
  			die;
  		}

		include "../data/campaign_data.php";
		include "../data/site_data.php";
		include "../data/season_data.php";

		$seasonData = new Season();
		$siteData = new Site();
		$campaignData = new Campaign();


		$campaigns = array();
		$getParameters = "";
		if (isset($_GET["site"]) || isset($_GET["designation"]) || isset($_GET["season"])){
			$whereClause = "";

			if(isset($_GET["site"])){
			   $whereClause .= "sc.site_id = " . $_GET["site"];
			   $getParameters .= "site=" . $_GET["site"];
			}

			if(isset($_GET["season"])){
				if ($whereClause != "") {
				   $whereClause .= " and sc.season_id = " . $_GET["season"];
				   $getParameters .= "&season=" . $_GET["season"];
				} else {
					$whereClause .= " sc.season_id = " . $_GET["season"];
					$getParameters .= "season=" . $_GET["season"];
				}

			}

			if(isset($_GET["designation"])){
				if ($whereClause != "") {
					$whereClause .= " and upper(sc.designation) like upper('%" . $_GET["designation"] . "%')";
					$getParameters .= "designation=" . $_GET["designation"];
				} else {
					$whereClause .= " upper(sc.designation) like upper('%"  . $_GET["designation"] . "%')";
					$getParameters .= "&designation=" . $_GET["designation"];
				}
			}

			$campaigns = $campaignData->getCampaignBy($whereClause, (isset($_GET["page"]) ? $_GET["page"] : 0), $withTotals = 1);

		} else {
			$campaigns = $campaignData->getCampaigns((isset($_GET["page"]) ? $_GET["page"] : 0), $withTotals = 1);
		}

		$sites = $siteData->getSites(-1);
		$seasons = $seasonData->getSeasons(-1);
		$fields = $campaignData->getFieldList();
  	?>
  	
    <!-- incluir menu principal -->
    <?php include "../menu.php";?>

    <!-- titulo -->
    <div class="container">
      <div class="row">
      	<div class="page-header">
         		<h1>Campaigns</h1>
        </div>
      </div>
    </div>


    <!-- barra de accoes -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-10">
          <form  class="form-inline" role="form" name="form_searchcampaign_data" action="../core/core_action.php" method="post">
            <input type="hidden" value="search" name="action">
            <input type="hidden" value="campaign" name="class">
            <div class="form-group">
              <input type="text" class="form-control input-sm" name="designation" placeholder="Title" value=<?= (isset($_GET["designation"]) ? '"' . $_GET["designation"] . '"' : "") ?>>
            </div>
            <!--filtro de site -->
            <div class="form-group">
              <select name="site" class="form-control input-sm">
                <option value="none">Site</option>
                <?php
                  foreach($sites as $site){
                    echo '<option ' . (isset($_GET["site"]) && $site->site_id == $_GET["site"] ? 'selected' : '') . ' value="' . $site->site_id . '">' . $site->title . '</option>';
                  }
                ?>
              </select>
            </div>
             <!--filtro de season -->
            <div class="form-group">
              <select name="season" class="form-control input-sm">
                <option value="none">Season</option>
                <?php
                  foreach($seasons as $season){
                    echo '<option ' . (isset($_GET["season"]) && $season->season_id == $_GET["season"] ? 'selected' : '') . ' value="' . $season->season_id . '">' . $season->code . '</option>';
                  }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
          </form>
        </div>
        <div class="col-xs-6 col-lg-2"> 
          <button class="btn btn-primary btn-sm pull-right" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?> onclick="location.href='../forms/campaign.php'">Insert Campaign</button>
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
                <th>Edit</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody>
            <?php
            	if(count($campaigns) > 1) {
	                foreach ($campaigns as $campaign) {
	                	if(isset($campaign->sampling_campaign_id)){
		                    echo '<tr>
		                        <td>' . $campaign->sampling_campaign_id . '</td>
		                        <td>' . $campaign->designation . '</td>
	                        	<td>' . $campaign->siteTitle . '</td>
	                         	<td>' . $campaign->seasonCode . '</td>
		                        <td>' . $campaign->startDate . '</td>
		                        <td>' . $campaign->endDate . '</td>
		                        <td><span class="label label-default">' . $campaign->totalEcoFisio . '</span></td>
		                        <td><span class="label label-default">' . $campaign->totalReflectance . '</span></td>
		                       	<td>
	                            	<button onclick="location.href=\'../forms/campaign.php?campaign_id=' . $campaign->sampling_campaign_id . '\'" type="button" class="btn btn-primary btn-xs">
	                                	<span class="glyphicon glyphicon glyphicon-edit"></span>
	                            	</button>
	                            </td>';
	                            if ($campaign->totalEcoFisio == 0) {
	                            	echo '<td>
			                            	<button onclick="beginDelete(\'action=delete&class=campaign&id=' . $campaign->sampling_campaign_id . '\', \'Do you want to remove this Campaign?\');" type="button" class="btn btn-danger btn-xs">
			                                	<span class="glyphicon glyphicon-remove-sign"></span>
			                              </button>
				                        </td>';
	                            } else {
									echo '<td>
											<span id="removeTooltip_' . $campaign->sampling_campaign_id . '" class="label label-default" data-toggle="tooltip" data-placement="left" title="It has Eco-Physiology samples associated">Better not</span>
										</td>'; 
	                            }
	                            
		                    echo '</tr>';
	               		}
	                }
	            } else {
	            	echo '<tr><td colspan=' . (count($fields) + 2) . ' style="text-align:center">No data to show!</td></tr>';
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
          <h5>Total records <span class="badge"><?=$campaigns[0]->totalRecords?></span></h5>
        </div>
        <div class="col-xs-4 col-lg-4"> 
          <div class="text-center">
            <ul class="pagination">
              <?php
                //paginas
                $addPage = (($campaigns[0]->totalRecords % $campaignData->getTotalRows()) > 0 ? 1 : 0);
                $nPages = floor($campaigns[0]->totalRecords / $campaignData->getTotalRows()) + $addPage;
                if ( $nPages > 1) {

                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

                  //botao para tras
                  if ($currentPage == 1) {
                    echo '<li class="disabled"><a >&laquo;</a></li>';
                  } else {
                    $newPage = ($currentPage - 1);
                    echo '<li><a href="campaign-list.php?page=' . $newPage . '">&laquo;</a></li>';
                  }

                  for ($i = 1; $i <= $nPages; $i++ ) {
                    $active = ((isset($_GET["page"]) && $_GET["page"] == $i)  ? 'class="active"' : (!isset($_GET["page"]) && $i == 1) ? 'class="active"' : "");
                    echo '<li ' . $active . '><a href="campaign-list.php?page='. $i . '">' . $i . '</a></li>';
                  }

                  //botao para a frente
                  if ($currentPage == $nPages) {
                    echo '<li class="disabled"><a >&raquo;</a></li>';
                  } else {
                    $newPage = ($currentPage   + 1);
                    echo '<li><a href="campaign-list.php?page=' . $newPage . '">&raquo;</a></li>';
                  }

                }

              ?>
            </ul>
          </div>
        </div>
        <div class="col-xs-4 col-lg-4"></div>
      </div>
    </div>

	<?php include "../footer.php";?>
	<script>
    <?php
	    foreach ($campaigns as $campaign) {
	    	if (isset($campaign->sampling_campaign_id) && $campaign->totalEcoFisio > 0) {
		    	echo "$('#removeTooltip_" . $campaign->sampling_campaign_id . "').tooltip({trigger: 'hover'});";
	    	}
	    }
	?>
    </script>

  </body>
</html>