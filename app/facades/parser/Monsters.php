<?php

namespace App\Facades\Parser;

use App\Model\CtMonsterLoot;
use App\Model\Monster;

class Monsters
{
    protected static array $monsters = [];
    protected static int $iterator = 0;
    const MAX_DROP_CHANCE = 65535;
    const RATE_LOOT = 1.0;
    
    public static function parse()
    {
        if (file_exists(app('monsters_path'))) {
            foreach (simplexml_load_file(app('monsters_path')) as $key => $item) {
                $item = get_object_vars($item);
                if (is_file($file = dirname(app('monsters_path')).'/'.$item['@attributes']['file'])) {
                    $monster = get_object_vars(simplexml_load_file($file));
                    
                    self::basic($monster['@attributes']);
                    self::health(get_object_vars($monster['health']));
                    self::loot(get_object_vars($monster['loot']));
                    
                    self::$iterator++;
                }
            }
        } else {
            exit('file not exist');
        }
        
        foreach (self::$monsters as $monster) {
            $tmp = $monster['loot'];
            unset($monster['loot']);
            Monster::insert($monster);
            
            if ($tmp) {
                $monsterId = Monster::lastId();
                if ((int) $monsterId !== 0) {
                    foreach ($tmp as $item) {
                        CtMonsterLoot::insert([
                            'item_id' => $item['id'],
                            'count' => $item['count'],
                            'chance' => $item['chance'],
                            'monster_id' => $monsterId
                        ]);
                    }
                }
            }
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
        foreach ($monster['item'] as $item) {
            $item = get_object_vars($item);
            self::$monsters[self::$iterator]['loot'][] = [
                'id' => $item['@attributes']['id'],
                'count' => $item['@attributes']['countmax'],
                'chance' => self::getChance($item['@attributes']['chance']),
            ];
            
            if (isset($item['inside'])) {
                $inside = get_object_vars($item['inside'])['item'];
                
                foreach ($inside as $insideItem) {
                    $item = get_object_vars($insideItem);
                    
                    self::$monsters[self::$iterator]['loot'][] = [
                        'id' => $item['@attributes']['id'],
                        'count' => $item['@attributes']['countmax'],
                        'chance' => self::getChance($item['@attributes']['chance']),
                    ];
                }
            }
        }
    }
    
    protected static function getChance(int $value=null)
    {
        if ($value === null) {
            return null;
        }
        
        if ($value > self::MAX_DROP_CHANCE) {
            return 100;
        }  else {
           return round((($value / self::MAX_DROP_CHANCE ) * 100) * self::RATE_LOOT, 3);
        }
    }
}
