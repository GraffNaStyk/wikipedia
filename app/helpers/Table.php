<?php

namespace App\Helpers;

class Table
{
    public static function prepareRowsAndCols(int $rows, int $cols, array $data): array
    {
        $return = [];
        
        for ($i = 0; $i < $rows; $i++) {
            if (! isset($data['rows'][$i])) {
                $return['rows'][$i] = [];
            } else {
                $return['rows'][$i] = $data['rows'][$i];
            }
        }

        for ($i = 0; $i < $cols; $i++) {
            if (! isset($data['cols'][$i])) {
                $return['cols'][$i] = '';
            } else {
                $return['cols'][$i] = $data['cols'][$i];
            }
        }
       return $return;
    }
}
