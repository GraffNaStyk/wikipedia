<?php

namespace App\Facades\Parser;

class Npcs
{
    public static function parse()
    {
        $npc = file_get_contents(app('npcs_path'));
        $npc = preg_replace('/--?.*/i', '', $npc);
        preg_match_all('/addSellableItem?.*/i', $npc, $matches);
        $items = [];
        
        foreach($matches[0] as $match) {
            $match = rtrim(trim(preg_replace("/addSellableItem\(\{'(.*)\'}/i", '', $match)), ')');
            $match = array_values(array_filter(explode(',', $match)));

            $items['sellable'][] = [
                'name' => trim(str_replace("'", '', $match[2])),
                'cid' => trim($match[0]),
                'price' => trim($match[1]),
            ];
        }
    
        preg_match_all('/addBuyableItem?.*/i', $npc, $matches);
        
        foreach($matches[0] as $match) {
            $match = rtrim(trim(preg_replace("/addBuyableItem\(\{'(.*)\'}/i", '', $match)), ')');
            $match = array_values(array_filter(explode(',', $match)));
            
            $items['buyable'][] = [
                'name' => trim(substr(str_replace("'", '', $match[2]), 0, -1)),
                'cid' => trim($match[0]),
                'price' => trim($match[1]),
            ];
        }
    }
}
