<?php
namespace App\Model;

use App\Db\Model;

class Achievement extends Model
{
    public static string $table = 'achievements';
    
    public static function sumOfStatusPoints()
    {
        return self::query('SELECT SUM(status_points) as total FROM '.self::$table)[0]['total'];
    }
}
