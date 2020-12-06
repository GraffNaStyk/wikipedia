<?php

namespace App\Controllers\Http;

use App\Model\Achievement;

class AchievementsController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $achievements = Achievement::select('*')
            ->where(['name', '<>', 'Namek Event Fighter '])
            ->order(['status_points'])
            ->get();
        
        if (! $achievements) {
            $this->redirect('');
        }
        
        $this->render([
            'title' => 'Achievements',
            'achievements' => $achievements,
            'points' => Achievement::sumOfStatusPoints()
        ]);
    }
}
