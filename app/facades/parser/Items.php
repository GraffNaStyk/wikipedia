<?php

namespace App\Facades\Parser;

use App\Model\Item;

class Items extends Facade
{
    protected static array $itemTypes = [
        'sword', 'distance', 'axe', 'fist',
        'body', 'legs', 'feet', 'head', 'ring',
        'necklace'
    ];
    
    protected static array $attributes = [
        'attack', 'defense', 'armor',
        'description', 'range', 'weight',
//        'extradef', 'hitChance', 'increaseMagicValue',
//        'maxhitpoints', 'maxmanapoints', 'speed',
//        'increaseHealingPercent', 'increaseMagicPercent'
    ];
    
    protected static array $mapTypeToModel = [
        'sword' => 'swords',
        'distance' => 'balls',
        'axe' => 'glovers',
        'fist' => 'bands',
        'body' => 'armors',
        'legs' => 'legs',
        'feet' => 'boots',
        'head' => 'helmets',
        'ring' => 'belts',
        'necklace' => 'robes'
    ];
    
    protected static array $return = [];
    
    public static function parse()
    {
        $others = [];
        if (is_readable(app('items_path'))) {
            foreach (simplexml_load_file(app('items_path')) as $key => $item) {
                $item = get_object_vars($item);
                $key = self::isInTypes($item);
                
                if ((bool) $key === true) {
                    self::$return[$key][] = self::getAttributes($item);
                } else {
                    $others[] = $item;
                }
            }
        } else {
            exit('file not exist');
        }
        
        foreach (self::$return as $key => $items) {
            foreach ($items as $item) {
                $item['type'] = self::$mapTypeToModel[$key];
                Item::insert($item);
                self::getImage((int) $item['cid'], $item['name'], 'items');
            }
        }
        
        self::parseOtherItems($others);
    }
    
    protected static function isInTypes($item)
    {
        if (!isset($item['attribute'])) {
            return false;
        }
        
        $key = false;
        
        foreach ($item['attribute'] as $attr) {
            $attr = get_object_vars($attr['value'])[0];
            
            if (in_array($attr, self::$itemTypes)) {
                $key = $attr;
                break;
            }
        }
        
        return $key;
        
    }
    
    protected static function getAttributes($item)
    {
        $return = [
            'name' => $item['@attributes']['name'],
            'cid' => (int) $item['@attributes']['id']
        ];

        foreach ($item['attribute'] as $attr) {
            $attr = get_object_vars($attr)['@attributes'];
            
            if (in_array($attr['key'], self::$attributes)) {
                $return[$attr['key']] = $attr['value'];
            }
        }
        
        return $return;
    }
    
    protected static function parseOtherItems(array $others)
    {
        foreach ($others as $other) {
            if (isset($other['attribute'])) {
                $insert = false;
                $data = [];
                if (empty(get_object_vars($other['attribute']))) {
                    foreach ($other['attribute'] as $attr) {
                        $attr = get_object_vars($attr);
        
                        if ($attr['@attributes']['key'] === 'weight') {
                            $insert = true;
                            $data['weight'] = $attr['@attributes']['value'];
                        }
                        if ($attr['@attributes']['key'] === 'description') {
                            $data['description'] = $attr['@attributes']['value'];
                        }
                    }
                } else {
                    $item = get_object_vars($other['attribute']);
                    
                    if ($item['@attributes']['key'] === 'weight') {
                        $insert = true;
                        $data['weight'] = $item['@attributes']['value'];
                    }
                    if ($item['@attributes']['key'] === 'description') {
                        $insert = true;
                        $data['description'] = $item['@attributes']['value'];
                    }
                }
                
                if ($insert && (bool) preg_match('/dead/i', $other['@attributes']['name']) === false) {
                    $data['name'] = $other['@attributes']['name'];
                    $data['cid'] = (int) $other['@attributes']['id'];
                    $data['type'] = 'item';
                    Item::insert($data);
                    self::getImage((int) $other['@attributes']['id'], $other['@attributes']['name'], 'items');
                }
            }
        }
    }
}
