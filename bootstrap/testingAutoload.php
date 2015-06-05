<?php

// bootstrap/testingAutoload.php

passthru("php artisan --env='testing' migrate:refresh --seed");
require __DIR__ . '/autoload.php';