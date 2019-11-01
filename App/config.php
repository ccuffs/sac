<?php

@define('DOMAIN_URL', "http://localhost:81");
@define('PATH_URL', '/sac');
@define('BASE_URL', DOMAIN_URL . PATH_URL);

@define('IDUFFS_TOKEN', 'eyAidHlwIjogIkpXVCIsICJhbGciOiAiSFMyNTYiIH0.eyAib3RrIjogIjF1a3VvMGUybzVoZnRuNHRqNTFjaGdrazcxIiwgInJlYWxtIjogImRjPW9wZW5hbSxkYz1mb3JnZXJvY2ssZGM9b3JnIiwgInNlc3Npb25JZCI6ICJBUUlDNXdNMkxZNFNmY3hJTkJtZzFJM09sR1N1MzhlMGVSeDlXa05fUWhfNElMVS4qQUFKVFNRQUNNREVBQWxOTEFCUXROalE0TWpZMU5UZzNNekl4T0RBMk5UWXlOQUFDVXpFQUFBLi4qIiB9.wulSO8eW8lkBNm6xH06FtwV95ZI4KW6WfC-aiQj5w3s');
@define('UPLOAD_FOLDER', __DIR__ . '/../public/storage');

// Database info
@define('DB_DSN', 'mysql:host=localhost;dbname=sac;port=3307');
@define('DB_USER', 'root');
@define('DB_PASSWORD', '');

// Password
@define('PASSWORD_SALT', 'dlaejhdwieugr34712-13fkj3-122045*&@#$)*&Gkdf*%$@I&$fdfd');

// Conference
@define('CONFERENCE_PRICE', 30.0);
@define('CONFERENCE_PRICE_EXTERNAL', 50.0);


// Pagseguro
@define('PAGSEGURO_TOKEN', '46D5FDD7985541D186766294A849B82E');
@define('PAGSEGURO_EMAIL','dovyski@gmail.com');

// System params
@define('DEBUG_MODE', false);
@define('SESSION_NAME', 'saccc');
?>