<?php

namespace App\Facades\Parser;

class Items
{
    protected static array $itemTypes = [
        'sword', 'distance', 'axe', 'fist',
        'body', 'legs', 'feet'
    ];
    
    protected static array $attributes = [
        'attack', 'defense', 'armor', 'description',
        'range'
    ];
    
    protected static array $return = [
        'axe' => [],
        'sword' => [],
        'fist' => [],
        'distance' => [],
        'body' => [],
        'legs' => [],
        'feet' => []
    ];
    
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
    }
    
    protected static function isInTypes($item)
    {
        if (!isset($item['attribute'])) {
            return false;
        }
        
        $exist = false;
        $key = false;
        
        foreach ($item['attribute'] as $attr) {
            $attr = get_object_vars($attr['value'])[0];
            
            if (in_array($attr, self::$itemTypes)) {
                $key = $attr;
                $exist = true;
                break;
            }
        }
        
        if ($exist) {
            return $key;
        }
        
        return false;
    }
    
    protected static function getAttributes($item)
    {
        $return = [
            'name' => $item['@attributes']['name'],
            'cid' => $item['@attributes']['id']
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
