<?php

namespace App\Facades\Parser;

class Saga
{
    public static function parse()
    {
        if (is_readable(app('sagas_path'))) {
            foreach (json_decode(file_get_contents(app('sagas_path'))) as $name => $saga) {
                \App\Model\Saga::insert([
                    'name' => $name,
                    'order' => $saga->s_val,
                    'exp' => $saga->exp ?? null,
                    'hp'  => $saga->hp ?? null,
                    'ki' => $saga->ki ?? null,
                    'item' => $saga->item ?? null,
                    'count' => $saga->count ?? null,
                ]);
            }
        }
    }
}
