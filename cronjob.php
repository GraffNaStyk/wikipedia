<?php

use App\Facades\Migrations\Migration;

if ((string) php_sapi_name() !== 'cli') {
    header('location: index.php');
}

require_once __DIR__.'/index.php';

$job = Migration::dispatch($argv);

if ($job->do('parser')) {
    App\Facades\Parser\Items::parse();
    exit;
}
