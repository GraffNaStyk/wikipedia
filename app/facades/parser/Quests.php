<?php

namespace App\Facades\Parser;

use App\Model\Page;
use App\Model\Quest;

class Quests
{
    public static function parse()
    {
        if (is_readable(app('quests_path'))) {
            $quests = json_decode(file_get_contents(app('quests_path')));

            foreach ($quests as $quest) {
                Quest::insert([
                    'level' => $quest->level,
                    'difficulty' => $quest->difficulty,
                    'snake_points' => $quest->Wpoints,
                    'status_points' => $quest->status,
                    'cid' => $quest->ID
                ]);
        
                $id = Quest::lastId();
                
                if ((int) $id !== 0) {
                    Page::insert([
                        'title' => $quest->message,
                        'is_active' => 1,
                        'type' => 'quest',
                        'parent_id' => $id,
                        'created_by' => 1
                    ]);
                }
            }
        }
    }
}
