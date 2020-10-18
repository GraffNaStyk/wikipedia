<?php

namespace App\Helpers;

use App\Model\Item;

class Items
{
    private static array $tableHeaders = [
        'balls' => ['name', 'attack', 'defense', 'range', 'description'],
        'armors' => ['name', 'armor', 'description'],
        'weapons' => ['name', 'attack', 'defense', 'description'],
    ];
    
    public static function prepare(string $type): array
    {
        $return = [];
        
        switch ($type) {
            case 'balls':
                $return['items'] = Item::select(self::$tableHeaders[$type])
                    ->where(['type', '=', $type])
                    ->where(['attack', '<>', 0])
                    ->order('attack')
                    ->get();
                $return['headers'] = self::$tableHeaders[$type];
                $return['subType'] = 'balls';
                break;
            case 'armors':
            case 'legs':
            case 'boots':
            case 'helmets':
            case 'belts':
            case 'robes':
            $return['items'] = Item::select(self::$tableHeaders['armors'])
                    ->where(['type', '=', $type])
                    ->where(['armor', '<>', 0])
                    ->order('armor')
                    ->get();
            $return['headers'] = self::$tableHeaders['armors'];
            $return['subType'] = 'armors';
                break;
            case 'swords':
            case 'glovers':
            case 'bands':
            $return['items'] = Item::select(self::$tableHeaders['weapons'])
                    ->where(['type', '=', $type])
                    ->where(['attack', '<>', 0])
                    ->order('attack')
                    ->get();
            $return['headers'] = self::$tableHeaders['weapons'];
            $return['subType'] = 'weapons';
                break;
        }
        
        $return['title'] = ucfirst($type);
        return $return;
    }
}
