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
        'magic_lvl_points' => 'ki lvl',
        'hit_points' => 'max health points'
    ];
    
    private static array $attr  = [
        'increase_healing_value', 'increase_psychical_percent', 'magic_points_percent',
        'absorb_percent_all', 'health_gain', 'mana_gain', 'absorb_percent_psychical',
        'absorb_percent_magic', 'max_hit_points', 'max_mana_points', 'increase_magic_percent',
        'increase_magic_value'
    ];
    
    public static function prepare(string $type): array
    {
        $return = [];
        
        switch ($type) {
            case 'balls':
                $return['items'] = Item::select([...self::$attr, ...self::$tableHeaders[$type], ...['i.path', 'i.hash', 'i.ext']])
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
            $return['items'] = Item::select([...self::$attr, ...self::$tableHeaders['armors'], ...['i.path', 'i.hash', 'i.ext']])
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
            $return['items'] = Item::select([...self::$attr, ...self::$tableHeaders['weapons'], ...['i.path', 'i.hash', 'i.ext']])
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
    
        $return['items'] = static::parseAttrToDescription($return['items']);
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
    
    private static function parseAttrToDescription($items): array
    {
        foreach ($items as $key => $item) {
            foreach ($item as $attr => $value) {
                if (in_array($attr, self::$attr)) {
                    if ((string) $value!== '') {
                        
                        if (isset($items[$key]['description'])) {
                            $items[$key]['description'] .= '<br>';
                        }
                        
                        if (isset(self::$mapValues[$attr])) {
                            $items[$key]['description'] .= self::$mapValues[$attr] . ': ' . $value;
                        } else {
                            $items[$key]['description'] .= str_replace('_', ' ', $attr) . ': ' . $value;
                        }
                    }
                    
                    unset($items[$key][$attr]);
                }
            }
        }

        return $items;
    }
}
