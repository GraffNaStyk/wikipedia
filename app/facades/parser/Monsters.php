<?php

namespace App\Facades\Parser;

class Monsters
{
    protected static array $monsters = [];
    protected static int $iterator = 0;
    
    public static function parse()
    {
        if (file_exists(app('monsters_path'))) {
            foreach (simplexml_load_file(app('monsters_path')) as $key => $item) {
                $item = get_object_vars($item);
                if (is_file($file = dirname(app('monsters_path')).'/'.$item['@attributes']['file'])) {
                    $monster = get_object_vars(simplexml_load_file($file));
                    
                    self::basic($monster['@attributes']);
                    self::health(get_object_vars($monster['health']));
                    self::loot(get_object_vars($monster['loot'])['item']);
                    
                    self::$iterator++;
                }
               
            }

        } else {
            exit('file not exist');
        }
    }
    
    protected static function basic($monster)
    {
        self::$monsters[self::$iterator] = [
            'name' => $monster['name'],
            'experience' => $monster['experience'],
            'race' => $monster['race'],
            'speed' => $monster['speed'],
        ];
    }
    
    protected static function health($monster)
    {
        self::$monsters[self::$iterator]['health'] = $monster['@attributes']['max'];
    }
    
    protected static function loot($monster)
    {
        self::$monsters[self::$iterator]['loot'] = $monster['@attributes']['max'];
    }
}
