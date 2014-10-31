<?php

@include_once dirname(__FILE__).'/config.local.php';
require_once dirname(__FILE__).'/config.php';

session_start();
session_name(SESSION_NAME);

require_once dirname(__FILE__).'/db.php';
require_once dirname(__FILE__).'/auth.php';
require_once dirname(__FILE__).'/user.php';
require_once dirname(__FILE__).'/attending.php';
require_once dirname(__FILE__).'/event.php';
require_once dirname(__FILE__).'/payment.php';
require_once dirname(__FILE__).'/competition.php';
require_once dirname(__FILE__).'/view.php';
require_once dirname(__FILE__).'/utils.php';

?>