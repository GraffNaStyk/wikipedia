<?php

namespace App\Facades\Parser;

use App\Model\Boss;

class Bosses
{
    public static function parse()
    {
        if (is_readable(app('bosses_path'))) {
            $bosses = json_decode(file_get_contents(app('bosses_path')));

            foreach ($bosses as $key => $boss) {
                Boss::insert([
                    'name' => $key,
                    'place' => $boss->place,
                    'min_lvl' => $boss->minLevel,
                    'max_lvl' => $boss->maxLevel,
                ]);
            }
        }
    }
}
