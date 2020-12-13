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
    
    private static array $toContinue = [
        'hash', 'path', 'ext', 'id', 'name', 'cid', 'type', 'description'
    ];
    
    private static array $mapValues = [
        'skill_shield' => 'defense',
        'skill_fist' => 'attack speed',
        'skill_club' => 'train points',
        'skill_fish' => 'energy',
        'skill_dist' => 'ki blasting',
        'skill_axe' => 'strength',
        'magic_lvl_points' => 'ki lvl'
    ];
    
    public static function prepare(string $type): array
    {
        $return = [];
        
        switch ($type) {
            case 'balls':
                $return['items'] = Item::select([...self::$tableHeaders[$type], ...['i.path', 'i.hash', 'i.ext']])
                    ->leftJoin(['images as i', 'items.cid', '=', 'i.cid'])
                    ->where(['items.name', '<>', 'Small stone'])
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
                    ->where(['attack', '<=', 100])
                    ->where(['i.name', '<>', 'C16 Band'])
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
    
    public static function prepareForView($item)
    {
        foreach ($item as $key => $value) {
            if (! in_array($key, self::$toContinue)) {
                if (isset(self::$mapValues[$key])) {
                    $item['attr'][self::$mapValues[$key]] = $value;
                } else {
                    $item['attr'][str_replace('_', ' ', $key)] = $value;
                }
                unset($item[$key]);
            }
        }
        
        return $item;
    }
}
