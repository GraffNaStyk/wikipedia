<?php
namespace App\Db\Migrate;

use App\Facades\Migrations\Schema;
use App\Model\Item;

class Migration_Item_2020_12_06__12_40
{
    public string $model = 'Item';

    public function up(Schema $schema)
    {
        if (! $schema->hasColumn(Item::$table, 'extra_def')) {
            $schema->alter('extra_def', 'smallint', 2, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'hit_chance')) {
            $schema->alter('hit_chance', 'smallint', 4, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'magic_hit_points')) {
            $schema->alter('magic_hit_points', 'int', 11, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'max_heal')) {
            $schema->alter('max_heal', 'int', 11, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'max_ki')) {
            $schema->alter('max_ki', 'int', 11, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'speed')) {
            $schema->alter('speed', 'int', 11, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'magic_hit_percent')) {
            $schema->alter('magic_hit_percent', 'int', 11, true, 'null', 'after level');
        }
    
        if (! $schema->hasColumn(Item::$table, 'heal_percent')) {
            $schema->alter('heal_percent', 'int', 11, true, 'null', 'after level');
        }
        
        $schema->run();
    }

    public function down(Schema $schema)
    {
        $schema->clear();
    }
}
