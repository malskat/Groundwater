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

	</head>

	<body>

	  	<!-- incluir menu principal -->
	  	<?php include "../menu.php";?>

	  	<?
		    require_once '../data/reflectance_data.php';
		    require_once '../data/campaign_data.php';

	    	$campaignData = new Campaign();
	    	$campaigns = $campaignData->getCampaigns(-1);

			$reflectanceValues = array();
		    $reflectanceData = new Reflectance();

		    $getParameters = "";

			if (isset($_GET['individualCode'])) {
				$whereClause = 'ir.individualCode = "' . $_GET['individualCode'] . '"';

			if (isset($_GET["campaign"])) {
				$whereClause .= "and ir.sampling_campaign_id = " . $_GET["campaign"];
			   	$getParameters .= "&campaign=" . $_GET["campaign"];
			}

		    	$reflectanceValues = $reflectanceData->getReflectanceBy($whereClause, $orderBy = '', isset($_GET["page"]) ? $_GET["page"] : 0);
			}

			$fields = $reflectanceData->getFieldList();

			$backUrl = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
	  		if (false === strpos($backUrl, 'individual.php') && false === strpos($backUrl, 'individual-list')) {
				$backUrl = '../lists/individual-list.php';
	  		}
		?>

	    <!-- titulo -->
	    <div class="container">
			<div class="row">
				<div class="page-header">
					<h2>
						Unispec - Reflectance
						<small>Individual - <?=(isset($_GET['individualCode']) ? $_GET['individualCode'] : 'Invalid')?></small>
					</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-lg-4">
					<button class="btn btn-link" onclick="location.href='<?=$backUrl?>'">« back</button>
				</div>

				<div class="col-xs-6 col-lg-4">
					<form  class="form-inline" role="form" name="form_searchreflectance_data" action="../core/core_action.php" method="post">
		            	<input type="hidden" value="search" name="action">
		            	<input type="hidden" value="reflectance" name="class">
		            	<input type="hidden" value="<?=$_GET['individualCode']?>" name="individualCode">
		            	<div class="form-group">
		            		<select name="campaign" class="form-control input-sm">
								<option value="none">Campaign</option>
								<?php
									foreach($campaigns as $campaign){
										echo '<option ' . (isset($_GET["campaign"]) && $campaign->sampling_campaign_id == $_GET["campaign"] ? 'selected' : '') . ' value="' . $campaign->sampling_campaign_id . '">' . $campaign->designation . '</option>';
									}
								?>
							</select>
		            	</div>
		            	<button type="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon glyphicon-search"></span> Search</button>
		          </form>
				</div>

				<div class="col-xs-6 col-lg-4"> 
		        	<div class="btn-group pull-right">
		        		<button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" <?=(!$_BIOLOGYST_LOGGED ? 'disabled="disabled"' : '')?>>
		        			Insert Unispec Reflectance <span class="caret">
		        		</button>
		        		<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="../forms/reflectance.php?individualCode=<?=$_GET['individualCode']?>"><strong>By form</strong></a></li>
							<li><a href="../forms/reflectance-csv.php?individualCode=<?=$_GET['individualCode']?>"><strong>By CSV</strong></a></li>
						</ul>
		        	</div>
		        </div>
		        
			</div>
		</div>


	    <div class="container">
	  		<div class="row spacer">
	  			<div class="col-xs-12 col-lg-12">
	  				<table class="table table-hover">
		        		<thead>
				            <tr class="active">
				              	<?
				              		foreach ($fields as $field) {
				              			echo '<th>' . $field . '</th>';
				              		}
				              	?>
				                <th>Edit</th>
				                <th>Remove</th>
				            </tr>
		            	</thead>
		            	<tbody>
		            		<?
				                if(count($reflectanceValues) > 1) {
				             		foreach ($reflectanceValues as $reflectanceValue) {
					                    if(isset($reflectanceValue->individualCode)){
					                    	echo '<tr>
					                    			<td>' . $reflectanceValue->campaignDesignation . '</td>
	      	            	    					<td>' . $reflectanceValue->file . '</td>
	      	            	    					<td>' . $reflectanceValue->c_529 . '</td>
	      	            	    					<td>' . $reflectanceValue->c_569 . '</td>
	      	            	    					<td>' . $reflectanceValue->c_680 . '</td>
	      	            	    					<td>' . $reflectanceValue->c_700 . '</td>
	      	            	    					<td>' . $reflectanceValue->creation_date . '</td>';
	      	            	    			echo '<td>
						      	                  		<button onclick="location.href=\'../forms/reflectance.php?id=' . $reflectanceValue->individual_reflectance_id . '\'" type="button" class="btn btn-primary btn-xs">
						      	                  			<span class="glyphicon glyphicon glyphicon-edit"></span>
						      	                  		</button>
						      	                  	</td>';

						      	            echo '<td>
						                              <button onclick="beginDelete(\'action=delete&class=reflectance&id=' . $reflectanceValue->individual_reflectance_id . '\', \'Do you want to remove this Unispec Reflectance (it will recalculate all reflectance indexes on the correspondent eco-physiology sample)?\');" type="button" class="btn btn-danger btn-xs">
						                                <span class="glyphicon glyphicon-remove-sign"></span>
						                              </button>
						                            </td>';


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
		          <h5>Total records <span class="badge"><?=(isset($reflectanceValues[0]) ? $reflectanceValues[0]->totalRecords : 0 )?></span></h5>
		        </div>
		        <div class="col-xs-4 col-lg-4">
		          <div class="text-center">
		            <ul class="pagination">
		              <?
		                //paginas
		                $addPage = (isset($reflectanceValues[0]) && ($reflectanceValues[0]->totalRecords % $reflectanceData->getTotalRows()) > 0 ? 1 : 0);
		                $nPages = (isset($reflectanceValues[0]) ? floor($reflectanceValues[0]->totalRecords / $reflectanceData->getTotalRows()) : 0 ) + $addPage;
		                if ( $nPages > 1) {

		                  $currentPage = (isset($_GET["page"]) ? $_GET["page"] : 1 );

		                  //botao para tras
		                  if ($currentPage == 1) {
		                    echo '<li class="disabled"><a >&laquo;</a></li>';
		                  } else {
		                    $newPage = ($currentPage - 1);
		                    echo '<li><a href="reflectance-list.php?individualCode=' . $_GET['individualCode'] . '&page=' . $newPage . ($getParameters != "" ? $getParameters : "") . '">&laquo;</a></li>';
		                  }

		                  $begin = (($currentPage - 3) > 1 ? ($currentPage - 3) :  1 ); 
		                  $end = (($currentPage + 3) < $nPages ? ($currentPage + 3) :  $nPages ); 

		                  for ($i = $begin; $i <= $end; $i++ ) {
		                    $active = ($currentPage == $i  ? 'class="active"' : "");
		                    echo '<li ' . $active . '><a href="reflectance-list.php?individualCode=' . $_GET['individualCode'] . '&page='. $i . ($getParameters != "" ? $getParameters : "") . '">' . $i . '</a></li>';
		                  }

		                  //botao para a frente
		                  if ($currentPage == $nPages) {
		                    echo '<li class="disabled"><a >&raquo;</a></li>';
		                  } else {
		                    $newPage = ($currentPage + 1);
		                    echo '<li><a href="reflectance-list.php?individualCode=' . $_GET['individualCode'] . '&page=' . $newPage . ($getParameters != "" ? $getParameters : "") . '">&raquo;</a></li>';
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

	</body>
</html>

