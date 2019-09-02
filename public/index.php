<?php 
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../config/config.php';

session_name(SESSION_NAME);
session_start();

require __DIR__ . '/../config/router.php';