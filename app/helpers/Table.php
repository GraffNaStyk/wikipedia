<?php

namespace App\Helpers;

class Table
{
    public static function prepareRowsAndCols (int $rows, int $cols, array $data)
    {
        if (empty($data)) {
            $return = [];
            for ($i = 0; $i < $rows; $i++) {
                $return['rows'][$i] = 0;
            }
    
            for ($i = 0; $i < $cols; $i++) {
                $return['cols'][$i] = 0;
            }
        }
        
       return $return;
    }
}
