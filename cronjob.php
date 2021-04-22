<?php

use \App\Facades\Dispatcher\Dispatcher;

require_once __DIR__.'/index.php';

$job = Dispatcher::dispatch($argv);

$job->register(['parser', 'parse']);

if ($job->do('parser') || $job->do('parse')) {
    App\Facades\Parser\Items::parse();
    \App\Facades\Parser\Movements::parse();
    \App\Facades\Parser\Spells::parse();
    \App\Facades\Parser\Monsters::parse();
    \App\Facades\Parser\Npcs::parse();
    \App\Facades\Parser\Quests::parse();
    \App\Facades\Parser\Achievements::parse();
    \App\Facades\Parser\Saga::parse();
    \App\Facades\Parser\Bosses::parse();
    \App\Facades\Parser\DailyTasks::parse();
    \App\Facades\Parser\ExtremeTasks::parse();
    \App\Facades\Parser\Transforms::parse();
    \App\Facades\Parser\Task::parse();
}

$job->end();
