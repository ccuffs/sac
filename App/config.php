<?php

@define('DOMAIN_URL', "http://localhost:81");
@define('PATH_URL', '/sac');
@define('BASE_URL', DOMAIN_URL . PATH_URL);

@define('IDUFFS_TOKEN', 'eyAidHlwIjogIkpXVCIsICJhbGciOiAiSFMyNTYiIH0.eyAib3RrIjogInQyZDRrcjNxbzZwbWJqOXZ2Z3F2MG85Y3Y0IiwgInJlYWxtIjogImRjPW9wZW5hbSxkYz1mb3JnZXJvY2ssZGM9b3JnIiwgInNlc3Npb25JZCI6ICJBUUlDNXdNMkxZNFNmY3lzYVpmbE1ZMVozcUNJbEU0M0s2VlhETWE0RURxTlJPUS4qQUFKVFNRQUNNREVBQWxOTEFCUXRNalU1TVRNeU9EQXpPVFU0TmpreU9UWTJNQUFDVXpFQUFBLi4qIiB9.OusFv-SXvpmttcNTsGmizoNy8f61aEFPBaRkqwboQZA');
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
