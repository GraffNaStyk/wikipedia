<?php

namespace App\Facades\Parser;

use App\Model\Item;

class Items
{
    protected static array $itemTypes = [
        'sword', 'distance', 'axe', 'fist',
        'body', 'legs', 'feet', 'head', 'ring',
        'necklace'
    ];
    
    protected static array $attributes = [
        'attack', 'defense', 'armor',
        'description', 'range'
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
        if (file_exists(app['items_path'])) {
            foreach (simplexml_load_file(app['items_path']) as $key => $item) {
                $item = get_object_vars($item);
                $key = self::isInTypes($item);
                
                if ((bool) $key === true) {
                    self::$return[$key][] = self::getAttributes($item);
                }
            }
        } else {
            exit('file not exist');
        }
        
        foreach (self::$return as $key => $items) {
            foreach ($items as $item) {
                $item['type'] = self::$mapTypeToModel[$key];
                Item::insert($item);
            }
        }
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
}
