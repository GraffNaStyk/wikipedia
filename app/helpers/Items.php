<?php

namespace App\Helpers;

use App\Model\Item;

class Items
{
    private static array $tableHeaders = [
        'balls' => ['name', 'level', 'attack', 'defense', 'range', 'description'],
        'armors' => ['name', 'level', 'armor', 'description'],
        'weapons' => ['name', 'level', 'attack', 'defense', 'description'],
    ];
    
    public static function prepare(string $type): array
    {
        $return = [];
        
        switch ($type) {
            case 'balls':
                $return['items'] = Item::select([...self::$tableHeaders[$type], ...['i.path', 'i.hash', 'i.ext']])
                    ->leftJoin(['images as i', 'items.cid', '=', 'i.cid'])
                    ->where(['type', '=', $type])
                    ->where(['attack', '<>', 0])
                    ->order(['attack'])
                    ->get();
                $return['headers'] = self::$tableHeaders[$type];
                $return['subType'] = 'balls';
                $return['headerCount'] = count(self::$tableHeaders[$type]);
                break;
            case 'armors':
            case 'legs':
            case 'boots':
            case 'helmets':
            case 'belts':
            case 'robes':
            $return['items'] = Item::select([...self::$tableHeaders['armors'], ...['i.path', 'i.hash', 'i.ext']])
                    ->leftJoin(['images as i', 'items.cid', '=', 'i.cid'])
                    ->where(['type', '=', $type])
                    ->where(['armor', '<>', 0])
                    ->order(['armor'])
                    ->get();
            $return['headers'] = self::$tableHeaders['armors'];
            $return['subType'] = 'armors';
            $return['headerCount'] = count(self::$tableHeaders['armors']);
                break;
            case 'swords':
            case 'glovers':
            case 'bands':
            $return['items'] = Item::select([...self::$tableHeaders['weapons'], ...['i.path', 'i.hash', 'i.ext']])
                    ->leftJoin(['images as i', 'items.cid', '=', 'i.cid'])
                    ->where(['type', '=', $type])
                    ->where(['attack', '<>', 0])
                    ->order(['attack'])
                    ->get();
            $return['headers'] = self::$tableHeaders['weapons'];
            $return['subType'] = 'weapons';
            $return['headerCount'] = count(self::$tableHeaders['weapons']);
                break;
        }
        
        $return['title'] = ucfirst($type);
        return $return;
    }
}
