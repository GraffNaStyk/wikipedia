<?php

namespace App\Facades\Parser;

use App\Model\DailyTask;
use App\Model\DailyTaskReward;
use App\Model\Item;

class DailyTasks
{
    public static function parse()
    {
        if (is_readable(app('daily_task_path'))) {
            $dailyTasks = json_decode(file_get_contents(app('daily_task_path')));
            
            foreach ($dailyTasks as $task) {
                $rewards = $task->itemsRewards;
                unset($task->itemsRewards);
                
                DailyTask::insert([
                    'monster' => $task->monster,
                    'from_lvl' => $task->fLvl,
                    'to_lvl' => $task->tLvl,
                    'money' => $task->money,
                    'lvls' => $task->exp,
                    'difficulty' => $task->Difficulty
                ]);
                
                if ($rewards) {
                    $id = DailyTask::select(['id'])->where(['monster', '=', $task->monster])->findOrFail()['id'];
                    
                    foreach ($rewards as $reward) {
                        DailyTaskReward::insert([
                            'task_id' => $id,
                            'item_max_count' => $reward->itemMaxCount,
                            'item_id' => $reward->itemID,
                            'item_chance' => $reward->itemChance
                        ]);
                    }
                }
            }
            
        }
    }
}
