<?php

/*define("PROJECT_URL", "http://work/groundWater/");
define("PROJECT_DOCS_CENTER", 'C:\Stuff\develop\groundWater\docs_center\\');
define("PROJECT_PROCESSED_FILES", 'C:\Stuff\develop\groundWater\docs_center\processed\\');
define("PROJECT_PATH", 'C:\Stuff\develop\groundWater\\');*/

define("PROJECT_URL",  'http://'.$_SERVER['HTTP_HOST'].'/groundwater/');
define("PROJECT_PATH", str_replace('config', '', str_replace('\\', '/', dirname(__FILE__)) ));
define("PROJECT_DOCS_CENTER", PROJECT_URL. 'docs_center/');
define("PROJECT_PROCESSED_FILES", PROJECT_DOCS_CENTER . 'processed/');