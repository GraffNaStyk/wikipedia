<?php
namespace App\Model;

use App\Db\Model;

class Quest extends Model
{
    public static string $table = 'quests';
    
    public static function getSnakeSum()
    {
        return self::query('SELECT SUM(snake_points) as snake FROM '.self::$table)[0]['snake'];
    }
    
    public static function getStatusSum()
    {
        return self::query('SELECT SUM(status_points) as status FROM '.self::$table)[0]['status'];
    }
}
