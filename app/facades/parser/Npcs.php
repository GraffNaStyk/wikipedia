<?php

namespace App\Facades\Parser;

use App\Model\CtNpcItem;
use App\Model\Npc;

class Npcs
{
    private static array $npcs;
    protected static string $toRemove = 'data/npc/scripts/';
    
    public static function parse()
    {
        foreach (glob(app('npcs_path').'/*', GLOB_BRACE) as $key => $npc) {
            $npc = get_object_vars(simplexml_load_file($npc))['@attributes'];
            static::$npcs[$key]['name'] = $npc['name'];
            
            $path = app('npcs_path').'/scripts/'.str_replace(static::$toRemove, '', $npc['script']);
            $npc = file_get_contents($path);
            
            static::$npcs[$key]['sellable'] = self::getSellable($npc);
            static::$npcs[$key]['buyable'] = self::getBuyable($npc);
        }

        foreach (static::$npcs as $npc) {
            if (empty($npc['name'])) {
                continue;
            }

            if ($res = Npc::select(['id'])->where(['name' ,'=', $npc['name']])->findOrFail()) {
                $id = $res['id'];
            } else {
                Npc::insert(['name' => $npc['name']]);
                $id = Npc::lastId();
            }
            
            foreach ($npc['sellable'] as $item) {
                CtNpcItem::insert([
                    'npc_id' => $id,
                    'item_cid' => $item['cid'],
                    'price' => $item['price'],
                    'type' => 'buy'
                ]);
            }
    
            foreach ($npc['buyable'] as $item) {
                CtNpcItem::insert([
                    'npc_id' => $id,
                    'item_cid' => $item['cid'],
                    'price' => $item['price'],
                    'type' => 'sell'
                ]);
            }
        }
        
    }
    
    private static function getSellable(string $plainScript): array
    {
        $npc = preg_replace('/--?.*/i', '', $plainScript);
        preg_match_all('/addSellableItem?.*/i', $npc, $matches);
        $items = [];
    
        foreach($matches[0] as $match) {
            $match = rtrim(trim(preg_replace("/addSellableItem\(\{'(.*)\'}/i", '', $match)), ')');
            $match = array_values(array_filter(explode(',', $match)));
        
            $items[] = [
                'cid' => trim($match[0]),
                'price' => trim($match[1]),
            ];
        }
        
        return $items;
    }
    
    private static function getBuyable(string $plainScript): array
    {
        $npc = preg_replace('/--?.*/i', '', $plainScript);
        preg_match_all('/addBuyableItem?.*/i', $npc, $matches);
        $items = [];
        
        foreach($matches[0] as $match) {
            $match = rtrim(trim(preg_replace("/addBuyableItem\(\{'(.*)\'}/i", '', $match)), ')');
            $match = rtrim(trim(preg_replace("/addBuyableItemContainer\(\{'(.*)\'}/i", '', $match)), ')');
            $match = array_values(array_filter(explode(',', $match)));
        
            $items[] = [
                'cid' => trim($match[0]),
                'price' => trim($match[1]),
            ];
        }
        
        return $items;
    }
}
