<?php

use \App\Facades\Dispatcher\Dispatcher;

require_once __DIR__.'/index.php';

$job = Dispatcher::dispatch($argv);

$job->register(['parser']);

if ($job->do('parser')) {
    App\Facades\Parser\Items::parse();
}

$job->end();
