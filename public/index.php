<?php 
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../App/config.php';

session_name(SESSION_NAME);
session_start();

require __DIR__ . '/../App/router.php';