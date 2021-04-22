<?php

namespace App\Facades\Parser;

use App\Model\Item;

class Movements
{
    public static function parse()
    {
        if (is_readable(app('movements_path'))) {
            foreach (simplexml_load_file(app('movements_path')) as $event) {
                $event = get_object_vars($event)['@attributes'];
                
                if ( ! isset($event['level']) && ! isset($item['itemid'])) {
                    continue;
                }
                
                $item = Item::where(['cid', '=', $event['itemid']])->update(['level' => $event['level']]);
            }
        }
    }
}
