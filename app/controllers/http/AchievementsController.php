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
