<?php

namespace App\Controllers\Http;

use App\Facades\Url\Url;
use App\Helpers\QuestHelper;
use App\Model\Quest;

class QuestsController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
        $this->set(['title' => 'Quest list']);
    }
    
    public function index()
    {
        $quests = Quest::select(['quests.*', 'p.title', 'p.id as quest_id'])
            ->leftJoin(['pages as p', 'p.parent_id', '=', 'quests.id'])
            ->where(['p.type', '=', 'quest'])
            ->where(['p.is_active', '=', '1'])
            ->order(['level'], 'asc')
            ->get();

        foreach ($quests as $key => $quest) {
            $quests[$key]['link'] = 'pages/show/'.$quest['quest_id'].'/'.Url::link($quest['title']);
            $quests[$key]['difficulty'] = QuestHelper::setDifficulty($quest['difficulty']);
        }
        
        return $this->render([
            'quests' => $quests,
            'snake_count' => Quest::getSnakeSum(),
            'status_count' => Quest::getStatusSum()
        ]);
    }
}
