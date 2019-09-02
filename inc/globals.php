<?php

@include_once dirname(__FILE__).'/config.local.php';
require_once dirname(__FILE__).'/config.php';

session_name(SESSION_NAME);
session_start();

require_once dirname(__FILE__).'/db.php';
require_once dirname(__FILE__).'/auth.php';
require_once dirname(__FILE__).'/utils.php';

?>