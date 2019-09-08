<?php 
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../App/Config/config.php';

session_name(SESSION_NAME);
session_start();

require __DIR__ . '/../App/Config/router.php';