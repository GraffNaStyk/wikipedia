<?php

namespace App\Facades\Parser;

use App\Model\DailyTask;
use App\Model\DailyTaskReward;
use App\Model\ExtremeTask;
use App\Model\ExtremeTaskReward;
use App\Model\Item;

class ExtremeTasks
{
    public static function parse()
    {
        if (is_readable(app('extreme_task_path'))) {
            $extremeTasks = json_decode(file_get_contents(app('extreme_task_path')));

            foreach ($extremeTasks as $task) {
                $rewards = $task->itemsRewards;
                unset($task->itemsRewards);
                
                ExtremeTask::insert([
                    'monster' => $task->monster,
                    'normal_exp' => (int) $task->exp1,
                    'special_exp' => (int) $task->exp2,
                    'kills' => (int) $task->kills,
                    'difficulty' => (int) $task->Difficult
                ]);
                
                if ($rewards) {
                    $id = ExtremeTask::select(['id'])->where(['monster', '=', $task->monster])->findOrFail()['id'];
                    
                    foreach ($rewards as $reward) {
                        ExtremeTaskReward::insert([
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
