<?php

namespace App\Helpers;

use App\Model\DailyTask;

class System
{
    public static function factory(): array
    {
        return [
            'daily_tasks' => (bool) DailyTask::select(['id'])->where(['id', '=', 1])->findOrFail(),
        ];
    }
}
