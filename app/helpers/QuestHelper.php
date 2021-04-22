<?php

namespace App\Helpers;

class QuestHelper
{
    private static array $levels = [
        -2 => 1,
        -1 => 2,
        1  => 3,
        2  => 4
    ];
    
    public static function setDifficulty(?int $difficulty): int
    {
        $stars = 0;
        
        for ($i = 0; $i < static::$levels[$difficulty]; $i++) {
            $stars++;
        }

        return $stars;
    }
}
