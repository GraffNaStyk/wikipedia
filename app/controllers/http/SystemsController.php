<?php

namespace App\Controllers\Http;

use App\Model\DailyTask;
use App\Model\DailyTaskReward;
use App\Model\ExtremeTask;
use App\Model\ExtremeTaskReward;

class SystemsController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function dailyTask()
    {
        $this->set(['title' => 'Daily tasks']);
        
        $tasks = DailyTask::select(['daily_tasks.*', 'img.hash', 'img.path', 'img.ext', 'm.id as monster_id'])
            ->join(['monsters as m', 'm.name', '=', 'daily_tasks.monster'])
            ->join(['images as img', 'm.cid', '=', 'img.cid'])
            ->get();
        
        $rewards = DailyTaskReward::select(['daily_tasks_rewards.*', 'img.hash', 'img.path', 'img.ext', 'i.name as item_name'])
            ->join(['items as i', 'i.cid', '=', 'item_id'])
            ->join(['images as img', 'i.cid', '=', 'img.cid'])
            ->get();
        
        foreach ($tasks as $key => $task) {
            foreach ($rewards as $reward) {
                if ((int) $task['id'] === (int) $reward['task_id']) {
                    $tasks[$key]['rewards'][] = $reward;
                }
            }
        }

        return $this->render(['daily' => $tasks]);
    }
    
    public function extremeTask()
    {
        $this->set(['title' => 'Extreme tasks']);
    
        $tasks = ExtremeTask::select(['extreme_tasks.*', 'img.hash', 'img.path', 'img.ext', 'm.id as monster_id'])
            ->join(['monsters as m', 'm.name', '=', 'extreme_tasks.monster'])
            ->join(['images as img', 'm.cid', '=', 'img.cid'])
            ->get();
    
        $rewards = ExtremeTaskReward::select(['extreme_tasks_rewards.*', 'img.hash', 'img.path', 'img.ext', 'i.name as item_name'])
            ->join(['items as i', 'i.cid', '=', 'item_id'])
            ->join(['images as img', 'i.cid', '=', 'img.cid'])
            ->get();
    
        foreach ($tasks as $key => $task) {
            foreach ($rewards as $reward) {
                if ((int) $task['id'] === (int) $reward['task_id']) {
                    $tasks[$key]['rewards'][] = $reward;
                }
            }
        }
        
        return $this->render(['extreme' => $tasks]);
    }
    
    public function status()
    {
        $this->render([
            'title' => 'Status system'
        ]);
    }
}
