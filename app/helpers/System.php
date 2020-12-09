<?php

namespace App\Helpers;

use App\Model\Boss;

class System
{
    public static function factory(): array
    {
        return [
            'bosses' => (bool)Boss::select(['id'])->where(['id', '=', 1])->findOrFail(),
        ];
    }
}
