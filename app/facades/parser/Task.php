<?php

namespace App\Facades\Parser;

use App\Model\TaskReward;

class Task
{
    public static function parse()
    {
        if (is_readable(app('task_system_path'))) {
            $tasks = json_decode(file_get_contents(app('task_system_path')));

            foreach ($tasks as $task) {
                $rewards = $task->rewards;
                unset($task->rewards);
        
                \App\Model\Task::insert([
                    'monster' => $task->raceName,
                    'kills' => (int) $task->killsRequired,
                ]);
        
                if ($rewards) {
                    $id = \App\Model\Task::select(['id'])->where(['monster', '=', $task->raceName])->findOrFail()['id'];
            
                    foreach ($rewards as $reward) {
                        TaskReward::insert([
                            'task_id' => $id,
                            'enable' => $reward->enable,
                            'values' => $reward->values,
                            'type' => $reward->type,
                        ]);
                    }
                }
            }
        }
    }
}
