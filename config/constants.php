<?php

define("PROJECT_URL",  'http://' . $_SERVER['HTTP_HOST'] . '/');
define("PROJECT_PATH", str_replace('config', '', str_replace('\\', '/', dirname(__FILE__)) ));
define("PROJECT_DOCS_CENTER", PROJECT_PATH . 'docs_center/');
define("PROJECT_PROCESSED_FILES", PROJECT_DOCS_CENTER . 'processed/');

define("PROJECT_LOGGED_PERMITED_TIME", 300);