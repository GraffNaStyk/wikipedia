<?php

namespace App\Facades\Parser;

use App\Model\Achievement;

class Achievements
{
    protected static array $prohibited = [
        'Haxor', 'Mixer', 'Hell Power', 'Hell Smith'
    ];
    
    public static function parse()
    {
        if (is_readable(app('achievements_path'))) {
            $achievements = json_decode(file_get_contents(app('achievements_path')));
    
            foreach ($achievements as $achievement) {
                if (in_array($achievement->name, self::$prohibited) === false) {
                    Achievement::insert([
                        'name' => $achievement->name,
                        'status_points' => $achievement->statusPoints
                    ]);
                }
            }
        }
    }
}
