<?php

@define('DOMAIN_URL', "http://localhost:81");
@define('PATH_URL', '/sac');
@define('BASE_URL', DOMAIN_URL . PATH_URL);

@define('IDUFFS_TOKEN', 'eyAidHlwIjogIkpXVCIsICJhbGciOiAiSFMyNTYiIH0.eyAib3RrIjogInR0MXNlamVhbjdiZGkyMDlncXU3N2lsMjgiLCAicmVhbG0iOiAiZGM9b3BlbmFtLGRjPWZvcmdlcm9jayxkYz1vcmciLCAic2Vzc2lvbklkIjogIkFRSUM1d00yTFk0U2ZjejBhN3dSdnZVNEJZVVVWaXcxRFBPdXNKeXRuX041U0ZJLipBQUpUU1FBQ01ERUFBbE5MQUJRdE56RTVPRE01TnpVME9UZzVOelUyTXpVd01RQUNVekVBQUEuLioiIH0.3qE1kcqPdwKPYLa6sobJ1Sm5h1jyHOat_gWfa-5Jyrk');
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
